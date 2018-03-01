<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP LotJogoResultado
 * @author Jorge Silva
 */
class LotJogosResultado extends AppModel {
    
    public $virtualFields = array( 'sorteio_nome' => 'SELECT sorteio FROM lot_jogos where lot_jogos.id = LotJogosResultado.lot_jogo_id'
    );
    
    public $belongsTo = array('LotJogo');
    
    public $validate = array(
        
    );

}
