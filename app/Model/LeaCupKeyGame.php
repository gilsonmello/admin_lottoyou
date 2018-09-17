<?php

App::uses('AppModel', 'Model');

/**
 * Class LeaCupKeyGame
 */
class LeaCupKeyGame extends AppModel {

    /**
     * @var string
     */
    public $useTable = 'lea_cup_key_games';

    /**
     * @var array
     */
    public $belongsTo = [
    	'LeaCupKey' => [
            'className' => 'LeaCupKey',
            'foreignKey' => 'lea_cup_key_id',
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
    public $virtualFields = [

    ];

    public $validate = [

    ];

    public function beforeValidate($options = array())
    {

    }

    public function beforeSave($options = array())
    {
        return true;
    }

    public function afterSave($created, $options = []) {

    }

}
