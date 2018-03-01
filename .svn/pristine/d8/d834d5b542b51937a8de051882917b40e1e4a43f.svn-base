<?php
App::uses('AppModel', 'Model');
/**
 * CakePHP GelEstadoModel
 * @author 
 */
class GelEstado extends AppModel {
    
    public $virtualFields = array(
        'ativo' => "CASE WHEN GelEstado.active = 1 THEN 'Sim' ELSE 'Não' END",
        'totalCidades' => "(SELECT count(1) FROM cidades WHERE cidades.GelEstado_id = GelEstado.id)",
    );
    
    public $order = 'GelEstado.nome asc';

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
        )
    );
}
