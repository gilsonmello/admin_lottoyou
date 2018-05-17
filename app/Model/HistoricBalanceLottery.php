<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class HistoricBalanceLottery extends AppModel {

    public $belongsTo = [
        'HistoricBalance' => [
            'className' => 'HistoricBalance',
            'foreignKey' => 'historic_balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'LotUserJogo' => [
            'className' => 'LotUserJogo',
            'foreignKey' => 'lot_user_jogo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'LotCategoria' => [
            'className' => 'LotCategoria',
            'foreignKey' => 'lot_categoria_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
	];

	public $hasMany = [

	];

    public $hasOne = [

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
