<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class SocApostasJogo extends AppModel {

    public $belongsTo = [
    	'SocJogo' => [
            'className' => 'SocJogo',
            'foreignKey' => 'soc_jogo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'SocAposta' => [
            'className' => 'SocAposta',
            'foreignKey' => 'soc_aposta_id',
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
