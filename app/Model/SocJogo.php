<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class SocJogo extends AppModel {

//    public $order = 'SocJogo.nome ASC';
//    public $displayField = 'nome';

    public $virtualFields = array(
        'ativo' => "CASE WHEN SocJogo.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN SocJogo.active = 1 THEN 'success' ELSE 'danger' END",
        'bolao' => "select nome from soc_boloes b where SocJogo.soc_bolao_id = b.id",
        'rodada' => "select nome from soc_rodadas r where SocJogo.soc_rodada_id = r.id",
        'nome_clube_casa' => "select ca.nome from gel_clubes ca where SocJogo.gel_clube_casa_id = ca.id",
        'escudo_clube_casa' => "select ge.dimensao from gel_escudos ge where SocJogo.gel_clube_casa_id = ge.gel_clube_id limit 1",
        'nome_clube_fora' => "select fo.nome from gel_clubes fo where SocJogo.gel_clube_fora_id = fo.id",
        'escudo_clube_fora' => "select ge.dimensao from gel_escudos ge where SocJogo.gel_clube_fora_id = ge.gel_clube_id limit 1",
    );
    public $belongsTo = array(
        'GelClube' => array(
            'className' => 'GelClube',
            'foreignKey' => 'gel_clube_casa_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'GelClube' => array(
            'className' => 'GelClube',
            'foreignKey' => 'gel_clube_fora_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
    public $validate = array(
        'active' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        )
    );

}
