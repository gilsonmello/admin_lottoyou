<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP VeiculoModel
 * @author 
 */
class Raspadinha extends AppModel {

    public $useTable = "raspadinhas";
    public $virtualFields = array(
    	
    );

    public $belongsTo = array(
    	'RasLote' => array(
            'className' => 'RasLote',
            'foreignKey' => 'lote',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

}
