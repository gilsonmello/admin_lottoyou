<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class SocCategoria extends AppModel {

    public $order = 'SocCategoria.ordem ASC';
    
    public $displayField = 'nome';

}
