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

    public $order = 'LotJogo.sorteio asc';

    public $displayField = 'sorteio';

    public $validate = array(

    );

}
