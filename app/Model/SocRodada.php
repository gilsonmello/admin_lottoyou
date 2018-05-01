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

    public $hasOne = array(
        'SocConfRodada' => array(
            'className' => 'SocConfRodada',
            'foreignKey' => 'soc_rodada_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public $belongsTo = [
        'SocBolao' => [
            'className' => 'SocBolao',
            'foreignKey' => 'soc_bolao_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'SocCategoria' => [
            'className' => 'SocCategoria',
            'foreignKey' => 'soc_categoria_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'SocCiclo' => [
            'className' => 'SocCiclo',
            'foreignKey' => 'soc_ciclo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];

    public $hasMany = array(
        'SocJogo' => array(
            'className' => 'SocJogo',
            'foreignKey' => 'soc_rodada_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SocRodadasGrupo' => array(
            'className' => 'SocRodadasGrupo',
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
            /*'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Bolão em uso. Favor informar outro.'
            ),*/
        ),
        'soc_categoria_id' => array(
            'required' => array(
                'rule' => array('checkVazio', 'soc_categoria_id'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            /*'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Categoria em uso. Favor informar outro.'
            ),*/
        ),
        'soc_ciclo_id' => array(
            'required' => array(
                'rule' => array('checkVazio', 'soc_ciclo_id'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            /*'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Categoria em uso. Favor informar outro.'
            ),*/
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
            ),
        ),
        'minimo' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            ),
            'biggerThen' => [
                'rule' => ['biggerThen', 'minimo', 0],
                'message' => 'Maior que 0'
            ]
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

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        if(isset($this->data['SocRodada']['tipo'])) {
            //Se for do tipo ilimitado, não é necessário o campo limite,
            if($this->data['SocRodada']['tipo'] == 0) {
                $this->data['SocRodada']['limite'] = null;
            }
        }
    }

    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        if(isset($this->data['SocRodada']['tipo'])) {
            //Se for do tipo ilimitado, não é necessário o campo limite,
            //Removo o campo limite da validação
            if($this->data['SocRodada']['tipo'] == 0) {
                unset($this->validate['limite']);
            }
        }
    }

    public function afterSave($created, $options = array()) {
        parent::afterSave($created);
        if($created) {
            if(isset($this->data['SocRodada']['tipo'])) {
                $this->SocRodadasGrupo->create();
                $socRodadasGrupo['soc_rodada_id'] = $this->id;
                $socRodadasGrupo['active'] = 1;
                $socRodadasGrupo['status'] = 1;
                $this->SocRodadasGrupo->save($socRodadasGrupo);
            }
        }
    }
}
