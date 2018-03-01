<?php
/**
 * SegLogs saves and deletes of any model
 * 
 * Requires the following to work as intended :
 * 
 * - "SegLog" model ( empty but for a order variable [created DESC]
 * - "SegLogs" table with these fields required :
 *     - id			[int]			: 
 *     - title 		[string] 		: automagically filled with the display field of the model that was modified.
 * 	   - created	[date/datetime] : filled by cake in normal way
 * 
 * - actsAs = array("SegLogable"); on models that should be SegLogged
 * 
 * Optional extra table fields for the "SegLogs" table :
 * 
 * - "description" 	[string] : Fill with a descriptive text of what, who and to which model/row :  
 * 								"Contact "John Smith"(34) added by User "Administrator"(1).
 * 
 * or if u want more detail, add any combination of the following :
 * 
 * - "model"    	[string] : automagically filled with the class name of the model that generated the activity.
 * - "model_id" 	[int]	 : automagically filled with the primary key of the model that was modified.
 * - "action"   	[string] : automagically filled with what action is made (add/edit/delete) 
 * - "user_id"  	[int]    : populated with the supplied user info. (May be renamed. See bellow.)
 * - "change"   	[string] : depending on setting either : 
 * 							[name (alek) => (Alek), age (28) => (29)] or [name, age]
 * 
 * - "version_id"	[int]	 : cooperates with RevisionBehavior to link the the shadow table (thus linking to old data)
 * 
 * Remember that SegLogable behavior needs to be added after RevisionBehavior. In fact, just put it last to be safe.
 * 
 * Optionally register what user was responisble for the activity :
 * 
 * - Supply configuration only if defaults are wrong. Example given with defaults :
 * 
 * class Apple extends AppModel {
 * 		var $name = 'Apple';
 * 		var $actsAs = array('SegLogable' => array('userModel' => 'User', 'userKey' => 'user_id'));
 *  [..]
 * 
 * - In AppController (or single controller if only needed once) add these lines to beforeFilter : 
 * 
 *   	if (sizeof($this->uses) && $this->{$this->modelClass}->Behaviors->attached('SegLogable')) {
 *			$this->{$this->modelClass}->setUserData($this->activeUser);
 *		}
 *
 *   Where "$activeUser" should be an array in the standard format for the User model used :
 * 
 *   $activeUser = array( $UserModel->alias => array( $UserModel->primaryKey => 123, $UserModel->displayField => 'Alexander'));
 *   // any other key is just ignored by this behaviour.
 * 
 * @author Alexander Morland (alexander#maritimecolours.no)
 * @co-author Eskil Mjelva Saatvedt
 * @co-author Ronny Vindenes
 * @co-author Carl Erik Fyllingen
 * @category Behavior
 * @version 2.1
 * @modified 27.jan 2008 by alexander
 */

class LogableBehavior extends ModelBehavior {

	public $user = NULL;
	public $UserModel = FALSE;
    public $settings = array();
	public $defaults = array(
		'userModel' => 'User',
		'userKey' => 'user_id',
		'change' => 'full',
        'description' => null,
		'description_ids' => TRUE,
		'skip' => array(),
		'ignore' => array(),
        'fields' => null,
        'cascade' => null
	);

	/**
	 * Cake called intializer
	 * Config options are :
	 *    userModel 		: 'User'. Class name of the user model you want to use (User by default), if you want to save User in SegLog
	 *    userKey   		: 'user_id'. The field for saving the user to (user_id by default).
	 * 	  change    		: 'list' > [name, age]. Set to 'full' for [name (alek) => (Alek), age (28) => (29)]
	 * 	  description_ids 	: TRUE. Set to FALSE to not include model id and user id in the title field
	 *    skip  			: array(). String array of actions to not Log
	 *
	 * @param Object $Model
	 * @param array $config
	 */
	function setup(Model $Model, $config = array()) {
        if (!is_array($config)) {
			$config = array();
		}	

		$this->settings[$Model->alias] = array_merge($this->defaults, $config);
		$this->settings[$Model->alias]['ignore'][] = $Model->primaryKey; 
		
		App::import('model','SegLog');
		$this->SegLog = new SegLog();

		if ($this->settings[$Model->alias]['userModel'] != $Model->alias) {
			if (App::import('model', $this->settings[$Model->alias]['userModel'])) {
	        	$this->UserModel = new $this->settings[$Model->alias]['userModel']();
	        }
		} else {
			$this->UserModel = $Model;
		}
	}
	
