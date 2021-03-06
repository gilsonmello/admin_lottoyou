<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class ContatoCategoria extends AppModel {

    public $useTable = 'contact_categories';

    public $belongsTo = [

	];

	public $hasMany = [
        'Contato' => [
            'className' => 'Contato',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
	];


//    public $order = 'SocBolao.nome ASC';
//    
//    public $displayField = 'nome';
//    
//    public $virtualFields = array(
//        'ativo' => "CASE WHEN SocBolao.active = 1 THEN 'Sim' ELSE 'Não' END",
//        'ativo_label' => "CASE WHEN SocBolao.active = 1 THEN 'success' ELSE 'danger' END",
//    );
//    public $validate = array(
//        'nome' => array(
//            'required' => array(
//                'rule' => array('notEmpty'),
//                'required' => true,
//                'message' => 'Campo obrigatório'
//            ),
//            'unique' => array(
//                'rule' => 'isUnique',
//                'message' => 'Nome em uso. Favor informar outro.'
//            )
//        ),
//        'active' => array(
//            'required' => array(
//                'rule' => array('notEmpty'),
//                'message' => 'Campo obrigatório'
//            )
//        )
//    );

}
