<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class LeaPackage extends AppModel {

    public $useTable = 'lea_packages';

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
        'League' => [
            'className'             => 'League',
            'joinTable'             => 'lea_packages_has_leagues',
            'foreignKey'            => 'lea_package_id',
            'associationForeignKey' => 'league_id'
        ],
    ];

	public $hasMany = [
    	
	];


//    public $order = 'SocBolao.nome ASC';
//    
    public $displayField = 'name';
//    
    public $virtualFields = [
        'ativo' => "CASE WHEN LeaPackage.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN LeaPackage.active = 1 THEN 'success' ELSE 'danger' END",
        'novo' => "CASE WHEN LeaPackage.new = 1 THEN 'Sim' ELSE 'Não' END",
        'novo_label' => "CASE WHEN LeaPackage.new = 1 THEN 'success' ELSE 'danger' END",
    ];

    public $validate = [
        'league_id' => [
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
        'active' => [
            'required' => [
                'rule' => ['notEmpty'],
                'message' => 'Campo obrigatório'
            ]
        ],
    ];

    public function beforeSave($options = array())
    {
        return true;
    }

    public function afterSave($created, $options = []) {

        //Dados das Ligas
        $dados = $this->_extractFieldsHABTM($this->data['LeaPackage']['league_id'], $this->data['LeaPackage']['id'], 'lea_package_id', 'league_id');

        // APAGA REGISTROS RELACIONADOS AO ID das ligas
        $this->LeaPackagesHasLeague->deleteAll(array('lea_package_id' => $this->data['LeaPackage']['id']));

        // ASSOCIA PERMISSÕES A FUNCIONALIDADE das ligas
        $this->LeaPackagesHasLeague->saveAll($dados);

        if(!empty($this->request->data['LeaPackage']['bg_image']['name'])) {
            //$this->data['LeaPackage']['bg_image']['name'] =
            $package = $this->data['LeaPackage'];
            $bg_image = $package['slug'].''.substr($this->request->data['LeaPackage']['bg_image']['name'], -4);
            $this->request->data['LeaPackage']['bg_image']['name'] = $bg_image;
            $name_image = 'files/LeaPackages_Bg_Image/';
            $name_image .= $this->upload($this->request->data['LeaPackage']['bg_image'], 'files/LeaPackages_Bg_Image', false);

            $now = date('Y-m-d H:i:s');

            $query = "UPDATE lea_packages LeaPackage SET LeaPackage.bg_image_domain = '".SITE_URL."' ";
            $query .= ", LeaPackage.bg_image = '$name_image' ";
            $query .= ", LeaPackage.modified = '$now' ";
            $query .= 'WHERE LeaPackage.id = '.$package['id'];

            $this->query($query);
        }

    }

    public function beforeDelete($cascade = false) {
        $package = $this->read(null, $this->id);
        if($package['LeaPackage']['bg_image'] != null) {
            $file = new File($package['LeaPackage']['bg_image']);
            if($file->delete()) {
                return true;
            }
            return false;
        }
        return true;
    }

    public function afterDelete() {
        // APAGA REGISTROS RELACIONADOS AO ID
        $this->LeaPackagesHasLeague->deleteAll(array('lea_package_id' => $this->id));
    }
}
