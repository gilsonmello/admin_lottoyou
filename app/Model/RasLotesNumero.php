<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP RasLoteModel
 * @author 
 */
class RasLotesNumero extends AppModel {

    public $virtualFields = array(
        'used' => '0'
    );
    
    public $order = 'RasLotesNumero.number asc';
    
    public $displayField = 'number';

    public $belongsTo = array('RasLote');

    //public $hasMany = array(
    //    'RaspadinhaCapaPremiacao'
    //);

    public $validate = array(
        'number' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Nome em uso. Favor informar outro nome'
            ),
        ),
    );

}
