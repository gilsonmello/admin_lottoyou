<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP LotJogoResultado
 * @author Jorge Silva
 */
class LotJogosNumerosExtra extends AppModel {
    
    public $virtualFields = [
    	//'sorteio_nome' => 'SELECT sorteio FROM lot_jogos where lot_jogos.id = LotJogosResultado.lot_jogo_id'
    ];
    
    public $belongsTo = [
    	'LotJogosResultado' => [
            'className' => 'LotJogosResultado',
            'foreignKey' => 'lot_jogos_resultado_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];
    
    public $validate = array(
        
    );

}
