<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP LotJogoModel
 * @author 
 */
class LotJogo extends AppModel {
    
    public $virtualFields = array(
        'ativo' => "CASE WHEN LotJogo.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN LotJogo.active = 1 THEN 'success' ELSE 'danger' END",
        'data_label' => "CASE WHEN LotJogo.data_fim > NOW() THEN 'success' ELSE 'danger' END",
        'url_image' => "select img_loteria from lot_categorias cat where cat.id = LotJogo.lot_categoria_id",
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
        'LotJogosResultado' => [
            'className' => 'LotJogosResultado',
            'foreignKey' => 'lot_jogo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];

    public $hasMany = [
        'LotUserJogo' => [
            'className' => 'LotUserJogo',
            'foreignKey' => 'lot_jogo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];

    public $order = 'LotJogo.sorteio asc';

    public $displayField = 'sorteio';

    public $validate = array(
        'sorteio' => array(
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
        'concurso' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            )
        ),
        'data_fim' => array(
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
        ),
        'hora_fim' => array(
            'rule'=> array('time','HH:MM'),
            'message' => 'Campo inválido'
        ),
    );

}
