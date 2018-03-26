<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP RasLoteModel
 * @author 
 */
class RasTabelasDesconto extends AppModel {

    public $virtualFields = array(
        'ativo_label' => "CASE WHEN RasTabelasDesconto.active = 1 THEN 'success' ELSE 'danger' END",
        'ativo' => "CASE WHEN RasTabelasDesconto.active = 1 THEN 'Sim' ELSE 'Não' END",
    );
    
    public $order = 'RasTabelasDesconto.created desc';
    
    public $displayField = '';

    public $belongsTo = array(
        'TemasRaspadinha' => array(
            'className' => 'TemasRaspadinha',
            'foreignKey' => 'tema_id',
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
        'quantity' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Quantidade obrigatória',
                'required' => true
            )
        ),
        'percentage' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        ),
        'tema_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Quantidade obrigatória',
                'required' => true
            )
        ),
    );

}