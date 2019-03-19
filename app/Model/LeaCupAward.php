<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class LeaCupAward extends AppModel {

    public $useTable = 'lea_cup_awards';

    public $belongsTo = [
    	'LeagueAward' => [
            'className' => 'LeagueAward',
            'foreignKey' => 'league_award_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
	];

	public $hasMany = [
	];

    public $validate = [
    ];

    public function beforeValidate($options = array())
    {
        parent::beforeValidate($options);
    }

    public function beforeSave($options = array())
    {
        return true;
    }

}
