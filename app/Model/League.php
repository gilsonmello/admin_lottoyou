<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class League extends AppModel {

    public $useTable = 'leagues';

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
            'joinTable'             => 'lea_packages_has_leagues',
            'foreignKey'            => 'league_id',
            'associationForeignKey' => 'lea_package_id'
        ]
    ];

	public $hasMany = [
    	
	];


//    public $order = 'SocBolao.nome ASC';
//    
    public $displayField = 'name';
//    
    public $virtualFields = [
        'ativo' => "CASE WHEN League.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN League.active = 1 THEN 'success' ELSE 'danger' END",
        'aberto' => "CASE WHEN League.open = 1 THEN 'Sim' ELSE 'Não' END",
        'aberto_label' => "CASE WHEN League.open = 1 THEN 'success' ELSE 'danger' END",
    ];

    public $validate = [
        'lea_package_id' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],
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
            'unique' => [
                'rule' => 'isUnique',
                'message' => 'Slug em uso. Favor informar outro.'
            ]
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
        /*'type_award_id' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],*/
        'active' => [
            'required' => [
                'rule' => ['notEmpty'],
                'message' => 'Campo obrigatório'
            ]
        ],
        /*'min_players' => [
            'required' => [
                'rule' => ['notEmpty'],
                'message' => 'Campo obrigatório'
            ]
        ],*/
    ];

    /**
     * @param array $options
     * @return bool
     */
    public function beforeSave($options = array())
    {
        /*if($this->data[$this->alias]['max_players'] == '') {
            $this->data[$this->alias]['max_players'] = null;
        }

        if($this->data[$this->alias]['min_players'] == '') {
            $this->data[$this->alias]['min_players'] = 1;
        }*/

        /*$now = date('Y-m-d H:i:s');
        if (!$this->id && !isset($this->data[$this->alias][$this->primaryKey])) {
            //insert
            $this->data[$this->alias]['created_at'] = $now;
            $this->data[$this->alias]['updated_at'] = $now;
        } else {
            //edit
            $this->data[$this->alias]['updated_at'] = $now;
        }*/
        return parent::beforeSave($options);
    }

    /**
     * @param bool $created
     * @param array $options
     */
    public function afterSave($created, $options = [])
    {
        if (isset($this->request->data) && count($this->request->data) > 0 && isset($this->request->data['League'])) {
            if (!empty($this->request->data['League']['bg_image']['name'])) {
                //$this->data['League']['bg_image']['name'] =
                $league = $this->data['League'];
                //$bg_image = $league['slug'].''.substr($this->request->data['League']['bg_image']['name'], -4);
                $bg_image = explode('.', $this->request->data['League']['bg_image']['name']);
                $bg_image = $league['slug'] . '.' . $bg_image[count($bg_image) - 1];
                $this->request->data['League']['bg_image']['name'] = $bg_image;
                $name_image = 'files/Leagues_Bg_Image/';
                $name_image .= $this->upload($this->request->data['League']['bg_image'], 'files/Leagues_Bg_Image', false);
                $now = date('Y-m-d H:i:s');

                $query = "UPDATE leagues SET leagues.bg_image_domain = '" . SITE_URL . "' ";
                $query .= ", leagues.bg_image = '$name_image' ";
                $query .= ", leagues.modified = '$now' ";
                $query .= 'WHERE leagues.id = ' . $league['id'];

                $this->query($query);
            }
        }
    }

    /**
     * @param bool $cascade
     * @return bool
     */
    public function beforeDelete($cascade = false) {
        $data = $this->findById($this->id);
        $file = new File($data[$this->alias]['bg_image']);
        $file->delete();
        return true;
    }
}
