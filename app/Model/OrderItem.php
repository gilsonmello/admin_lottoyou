<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class OrderItem extends AppModel {

    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Order' => [
            'className' => 'Order',
            'foreignKey' => 'order_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'LotCategoria' => [
            'className' => 'LotCategoria',
            'foreignKey' => 'lottery_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'TemasRaspadinha' => [
            'className' => 'TemasRaspadinha',
            'foreignKey' => 'scratch_card_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'SocCategoria' => [
            'className' => 'SocCategoria',
            'foreignKey' => 'soccer_expert_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
	];

	public $hasMany = [
    	
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
