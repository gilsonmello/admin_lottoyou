<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class SocJogo extends AppModel {

//    public $order = 'SocJogo.nome ASC';
//    public $displayField = 'nome';

    public $virtualFields = [
        'ativo' => "CASE WHEN SocJogo.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN SocJogo.active = 1 THEN 'success' ELSE 'danger' END",
        'bolao' => "select nome from soc_boloes b where SocJogo.soc_bolao_id = b.id",
        'rodada' => "select nome from soc_rodadas r where SocJogo.soc_rodada_id = r.id",
        'nome_clube_casa' => "select ca.nome from gel_clubes ca where SocJogo.gel_clube_casa_id = ca.id",
        'escudo_clube_casa' => "SELECT ge.escudo from gel_clubes ge where SocJogo.gel_clube_casa_id = ge.id",
        'nome_clube_fora' => "select fo.nome from gel_clubes fo where SocJogo.gel_clube_fora_id = fo.id",
        'escudo_clube_fora' => "SELECT ge.escudo from gel_clubes ge where SocJogo.gel_clube_fora_id = ge.id",
    ];

    public $belongsTo = [
        'GelClube' => [
            'className' => 'GelClube',
            'foreignKey' => 'gel_clube_casa_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'GelClube' => [
            'className' => 'GelClube',
            'foreignKey' => 'gel_clube_fora_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'SocRodada' => [
            'className' => 'SocRodada',
            'foreignKey' => 'soc_rodada_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];
    
    public $validate = [
        'active' => [
            'required' => [
                'rule' => ['notEmpty'],
                'message' => 'Campo obrigatório'
            ]
        ]
    ];
}