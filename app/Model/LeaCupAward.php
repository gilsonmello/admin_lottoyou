<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class LeaCupAward extends AppModel {

    public $useTable = 'lea_cup_awards';

    public $belongsTo = [
    	'LeaCup' => [
            'className' => 'LeaCup',
            'foreignKey' => 'lea_cup_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
	];

	public $hasMany = [
    	
	];


//    public $order = 'SocBolao.nome ASC';
//    
    public $displayField = 'name';
//    
    public $virtualFields = [
        /*'ativo' => "CASE WHEN LeaCup.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN LeaCup.active = 1 THEN 'success' ELSE 'danger' END",
        'aberto' => "CASE WHEN LeaCup.open = 1 THEN 'Sim' ELSE 'Não' END",
        'aberto_label' => "CASE WHEN LeaCup.open = 1 THEN 'success' ELSE 'danger' END",*/
    ];

    public $validate = [
        'position' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
            'unique' => [
                'rule' => 'isUnique',
                'message' => 'Posição em uso. Favor informar outra.'
            ]
        ],
        'value' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],
        'lea_cup_id' => [
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

    public function leaCup($id) {
        return $this->LeaCup->read(null, $id);
    }

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
