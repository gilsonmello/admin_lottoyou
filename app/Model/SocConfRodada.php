<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class SocConfRodada extends AppModel {

//    public $order = 'SocJogo.nome ASC';
//    public $displayField = 'nome';

    public $virtualFields = array(
        'ativo' => "CASE WHEN SocConfRodada.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN SocConfRodada.active = 1 THEN 'success' ELSE 'danger' END",
    );
    
    public $belongsTo = array(
        'SocRodada' => array(
            'className' => 'SocRodada',
            'foreignKey' => 'soc_rodada_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    public $validate = array(
        'soc_rodada_id' => array(
            'required' => array(
                'rule' => array('checkVazio', 'soc_rodada_id'),
                'required' => true,
                'message' => 'Campo obrigatório'
            )
        ),
        'hit_a_result' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ),
        'hit_all_results' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ),
        'hit_the_difference_result' => array(
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
    );

    public function beforeSave($options = array()) {
        
    }

    public function beforeValidate($options = array()) {
        
    }

    public function afterSave($created, $options = array()) {
       
    }

}
