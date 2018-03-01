<?php
App::uses('AppModel', 'Model');
/**
 * CakePHP GelCarroceriaModel
 * @author 
 */
class LotCategoria extends AppModel {
    
    public $useTable = 'lot_categorias';
    
    public $virtualFields = array(
        'ativo' => "CASE WHEN LotCategoria.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN LotCategoria.active = 1 THEN 'success' ELSE 'danger' END",
    );
    
    public $order = 'LotCategoria.nome asc';
    
    public $displayField = 'nome';

    public $validate = array(
        'nome' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Nome em uso. Favor informar outro.'
            )
        ),
        'active' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ),        
    );
}
