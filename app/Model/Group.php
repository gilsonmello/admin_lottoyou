<?php
App::uses('AppModel', 'Model');
/**
 * CakePHP GroupModel
 * @author 
 */
class Group extends AppModel {
    
    public $hasMany = [
        'User'
    ];
    
    public $hasAndBelongsToMany = [
        'Funcionalidade' => [
            'className'             => 'Funcionalidade',
            'joinTable'             => 'funcionalidades_groups',
            'foreignKey'            => 'funcionalidade_id',
            'associationForeignKey' => 'group_id'
        ]
    ];
    
    public $virtualFields = array(
        'ativo' => "CASE WHEN Group.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN Group.active = 1 THEN 'success' ELSE 'danger' END",  
        'tipoExtenso' => "CASE WHEN Group.tipo = 'I' THEN 'Interno' ELSE 'Externo' END",
        'totalFuncionalidades' => "(SELECT count(1) FROM funcionalidades_groups WHERE Group.id = funcionalidades_groups.group_id)",
        'totalUsuarios' => "(SELECT count(1) FROM users WHERE Group.id = users.group_id)",
    );
    
    public $order = 'Group.tipo desc, Group.name asc';

    public $validate = array(
        'name' => array(
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
        'tipo' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        )
    );
    
    public function afterSave($created, $options = array()) {
        // PREPARA DADOS
        $dados = $this->_extractFieldsHABTM($this->data['Group']['funcionalidade'], $this->data['Group']['id'], 'group_id', 'funcionalidade_id');

        // APAGA REGISTROS RELACIONADOS AO ID
        $this->FuncionalidadesGroup->deleteAll(array('group_id'=>$this->data['Group']['id']));
        
        // ASSOCIA PERMISSÕES A FUNCIONALIDADE
        $this->FuncionalidadesGroup->saveAll($dados);
        
        parent::afterSave($created, $options);
    }
    
    public function gruposSemFuncionalidades(){
        return $this->find('list', array('conditions'=>array('totalFuncionalidades'=>0)));
    }

    public function getFuncionalidadesPermissoes ($group_id){

        $data = $this->Query("SELECT Permission.name 
                              FROM permissions as Permission
                              INNER JOIN funcionalidades_permissions as FP ON FP.permission_id = Permission.id
                              INNER JOIN funcionalidades_groups as FG ON FG.funcionalidade_id = FP.funcionalidade_id
                              WHERE FG.group_id = $group_id");

        $data = Hash::extract($data, '{n}.Permission.name');
        
        return $data;
    }
}
