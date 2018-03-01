<?php
App::uses('AppModel', 'Model');
/**
 * CakePHP GelEscudoModel
 * @author 
 */
class GelEscudo extends AppModel {

    public $virtualFields = array(
        'ativo' => "CASE WHEN GelEscudo.active = 1 THEN 'Sim' ELSE 'Não' END",
    );
    
    public $belongsTo = array('GelClube');
    
//    public $order = 'GelEscudo.nome asc';

//    public $displayField = 'nome';

}
