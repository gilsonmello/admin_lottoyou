<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class SocRodadasGrupo extends AppModel {

//    public $order = 'SocJogo.nome ASC';
//    public $displayField = 'nome';

    public $virtualFields = [
        'ativo' => "CASE WHEN SocRodadasGrupo.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN SocRodadasGrupo.active = 1 THEN 'success' ELSE 'danger' END",
    ];
    
    public $belongsTo = [
        'SocRodada' => [
            'className' => 'SocRodada',
            'foreignKey' => 'soc_rodada_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];

    public $hasAndBelongsToMany = [
        'User' => [
            'className'             => 'User',
            'joinTable'             => 'soc_rodadas_grupos_has_users',
            'foreignKey'            => 'soc_rodadas_grupo_id',
            'associationForeignKey' => 'user_id'
        ]
    ];
    
    public $validate = [
        /*'active' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        )*/
    ];

}
