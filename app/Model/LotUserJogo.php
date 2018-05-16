<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP LotUserJogoModel
 * @author 
 */
class LotUserJogo extends AppModel {
    
    public $useTable = 'lot_users_jogos';
    
    public $belongsTo = [
        'LotJogo'
    ];
    
    public $virtualFields = [
        'data_limite' => 'SELECT data_fim FROM lot_jogos lot_jogos where LotUserJogo.lot_jogo_id = lot_jogos.id',
    ];

    public $hasMany = [
        'LotUserNumero' => [
            'className' => 'LotUserNumero',
            'foreignKey' => 'lot_users_jogo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'LotUserNumerosExtra' => [
            'className' => 'LotUserNumerosExtra',
            'foreignKey' => 'lot_users_jogo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];

}
