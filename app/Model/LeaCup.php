<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class LeaCup extends AppModel {

    public $useTable = 'lea_cups';

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

    public function beforeValidate($options = array())
    {
        return parent::beforeValidate($options);
    }

    public function beforeSave($options = array())
    {
        return true;
    }

    public function afterSave($created, $options = []) {
        parent::afterSave($created, $options);
    }

}
