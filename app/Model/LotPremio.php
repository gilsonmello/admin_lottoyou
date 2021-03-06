<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP LotJogoModel
 * @author 
 */
class LotPremio extends AppModel {
    
    public $virtualFields = array(
        //'ativo' => "CASE WHEN LotJogo.active = 1 THEN 'Sim' ELSE 'Não' END",
    );

    public $belongsTo = [
        'LotCategoria' => [
            'className' => 'LotCategoria',
            'foreignKey' => 'lot_categoria_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];

    public $hasOne = [

    ];

    public $hasMany = [

    ];

    //public $displayField = 'sorteio';

    public $validate = array(
        'lot_categoria_id' => array(
            'required' => array(
                'rule' => array('checkVazio', 'lot_categoria_id'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            /*'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Bolão em uso. Favor informar outro.'
            ),*/
        ),
    );

}
