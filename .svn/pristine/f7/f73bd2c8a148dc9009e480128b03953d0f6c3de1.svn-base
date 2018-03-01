<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class SisEmailTemplate extends AppModel {

    public $virtualFields = array(
        'ativo' => "CASE WHEN SisEmailTemplate.active = 1 THEN 'Sim' ELSE 'Não' END",              
        'ativo_label' => "CASE WHEN SisEmailTemplate.active = 1 THEN 'success' ELSE 'danger' END",     
    );
    
    public $displayField = 'assunto';

    public $order = 'SisEmailTemplate.assunto ASC';

}
