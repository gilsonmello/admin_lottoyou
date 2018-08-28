<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class LeaClassic extends AppModel {

    public $useTable = 'lea_classics';

    public $belongsTo = [
    	'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'League' => [
            'className' => 'League',
            'foreignKey' => 'league_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
	];

    public $hasAndBelongsToMany = [

    ];

	public $hasMany = [
    	
	];


//    public $order = 'SocBolao.nome ASC';
//    
    //public $displayField = 'name';
//    
    public $virtualFields = [

    ];

    public $validate = [

    ];

    public function beforeSave($options = array())
    {
        /*$now = date('Y-m-d H:i:s');
        if (!$this->id && !isset($this->data[$this->alias][$this->primaryKey])) {
            //insert
            $this->data[$this->alias]['created_at'] = $now;
            $this->data[$this->alias]['updated_at'] = $now;
        } else {
            //edit
            $this->data[$this->alias]['updated_at'] = $now;
        }*/
        return true;
    }

    public function afterSave($created, $options = []) {

    }

}
