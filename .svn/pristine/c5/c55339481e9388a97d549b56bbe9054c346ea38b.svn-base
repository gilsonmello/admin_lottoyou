<?php
App::uses('AppModel', 'Model');
/**
 * CakePHP UserModel
 * @author 
 */
class Permission extends AppModel {

    public $hasAndBelongsToMany = array('Funcionalidade');
    
    var $order = "Permission.name asc";
    var $displayField = "nome";
    
    public $virtualFields = array(
        'totalFuncionalidades' => "(SELECT count(1) FROM funcionalidades_permissions WHERE Permission.id = funcionalidades_permissions.permission_id)",
        'nome' => "CASE WHEN (SELECT count(1) FROM funcionalidades_permissions WHERE Permission.id = funcionalidades_permissions.permission_id) = 0 THEN CONCAT(Permission.name,'*') ELSE Permission.name END",
    );
    
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            )
        ),
    );

    public function findPermissoesNaoVinculadas(){
        return $this->find('list', array(
            'joins' => array(
                array(
                    'table' => 'funcionalidades_permissions',
                    'alias' => 'FuncionalidadesPermission',
                    'type' => 'LEFT',
                    'conditions' => array('Permission.id = FuncionalidadesPermission.permission_id')
                )
            ),
            'conditions'=>array('FuncionalidadesPermission.id IS NULL'))
        );
    }
}
