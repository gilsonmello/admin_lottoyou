<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class GelPessoa extends AppModel {

    public $useTable = 'gel_pessoas';

    public $displayField = 'nome';

    public $order = 'GelPessoa.nome ASC';

    public $belongsTo = array('GelCidade','User');

    public $virtualFields = array(
        'ativo' => "CASE WHEN GelPessoa.active = 1 THEN 'Sim' ELSE 'Não' END",              
        'ativo_label' => "CASE WHEN GelPessoa.active = 1 THEN 'success' ELSE 'danger' END",                
        'tipo_cadastro_label' => "CASE 
                                    WHEN GelPessoa.tipo_cadastro = 'C' THEN 'success' 
                                    WHEN GelPessoa.tipo_cadastro = 'F' THEN 'danger' 
                                    ELSE 'purple' 
                                  END",     
    );

    public $validate = array(
        'nome' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'Nome/Razão Social em uso. Favor informar outro nome.'
            ),
        ),
        'tipo_pessoa' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        ),
        'contato_email' => array(
            'email' => array(
                'rule' => array('email'),
                'allowEmpty'=>true,
                'message' => 'E-mail inválido'
            ),
        ),
        'endereco_cep' => array(
            'cep' => array(
                'rule' => array('cep'),
                'allowEmpty'=>true,
                'message' => 'CEP inválido'
            ),
        ),
        'active' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
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

    public $validatePF = array(
        'cpf_cnpj' => array(
            'cpf_cnpj' => array(
                'rule' => array('cpf'),
                'allowEmpty'=>true,
                'message' => 'CPF inválido'
            )
        ),                
    );

    public $validatePJ = array(
        'cpf_cnpj' => array(
            'cpf_cnpj' => array(
                'rule' => array('cnpj'),
                'allowEmpty'=>true,
                'message' => 'CNPJ inválido'
            )
        ),                
    );

    public $optionsTipoCadastro = array(
        'C'=>'Cliente',
        'F'=>'Fornecedor',
        'A'=>'Cliente e Fornecedor'
    );

    public function beforeValidate($options = array()) {
        // VERIFICA TIPO DE PESSOA
        if ($this->data['GelPessoa']['tipo_pessoa'] == 'PF'){
            // SE TIPO PESSOA FÍSICA VALIDA CPF
            $this->validate = array_merge($this->validate, $this->validatePF);
        } else {
            // SE TIPO PESSOA JURÍDICA VALIDA CNPJ
            $this->validate = array_merge($this->validate, $this->validatePJ);
        }

        return parent::beforeValidate($options);
    }

    public function afterValidate() {
        if (isset($this->validationErrors['nome'])){
            if ($this->data['GelPessoa']['tipo_pessoa'] == 'PF'){
                $this->validationErrors['nome'] = str_replace('Nome/Razão Social', 'Nome', $this->validationErrors['nome']);
            } else {
                $this->validationErrors['nome'] = str_replace('Nome/Razão', 'Razão Social', $this->validationErrors['nome']);
            }
        }
    }
}