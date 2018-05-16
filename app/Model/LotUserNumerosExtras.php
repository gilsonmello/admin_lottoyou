<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP LotJogoResultado
 * @author Jorge Silva
 */
class LotUserNumerosExtras extends AppModel {
    
    public $useTable = 'lot_users_numeros_extras';
    
    public $virtualFields = [
    	//'sorteio_nome' => 'SELECT sorteio FROM lot_jogos where lot_jogos.id = LotJogosResultado.lot_jogo_id'
    ];
    
    public $belongsTo = [
    	'LotUserJogo' => [
            'className' => 'LotUserJogo',
            'foreignKey' => 'lot_users_jogo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];
    
    public $validate = array(
        
    );

}
