<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP LotJogoResultado
 * @author Jorge Silva
 */
class LotJogosNumero extends AppModel {
    
    public $virtualFields = [
    	//'sorteio_nome' => 'SELECT sorteio FROM lot_jogos where lot_jogos.id = LotJogosResultado.lot_jogo_id'
    ];
    
    public $belongsTo = [
    	'LotJogosResultado' => [
            'className' => 'LotJogosResultado',
            'foreignKey' => 'lot_jogo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];
    
    public $validate = array(
        
    );

}
