<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class RasTabelasPremio extends AppModel {

//    public $order = 'SocJogo.nome ASC';
//    public $displayField = 'nome';

    public $virtualFields = [
        'ativo' => "CASE WHEN RasTabelasPremio.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN RasTabelasPremio.active = 1 THEN 'success' ELSE 'danger' END",
    ];
    
    public $belongsTo = [
        'TemasRaspadinha' => [
            'className' => 'TemasRaspadinha',
            'foreignKey' => 'tema_raspadinha_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];

    public $validate = [
        'tema_raspadinha_id' => array(
            'required' => array(
                'rule' => array('checkVazio', 'tema_raspadinha_id'),
                'required' => true,
                'message' => 'Campo obrigatório'
            )
        ),
        'nivel' => array(
            'required' => array(
                'rule' => array('checkVazio', 'nivel'),
                'required' => true,
                'message' => 'Campo obrigatório'
            )
        ),
        'disponivel' => array(
            'required' => array(
                'rule' => array('checkVazio', 'disponivel'),
                'required' => true,
                'message' => 'Campo obrigatório'
            )
        ),
        'quantia' => array(
            'required' => array(
                'rule' => array('checkVazio', 'quantia'),
                'required' => true,
                'message' => 'Campo obrigatório'
            )
        ),
        'active' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        )
    ];

}
