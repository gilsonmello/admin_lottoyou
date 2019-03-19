<?php

App::uses('AppModel', 'Model');

/**
 * Class LeaCupKey
 */
class LeaClassicTeamPoint extends AppModel {

    /**
     * @var string
     */
    public $useTable = 'lea_classic_team_points';

    /**
     * @var array
     */
    public $belongsTo = [
        'LeaClassicTeam' => [
            'className' => 'LeaClassicTeam',
            'foreignKey' => 'lea_classic_team_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'LeaClassic' => [
            'className' => 'LeaClassic',
            'foreignKey' => 'lea_classic_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
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
