<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP LotUserJogoModel
 * @author 
 */
class LotUserJogo extends AppModel {
    public $useTable = 'lot_users_jogos';
    public $belongsTo = 'LotJogo';
    
    public $virtualFields = array(
        'data_limite'=>'SELECT data_fim FROM lot_jogos lot_jogos where LotUserJogo.lot_jogo_id = lot_jogos.id',
        );

}
