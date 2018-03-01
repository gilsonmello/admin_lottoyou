<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class GelEmpresa extends AppModel {

    public $displayField = 'nome';

    public $order = 'GelEmpresa.matriz DESC, GelEmpresa.nome ASC';

    public $hasMany = array('User');

    public $virtualFields = array(
        'ativo' => "CASE WHEN GelEmpresa.active = 1 THEN 'Sim' ELSE 'Não' END",              
        'ativo_label' => "CASE WHEN GelEmpresa.active = 1 THEN 'success' ELSE 'danger' END",     
        'matriz_texto' => "CASE WHEN GelEmpresa.matriz = 1 THEN 'Sim' ELSE 'Não' END",              
        'matriz_texto2' => "CASE WHEN GelEmpresa.matriz = 1 THEN 'Matriz' ELSE 'Filial' END",              
        'matriz_label' => "CASE WHEN GelEmpresa.matriz = 1 THEN 'success' ELSE 'danger' END",     
    );

    public $validate = array(
        'nome' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'Nome Fantasia em uso. Favor informar outro nome.'
            ),
        ),
        'razao' => array(
            'unique' => array(
                'rule' => array('isUnique'),
                'allowEmpty'=>true,
                'message' => 'Razão Social em uso. Favor informar outro nome.', 
                'required' => false 
            ),
        ),
        'cnpj' => array(
            /*'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            ),*/
            'valid' => array(
                'rule' => array('cnpj'),
                'allowEmpty'=>true,
                'message' => 'CNPJ inválido'
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'CNPJ em uso', 
            ),
            'checaCnpjMatriz' => array(
                'on'=>'create',
                'rule' => array('checaCorrespondenciaCnpj'),
                'message' => 'CNPJ não confere com a matriz', 
            ),
        ),  
        'active' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ), 
        'gel_empresa_id' => array(
            'required' => array(
                'on' => 'create',
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório', 
                'required' => true 
            )
        ), 
        'user_id' => array(
            'required' => array(
                'on' => 'create',
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório', 
                'required' => true 
            )
        ), 
    );

    public function checaCorrespondenciaCnpj(){
        // INICIALIZA VARIÁVEIS
        $cnpj = substr($this->data['GelEmpresa']['cnpj'], 0, 10);
        $error = 0;

        // PEGA TOTAL DE MATRIZ COM CNPJ CORRESPONDENTE
        $total = $this->find('count', array('conditions'=>array('cnpj like'=>$cnpj.'%')));
        
        return $total;
    }
}