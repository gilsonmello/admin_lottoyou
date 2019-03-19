<?php

App::uses('AppModel', 'Model');

/**
 * Class LeaCupKey
 */
class LeaCupKey extends AppModel {

    /**
     * @var string
     */
    public $useTable = 'lea_cup_keys';

    /**
     * @var array
     */
    public $belongsTo = [
    	'LeaCupStep' => [
            'className' => 'LeaCupStep',
            'foreignKey' => 'lea_cup_step_id',
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
        parent::beforeValidate($options);
    }

    /**
     * @param array $options
     * @return bool
     */
    public function beforeSave($options = array())
    {
        parent::beforeSave($options);
        return true;
    }

    /**
     * @param bool $created
     * @param array $options
     */
    public function afterSave($created, $options = []) {
        parent::afterSave($created, $options);
    }

}
