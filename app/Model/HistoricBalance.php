<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class HistoricBalance extends AppModel {

    public $belongsTo = [
    	'Balance' => [
            'className' => 'Balance',
            'foreignKey' => 'balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'HistoricBalanceSoccer' => [
            'className' => 'HistoricBalanceSoccer',
            'foreignKey' => 'historic_balance_id',
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
