<?php

App::uses('AppModel', 'Model');

/**
 * Empresa Model
 *
 */
class TemasRaspadinha extends AppModel {

    public $displayField = 'nome';

    public $hasMany = [
        'RasTabelasDesconto' => [
            'className' => 'RasTabelasDesconto',
            'foreignKey' => 'tema_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];
    
    public $validate = array(
        'nome' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'Nome do Tema em uso. Favor utilizar outro!'
            ),
        ),
        'texto_raspadinha' => array(
            'required' => array(
                'on' => 'create',
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório',
                'required' => true
            )
        ),
//        'cor_texto_raspadinha' => array(
//            'required' => array(
//                'on' => 'create',
//                'rule' => 'notEmpty',
//                'message' => 'Campo obrigatório',
//                'required' => true
//            )
//        ),
    );

}
