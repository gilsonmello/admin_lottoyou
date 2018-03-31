<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class SocCategoria extends AppModel {

    public $order = 'SocCategoria.ordem ASC';
    
    public $displayField = 'nome';

    public $hasMany = [
    	'SocBolao' => [
            'className' => 'SocBolao',
            'foreignKey' => 'soc_categoria_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
	];

}
