<?php
App::uses('AppModel', 'Model');
/**
 * CakePHP GelClubeModel
 * @author 
 */
class GelClube extends AppModel {

    public $virtualFields = array(
        'ativo' => "CASE WHEN GelClube.active = 1 THEN 'Sim' ELSE 'Não' END",
        'escudo' => "select dimensao from gel_escudos e where e.gel_clube_id = GelClube.id limit 1",
    );
    
    public $order = 'GelClube.nome asc';

    public $displayField = 'nome';

}
