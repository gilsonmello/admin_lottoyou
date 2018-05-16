<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class SocBolao extends AppModel {

    public $order = 'SocBolao.nome ASC';
    
    public $displayField = 'nome';
    
    public $virtualFields = [
        'ativo' => "CASE WHEN SocBolao.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN SocBolao.active = 1 THEN 'success' ELSE 'danger' END",
    ];

    public $belongsTo = [
        'SocCategoria' => [
            'className' => 'SocCategoria',
            'foreignKey' => 'soc_categoria_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];

    public $hasMany = [
        'SocRodada' => [
            'className' => 'SocRodada',
            'foreignKey' => 'soc_bolao_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];

    public $validate = array(
        'nome' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Nome em uso. Favor informar outro.'
            )
        ),
        'soc_categoria_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
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
    );

}
