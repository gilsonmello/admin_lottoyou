<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class SocRodada extends AppModel {

    public $order = 'SocRodada.nome ASC';
    public $displayField = 'nome';
    public $virtualFields = array(
        'ativo' => "CASE WHEN SocRodada.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN SocRodada.active = 1 THEN 'success' ELSE 'danger' END",
        'bolao' => "select nome from soc_boloes b where SocRodada.soc_bolao_id = b.id",
        'tipo_name' => "CASE WHEN SocRodada.tipo = 1 THEN 'Limitado' ELSE 'Ilimitado' END",
        'categoria_name' => 'select nome from soc_categorias s where s.id = SocRodada.soc_categoria_id',
        'qtd_apostas' => 'SELECT count(DISTINCt(user_id)) FROM soc_apostas aposta WHERE aposta.soc_rodada_id = SocRodada.id'
    );
    public $hasMany = array(
        'SocJogo' => array(
            'className' => 'SocJogo',
            'foreignKey' => 'soc_rodada_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
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
        'soc_bolao_id' => array(
            'required' => array(
                'rule' => array('checkVazio', 'soc_bolao_id'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Bolão em uso. Favor informar outro.'
            ),
        ),
        'soc_categoria_id' => array(
            'required' => array(
                'rule' => array('checkVazio', 'soc_categoria_id'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Bolão em uso. Favor informar outro.'
            ),
        ),
        'valor' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ),
        'active' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ),
        'limite' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ),
        'data_termino' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ),
        'hora_termino' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ),
    );

    public $optionsCategorias = array(
        'W' => 'WOLD',
        'S' => 'ESPECIAL',
        'C' => 'CUSTOM',
    );
}