	function settings(Model $Model) {
		return $this->settings[$Model->alias];
	}
	
	/**
	 * Useful for getting SegLogs for a model, takes params to narrow find. 
	 * This method can actually also be used to find SegLogs for all models or
	 * even another model. Using no params will return all activities for
	 * the models it is called from.
	 *
	 * Possible params :
	 * 'model' 		: mixed  (NULL) String with className, NULL to get current or FALSE to get everything
	 * 'action' 	: string (NULL) String with action (add/edit/delete), NULL gets all
	 * 'order' 		: string ('created DESC') String with custom order
	 * 'conditions  : array  (array()) Add custom conditions
	 * 'model_id'	: int	 (NULL) Add a int 
	 * 
	 * (remember to use your own user key if you're not using 'user_id')
	 * 'user_id' 	: int 	 (NULL) Defaults to all users, supply id if you want for only one User
	 * 
	 * @param Object $Model
	 * @param array $params
	 * @return array
	 */
	function findSegLog(Model $Model, $params = array()) {
		$defaults = array(
			 'model' => NULL,
			 'action' => NULL,
			 'order' => 'created DESC',
			 $this->settings[$Model->alias]['userKey'] => NULL,
			 'conditions' => array(),
			 'model_id' => NULL,
			 'fields' => array(),
			 'limit' => 50,
		);
		$params = array_merge($defaults, $params = array());
		$options = array('order' => $params['order'], 'conditions' => $params['conditions'], 'fields' => $params['fields'], 'limit' => $params['limit']);
	   
        $schema = $this->SegLog->schema();

        if ($params['model'] === NULL) {
			$params['model'] = $Model->alias;
		}

		if ($params['model']) {
	    	if (isset($schema['model'])) {
	    		$options['conditions']['model'] = $params['model'];
	    	} elseif (isset($schema['description'])) {    		
	    		$options['conditions']['description LIKE '] = $params['model'].'%';
	    	} else {
	    		return FALSE;
	    	}
		}

    	if ($params['action'] && isset($schema['action'])) {
    		$options['conditions']['action'] = $params['action'];
    	} 

		if ($params[ $this->settings[$Model->alias]['userKey'] ] && $this->UserModel && is_numeric($params[ $this->settings[$Model->alias]['userKey'] ])) {
			$options['conditions'][$this->settings[$Model->alias]['userKey']] = $params[ $this->settings[$Model->alias]['userKey'] ];
		}

		if ($params['model_id'] && is_numeric($params['model_id'])) {
			$options['conditions']['model_id'] = $params['model_id'];
		}

    	return $this->SegLog->find('all',$options);
	}
	
	/**
     * Use this to supply a model with the data of the SegLogged in User.
     * Intended to be called in AppController::beforeFilter like this :
     *   
 	 *   	if ($this->{$this->modelClass}->Behaviors->attached('SegLogable')) {
 	 *			$this->{$this->modelClass}->setUserData($activeUser);/
 	 *		}
     *
     * The $userData array is expected to look like the result of a 
     * User::find(array('id'=>123));
     * 
     * @param Object $Model
     * @param array $userData
     */
	function setUserData(Model $Model, $userData = null) {
		if ($userData) {
			$this->user = $userData;
		}
	}
		
	/**
	 * Used for SegLogging custom actions that arent crud, like SegLogin or download.
	 *
	 * @example $this->Boat->customSegLog('ship', 66, array('title' => 'Titanic heads out'));
	 * @param Object $Model
	 * @param string $action name of action that is taking place (dont use the crud ones)
	 * @param int $id  id of the SegLogged item (ie model_id in SegLogs table)
	 * @param array $values optional other values for your SegLogs table
	 */
	function customLog(Model $Model, $action, $id, $values = array()) {		
        $schema = $this->SegLog->schema();
		$LogData['SegLog'] = $values;

		/** @todo clean up $LogData */
		if (isset($schema['model_id']) && is_numeric($id)) {
			$LogData['SegLog']['model_id'] = $id;
		}

		$title = NULL;

		if (isset($values['title'])) {
    		$title = $values['title']; 
    		unset($LogData['SegLog']['title']);
		}

    	$LogData['SegLog']['action'] = $action;
    	$this->_saveLog($Model, $LogData, $title);
	}
	
