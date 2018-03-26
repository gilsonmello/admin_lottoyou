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
        'nome' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Nome obrigatório',
                'required' => true
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Nome em uso. Favor informar outro nome'
            ),
        ),
        'qtd_raspadinhas' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        ),
        'valor_premio' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        ),
        'temas_raspadinha_id' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Tema em uso.'
            ),
        ),
    );

}
