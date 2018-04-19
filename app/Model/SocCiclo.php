<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP RasLoteModel
 * @author 
 */
class SocCiclo extends AppModel {

    public $virtualFields = array(
        'ativo_label' => "CASE WHEN SocCiclo.active = 1 THEN 'success' ELSE 'danger' END",
        'ativo' => "CASE WHEN SocCiclo.active = 1 THEN 'Sim' ELSE 'Não' END",
    );
    
    public $order = 'SocCiclo.created desc';
    
    public $displayField = 'identificacao';

    public $belongsTo = array(
        'SocCategoria' => array(
            'className' => 'SocCategoria',
            'foreignKey' => 'soc_categoria_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /*public $hasMany = array('RasLotesNumero', 
        'Raspadinha' => array(
            'className' => 'Raspadinha',
            'foreignKey' => 'lote',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );*/

    //public $hasMany = array(
    //    'RaspadinhaCapaPremiacao'
    //);

    public $validate = array(
        'identificacao' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Identificação obrigatória',
                'required' => true
            )
        ),
        'data_inicio' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        ),
        'hora_inicio' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        ),
        'data_fim' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        ),
        'hora_fim' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        ),
        'soc_categoria_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        )
    );

}