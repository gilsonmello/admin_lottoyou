<?php

App::uses('AppModel', 'Model');

/**
 * Class LeaCupKey
 */
class LeaCupTeam extends AppModel {

    /**
     * @var string
     */
    public $useTable = 'lea_cup_teams';

    /**
     * @var array
     */
    public $belongsTo = [
    	'League' => [
            'className' => 'League',
            'foreignKey' => 'league_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'CartoleandoTeam' => [
            'className' => 'CartoleandoTeam',
            'foreignKey' => 'team_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
	];

    /**
     * @var array
     */
    public $hasAndBelongsToMany = [

    ];

    /**
     * @var array
     */
	public $hasMany = [
    	
	];


//    public $order = 'SocBolao.nome ASC';
//    
    //public $displayField = 'name';
//
    /**
     * @var array
     */
    public $virtualFields = [

    ];

    /**
     * @var array
     */
    public $validate = [

    ];

    /**
     * @param array $options
     * @return bool|void
     */
    public function beforeValidate($options = array())
    {

    }

    /**
     * @param array $options
     * @return bool
     */
    public function beforeSave($options = array())
    {
        return true;
    }

    /**
     * @param bool $created
     * @param array $options
     */
    public function afterSave($created, $options = []) {

    }

}
