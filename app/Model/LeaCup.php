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
	];

    public $hasAndBelongsToMany = [
        'LeaPackage' => [
            'className'             => 'LeaPackage',
            'joinTable'             => 'lea_packages_has_lea_cups',
            'foreignKey'            => 'league_id',
            'associationForeignKey' => 'lea_cup_id'
        ]
    ];

	public $hasMany = [
    	
	];


//    public $order = 'SocBolao.nome ASC';
//    
    public $displayField = 'name';
//    
    public $virtualFields = [
        'ativo' => "CASE WHEN LeaCup.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN LeaCup.active = 1 THEN 'success' ELSE 'danger' END",
        'aberto' => "CASE WHEN LeaCup.open = 1 THEN 'Sim' ELSE 'Não' END",
        'aberto_label' => "CASE WHEN LeaCup.open = 1 THEN 'success' ELSE 'danger' END",
    ];

    public $validate = [
        'name' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
            /*'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Nome em uso. Favor informar outro.'
            )*/
        ],
        'slug' => [
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
        'small_description' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],
        'award_method' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],
        'active' => [
            'required' => [
                'rule' => ['notEmpty'],
                'message' => 'Campo obrigatório'
            ]
        ],
    ];

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

    public function afterSave($created, $options = []) {
        if(!empty($this->request->data['League']['bg_image']['name'])) {
            //$this->data['League']['bg_image']['name'] =
            $league = $this->data['League'];
            $bg_image = $league['slug'].''.substr($this->request->data['League']['bg_image']['name'], -4);
            $this->request->data['League']['bg_image']['name'] = $bg_image;
            $name_image = 'files/Leagues_Bg_Image/';
            $name_image .= $this->upload($this->request->data['League']['bg_image'], 'files\Leagues_Bg_Image', false);
            $now = date('Y-m-d H:i:s');

            $query = "UPDATE lea_cups SET lea_cups.bg_image_domain = '".SITE_URL."' ";
            $query .= ", lea_cups.bg_image = '$name_image' ";
            $query .= ", lea_cups.updated_at = '$now' ";
            $query .= 'WHERE lea_cups.id = '.$league['id'];

            $this->query($query);
        }
    }

}
