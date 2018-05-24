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
    
    public $belongsTo = [
    	'LotJogo'
    ];
    
    public $validate = array(
        
    );

}