	function clearUserData(Model $Model) {
		$this->user = NULL;
	}
	
	function beforeDelete(Model $Model, $cascade = true) {
		if (in_array('delete', $this->settings[$Model->alias]['skip'])) {
			return true;
		}

		$Model->recursive = -1;
		$Model->read();

		// MUDA AS ONCFIGURAÇÕES QUANDO FOR NECESSÁRIO DELETAR EM CASCATA
		if ($cascade == 'T'){
			$this->settings[$Model->alias]['cascade'] = $cascade;
		}

		return true;
	}
	
	function afterDelete(Model $Model, $options = array()) {
		$LogData = array();
        $schema = $this->SegLog->schema();
        $settings = $this->settings[$Model->alias];

        if (in_array('delete', $settings['skip'])) {
            return true;
        }

		if (isset($schema['description'])) {
		 	
            $description = '';

		 	if (isset($Model->data[$Model->alias][$Model->displayField]) && $Model->displayField != $Model->primaryKey) {
		 		$description = $Model->data[$Model->alias][$Model->displayField];
		 	}

			if ($settings['description_ids']) {
				//$LogData['SegLog']['description'] .= ' ('.$Model->id.') ';
			}

            $LogData['SegLog']['description'] = sprintf($settings['description']['delete'], $description);

            // MUDA A DESCRIÇÃO QUANDO A EXCLUSÃO É EM CASCATA
            if ($settings['cascade'] == 'T'){
            	$LogData['SegLog']['description'] .= ' e todas na sequência (demais parcelas)';
            }
		}

    	$LogData['SegLog']['action'] = 'delete'; 	
    	$this->_saveLog($Model, $LogData);
	}
    
	function beforeSave(Model $Model, $options = array()) {
        $schema = $this->SegLog->schema();

        if (isset($schema['change']) && $Model->id) {
        	$this->old = $Model->find('first',array('conditions'=>array($Model->primaryKey => $Model->id),'recursive'=>-1));
        }

        return true;
	}
	
    function afterSave(Model $Model, $created, $options = array()) {
        // INICIALIZA VARIÁEIS
        $settings = $this->settings[$Model->alias];
        $schema = $this->SegLog->schema();

		if (in_array('add',$settings['skip']) && $created) {
			return true;
		} elseif (in_array('edit',$settings['skip']) && !$created) {
			return true;
		}

		$keys = array_keys($Model->data[$Model->alias]);
		$diff = array_diff($keys, $settings['ignore']);

		if (sizeof($diff) == 0 && empty($Model->SegLogableAction)) {
			return false;
		}

     	if ($Model->id) {
    		$id = $Model->id;
    	} elseif ($Model->insertId) {
    		$id = $Model->insertId;
    	}

        if (isset($schema['model_id'])) {
   			$LogData['SegLog']['model_id'] = $id;
    	}   

		if (isset($schema['action'])) {					
	    	if ($created) {
	    		$LogData['SegLog']['action'] = 'add';
	    	} else { 
	    		$LogData['SegLog']['action'] = 'edit'; 		
	    	}  
		}

        if (isset($schema['description'])) {
            $description = '';

            if (isset($Model->data[$Model->alias][$Model->displayField]) && $Model->displayField != $Model->primaryKey) {
                $description = $Model->data[$Model->alias][$Model->displayField];
            }

            $LogData['SegLog']['description'] = sprintf($settings['description'][$LogData['SegLog']['action']], $description);
        }  

    	if (isset($schema['change'])) {

    		$LogData['SegLog']['change'] = '';
    		$db_fields = array_keys($Model->schema());
    		$changed_fields = array();

    		foreach ($Model->data[$Model->alias] as $key => $value) {
    			if (isset($Model->data[$Model->alias][$Model->primaryKey]) && !empty($this->old) && isset($this->old[$Model->alias][$key])) {
    				$old = $this->old[$Model->alias][$key];
    			} else {
    				$old = '';
    			}

                if (is_date($old)) $old = convertDate($old);

                if ($old == '.00') $old = null;

    			if ($key != 'modified' 
	    			&& !in_array($key, $settings['ignore'])
	    			&& $value != $old && in_array($key,$db_fields) ) {

    				if ($settings['change'] == 'full') {
    					$changed_fields[] = array($key=>array($old=>$value));
    				} else {
    					$changed_fields[] = $key;	
    				}    				
    			}

                if ($settings['fields'] != null){
                    if (in_array($key, $settings['fields'])){
                        $LogData['SegLog']['description'] .= '|'.$value;
                    }
                }
    		}

    		$changes = sizeof($changed_fields);

    		if ($changed_fields == 0) {
    			return true;
    		} 

    		$LogData['SegLog']['change'] = json_encode($changed_fields);
    		$LogData['SegLog']['changes'] = $changes;		
    	}  

    	$this->_saveLog($Model, $LogData);
    }
    
