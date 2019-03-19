<?php

App::uses('AppModel', 'Model');

/**
 * Class LeaCupStep
 */
class LeaCupStep extends AppModel {

    /**
     * @var string
     */
    public $useTable = 'lea_cup_steps';

    /**
     * @var array
     */
    public $belongsTo = [
    	'LeaCup' => [
            'className' => 'LeaCup',
            'foreignKey' => 'lea_cup_id',
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
