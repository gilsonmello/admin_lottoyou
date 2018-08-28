<?php

App::uses('AppModel', 'Model');

/**
 * Class LeagueAward
 */
class LeagueAward extends AppModel {

    public $useTable = 'league_awards';

    public $belongsTo = [
    	'League' => [
            'className' => 'League',
            'foreignKey' => 'league_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
	];

	public $hasMany = [
    	
	];

//    public $order = 'SocBolao.nome ASC';
    public $displayField = 'name';

    /**
     * @var array
     */
    public $virtualFields = [
        /*'ativo' => "CASE WHEN League.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN League.active = 1 THEN 'success' ELSE 'danger' END",
        'aberto' => "CASE WHEN League.open = 1 THEN 'Sim' ELSE 'Não' END",
        'aberto_label' => "CASE WHEN League.open = 1 THEN 'success' ELSE 'danger' END",*/
    ];

    /**
     * @var array
     */
    public $validate = [
        'position' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],
        'value' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],
        'league_id' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],
        'type' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],
        'type_description' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],
    ];

    /**
     * @param $id
     * @return mixed
     */
    public function league($id) {
        return $this->League->read(null, $id);
    }

    /**
     * @param array $options
     * @return bool|void
     */
    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        if(isset($this->data[$this->alias]['type'])) {
            //Se for do tipo ilimitado, não é necessário o campo limite,
            //Removo o campo limite da validação
            if($this->data[$this->alias]['type'] != '3') {
                unset($this->validate['type_description']);
            }

            if($this->data[$this->alias]['type'] == '2' || $this->data[$this->alias]['type'] == '3') {
                $this->data[$this->alias]['value'] = null;
                unset($this->validate['value']);
            }
        }
    }

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

}
