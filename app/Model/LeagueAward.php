<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
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
//    
    public $displayField = 'name';
//    
    public $virtualFields = [
        /*'ativo' => "CASE WHEN League.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN League.active = 1 THEN 'success' ELSE 'danger' END",
        'aberto' => "CASE WHEN League.open = 1 THEN 'Sim' ELSE 'Não' END",
        'aberto_label' => "CASE WHEN League.open = 1 THEN 'success' ELSE 'danger' END",*/
    ];

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
    ];

    public function league($id) {
        return $this->League->read(null, $id);
    }

    public function beforeSave($options = array())
    {
        $now = date('Y-m-d H:i:s');
        if (!$this->id && !isset($this->data[$this->alias][$this->primaryKey])) {
            //insert
            $this->data[$this->alias]['created_at'] = $now;
            $this->data[$this->alias]['updated_at'] = $now;
        } else {
            //edit
            $this->data[$this->alias]['updated_at'] = $now;
        }
        return true;
    }

}
