<?php
App::uses('AppModel', 'Model');
/**
 * CakePHP GelEscudoModel
 * @author 
 */
class GelEscudo extends AppModel {

    public $virtualFields = [
        'ativo' => "CASE WHEN GelEscudo.active = 1 THEN 'Sim' ELSE 'Não' END",
    ];
    
    public $belongsTo = [
    	'GelClube'
    ];
    
//    public $order = 'GelEscudo.nome asc';

//    public $displayField = 'nome';

}
