<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class RasDemo extends AppModel {

//    public $order = 'SocJogo.nome ASC';
//    public $displayField = 'nome';

    public $virtualFields = [
        'ativo' => "CASE WHEN RasDemo.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN RasDemo.active = 1 THEN 'success' ELSE 'danger' END",
        'total_geradas' => 'select count(*) from ras_demos ras_demos where premio = RasDemo.premio',
    ];
    
    public $belongsTo = [
        'TemasRaspadinha' => [
            'className' => 'TemasRaspadinha',
            'foreignKey' => 'temas_raspadinha_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'RasLote' => [
            'className' => 'RasLote',
            'foreignKey' => 'lote_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];

    public $validate = [
        
    ];

}
