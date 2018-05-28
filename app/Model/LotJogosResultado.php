<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP LotJogoResultado
 * @author Jorge Silva
 */
class LotJogosResultado extends AppModel {

    public $useTable = 'lot_jogos_resultados';

    public $virtualFields = [
    	'sorteio_nome' => 'SELECT sorteio FROM lot_jogos where lot_jogos.id = LotJogosResultado.lot_jogo_id'
    ];

    public $hasMany = [
        'LotJogosNumero' => [
            'className' => 'LotJogosNumero',
            'foreignKey' => 'lot_jogos_resultado_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'LotJogosNumerosExtras' => [
            'className' => 'LotJogosNumerosExtras',
            'foreignKey' => 'lot_jogos_resultado_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];

    public $belongsTo = [
    	'LotJogo'
    ];
    
    public $validate = array(
        
    );

}
