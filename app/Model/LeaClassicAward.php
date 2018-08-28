<?php

App::uses('AppModel', 'Model');

/**
 * Class LeaClassicAward
 */
class LeaClassicAward extends AppModel {

    /**
     * @var string
     */
    public $useTable = 'lea_classic_awards';

    /**
     * @var array
     */
    public $belongsTo = [
    	'LeagueAward' => [
            'className' => 'LeagueAward',
            'foreignKey' => 'league_award_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
	];

    /**
     * @var array
     */
	public $hasMany = [
    	
	];

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

    public function beforeSave($options = array())
    {
        return true;
    }

}