    /**
     * Does the actual saving of the SegLog model. Also adds the special field if possible.
     * 
     * If model field in table, add the Model->alias
     * If action field is NOT in table, remove it from dataset
     * If the userKey field in table, add it to dataset
     * If userData is supplied to model, add it to the title 
     *
     * @param Object $Model
     * @param array $LogData
     */
    function _saveLog(Model $Model, $LogData, $title = null) {  
    	if ($title !== NULL) {
    		$LogData['SegLog']['title'] = $title;
    	} elseif ($Model->displayField == $Model->primaryKey) {
    		$LogData['SegLog']['title'] = $Model->alias;
    		$LogData['SegLog']['title'] .= ' ('. $Model->id.')';
    	} elseif (isset($Model->data[$Model->alias][$Model->displayField])) {
    		$LogData['SegLog']['title'] = $Model->data[$Model->alias][$Model->displayField];
    	} else {
            $aux = $Model->data;
    		$Model->recursive = -1;
    		$Model->read(array($Model->displayField));

            $Model->data = array_merge_recursive($aux, $Model->data);

    		$LogData['SegLog']['title'] = $Model->data[$Model->alias][$Model->displayField];
    	}
        
        $schema = $this->SegLog->schema();		
        
    	if (isset($schema['model'])) {
    		$LogData['SegLog']['model'] = $Model->alias;
    	}
    	
    	if (isset($schema['model_id']) && !isset($LogData['SegLog']['model_id'])) {
    		if ($Model->id) {
    			$LogData['SegLog']['model_id'] = $Model->id;
    		} elseif ($Model->insertId) {
    			$LogData['SegLog']['model_id'] = $Model->insertId;
    		}     		
    	}
		
    	if (!isset($schema['action'])) {
    		unset($LogData['SegLog']['action']);
    	} elseif (isset($Model->SegLogableAction) && !empty($Model->SegLogableAction)) {
    		$LogData['SegLog']['action'] = implode(',',$Model->SegLogableAction); // . ' ' . $LogData['SegLog']['action'];
    		unset($Model->SegLogableAction);
    	}
    	
    	/*if (isset($schema['version_id']) && isset($Model->version_id)) {
    		$LogData['SegLog']['version_id'] = $Model->version_id;
    		unset($Model->version_id);
    	}*/
    	
    	if (isset($schema['ip'])) {
    		$LogData['SegLog']['ip'] = get_client_ip();
    	}
    	
    	if (isset($schema[$this->settings[$Model->alias]['userKey']]) && $this->user) {
    		$LogData['SegLog'][$this->settings[$Model->alias]['userKey']] = $this->user[$this->UserModel->alias][$this->UserModel->primaryKey];
    	}  	
    	
        if (isset($schema['description'])) {
        	if ($this->user && $this->UserModel) {
        		$LogData['SegLog']['description'] .= '|'. $this->user[$this->UserModel->alias][$this->UserModel->displayField];
                $LogData['SegLog']['user_name'] = $this->user[$this->UserModel->alias][$this->UserModel->displayField];
        		/*if ($this->settings[$Model->alias]['description_ids']) {
        			$LogData['SegLog']['description'] .= ' ('.$this->user[$this->UserModel->alias][$this->UserModel->primaryKey].')';
        		}*/
        	} else { 
        		// UserModel is active, but the data hasnt been set. Assume system action.
        		$LogData['SegLog']['description'] .= '|Sistema';
                $LogData['SegLog']['user_name'] = 'Sistema';
        	}
    	} 	

        // INCLUI OS DADOS DO MODEL ANTES DE SALVAR
        $LogData[$Model->alias] = $Model->data[$Model->alias];

    	$this->SegLog->create($LogData);
    	$this->SegLog->save(NULL,FALSE);    	
    }
}