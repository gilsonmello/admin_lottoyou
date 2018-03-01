<?php
App::uses('AppModel', 'Model');
/**
 * CakePHP FuncionalidadeModel
 * @author Go! Ponto a ponto
 */
class Funcionalidade extends AppModel {

    public $hasAndBelongsToMany = array('Permission','Group');
    
    public $belongsTo = array('Modulo');

    public $virtualFields = array(
        'ativo' => "CASE WHEN Funcionalidade.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN Funcionalidade.active = 1 THEN 'success' ELSE 'danger' END",
        'totalPermissoes' => "(SELECT count(1) FROM funcionalidades_permissions WHERE Funcionalidade.id = funcionalidades_permissions.funcionalidade_id)",
        'totalGrupos' => "(SELECT count(1) FROM funcionalidades_groups WHERE Funcionalidade.id = funcionalidades_groups.funcionalidade_id)",
        'modulo' => "(SELECT modulos.name FROM modulos WHERE modulos.id = modulo_id)",
    );
    
    public $order = 'Funcionalidade.name asc';

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        ),
        'modulo_id' => array(
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
        )
    );
    
    public function afterSave($created, $options = array()) {
        // VERIFICIA SE FORAM PASSADAS PEMISSÕES COMO PARÂMETROS
        if (isset($this->data['Funcionalidade']['permission'])){
            // PREPARA DADOS
            $dados = $this->_extractFieldsHABTM($this->data['Funcionalidade']['permission'], $this->data['Funcionalidade']['id'], 'funcionalidade_id', 'permission_id');

            // APAGA REGISTROS RELACIONADOS AO ID
            $this->FuncionalidadesPermission->deleteAll(array('funcionalidade_id'=>$this->data['Funcionalidade']['id']));

            // ASSOCIA PERMISSÕES A FUNCIONALIDADE
            $this->FuncionalidadesPermission->saveAll($dados);
        }

        // VERIFICIA SE FORAM PASSADOS GRUPOS COMO PARÂMETROS
        if (isset($this->data['Funcionalidade']['group'])){
            // PREPARA DADOS
            $dados = $this->_extractFieldsHABTM($this->data['Funcionalidade']['group'], $this->data['Funcionalidade']['id'], 'funcionalidade_id', 'group_id');

            // APAGA REGISTROS RELACIONADOS AO ID
            $this->FuncionalidadesGroup->deleteAll(array('funcionalidade_id'=>$this->data['Funcionalidade']['id']));

            // ASSOCIA PERMISSÕES A FUNCIONALIDADE
            $this->FuncionalidadesGroup->saveAll($dados);
        }
    }
    
    public function findPermissoesNaoVinculadas(){
        return $this->find('list', array(
            'conditions'=>array('totalPermissoes'=>'0'))
        );
    }
}
