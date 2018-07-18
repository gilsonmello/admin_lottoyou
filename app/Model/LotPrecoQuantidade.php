<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP LotJogoModel
 * @author 
 */
class LotPrecoQuantidade extends AppModel {
    
    public $virtualFields = array(
        //'ativo' => "CASE WHEN LotJogo.active = 1 THEN 'Sim' ELSE 'Não' END",
    );

    public $useTable = 'lot_preco_qtds';

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
        'qtd' => array(
            'required' => array(
                'rule' => array('checkVazio', 'lot_categoria_id'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            /*'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Quantidade em uso.'
            ),*/
        ),
    );

}
