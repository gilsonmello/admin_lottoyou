<?php
App::uses('AppModel', 'Model');
/**
 * CakePHP GelCidadeModel
 * @author 
 */
class GelCidade extends AppModel {

    public $virtualFields = array(
        'ativo' => "CASE WHEN GelCidade.active = 1 THEN 'Sim' ELSE 'Não' END",
        'estado' => "(SELECT GelEstado.nome FROM gel_estados GelEstado WHERE GelCidade.gel_estado_id = GelEstado.id)",
    );
    
    public $order = 'GelCidade.nome asc';
    
    public $belongsTo = array('GelEstado');

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
        'gel_estado_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        )
    );
}
