<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP UserModel
 * @author 
 */
class User extends AppModel {

    // public $actsAs = array('Logable' => array('userModel' => 'User', 'userKey' => 'user_id'));

    public $belongsTo = array('Group', 'GelEmpresa');
    //public $hasMany = array('RedesUser');

    public $virtualFields = array(
        'ativo' => "CASE WHEN User.active = 1 THEN 'Sim' ELSE 'Não' END",
        'grupo' => "select name from groups g where g.id = User.group_id",
    );
    public $order = 'User.name ASC';
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Nome obrigatório',
                'required' => true
            )
        ),
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Formato de e-mail inválido'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'E-mail em uso. Favor informar outro e-mail'
            ),
            'contaExistente' => array(
                'rule' => 'checaContaExistente',
                'message' => 'E-mail em uso para conta de outra empresa. Favor informar outro e-mail'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório',
                'last' => false
            ),
            'validaTamanhoSenha' => array(
                'rule' => array('minLength', 6),
                'message' => 'Mínimo de 6 caracteres obrigatório',
            ),
            'validaAlteracaoSenha' => array(
                'rule' => 'validaAlteracaoSenha',
                'message' => 'Nova senha não confere com Confirme a senha',
            )
        ),
        'atual' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório',
                'last' => false
            ),
            'verificaSenhaAtual' => array(
                'rule' => 'verificaSenhaAtual',
                'message' => 'Senha informada não confere',
            )
        ),
        'cpf' => array(
            'rule' => 'cpf',
            'message' => 'CPF inválido',
        ),
        'phone' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Nome obrigatório',
                'required' => false
            )
        ),
        'active' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório',
            )
        ),
    );

    /*
     * Validações específicas do model
     */

    public function beforeValidate($options = array()) {
        // VERIFICA NOME E ATIVO QUANDO O CADASTRO É DE PERFIS INTERNOS
        if (!isset($this->data['User']['id'])) {
            $this->data['User']['active'] = 1;
        } else {
            // TODO: VERIFICA PRA QUE O CÓDIGO ABAIXO
            //unset($this->data['User']['password']);
        }

        // VERIFICA SE A SENHA ESTÁ SENDO ALTERADA
        if (isset($this->data['User']['password']) && isset($this->data['User']['confirmacao'])) {
            // REMOVE A VALIDAÇÃO DO CAMPO USERNAME, NAME E ACTIVE
            unset($this->validate['username']);
            unset($this->validate['name']);
            unset($this->validate['active']);
        } else {
            // REMOVE A VALIDAÇÃO DE ALTERAÇÃO DE SENHA DO CAMPO PASSWORD
            unset($this->validate['password']['validaAlteracaoSenha']);
            unset($this->validate['atual']['verificaSenhaAtual']);
        }

        return parent::beforeValidate($options);
    }

    /*
     * Prepara dados para salvar
     */

    public function beforeSave($options = array()) {
        // ENCRIPTA A SENHA UTILIZANDO O PADRÃO DO CAKEPHP
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
            if (isset($this->data['User']['atual'])) {
                $this->data['User']['atual'] = AuthComponent::password($this->data['User']['atual']);
            }
            if (isset($this->data['User']['confirmacao'])) {
                $this->data['User']['confirmacao'] = AuthComponent::password($this->data['User']['confirmacao']);
            }
        }
    }

    /*
     * Validações específicas do model
     */

    public function validaAlteracaoSenha() {
        $ok = true;

        if (isset($this->data['User']['password']) && isset($this->data['User']['confirmacao'])) {
            $senha = $this->data['User']['password'];
            $confirmacao = $this->data['User']['confirmacao'];

            // REMOVE A VALIDAÇÃO DO CAMPO USERNAME
            unset($this->validate['username']);

            // VERIFICA SE A SENHA SÃO IGUAIS
            if ($senha != $confirmacao) {
                $ok = false;
            }
        }

        return $ok;
    }

    public function verificaSenhaAtual() {
        $ok = true;
        $dados = $this->find('first', array('conditions' => array('User.id' => $this->data['User']['id'])));

        if ($dados['User']['password'] != $this->data['User']['atual']) {
            $ok = false;
        }

        return $ok;
    }

    public function checaContaExistente() {
        // INICIALIZA VARIÁVEIS
        $username = $this->data['User']['username'];
        $error = 0;

        if (empty($this->data['User']['id'])) {
            // PEGA TOTAL DE USUÁRIO COM O E-MAIL INFORMADO
            $dados = $this->query('SELECT count(1) total FROM users WHERE username = \'' . $username . '\'');

            // VERIFICA SE O USUÁRIO JÁ POSSI CONTA
            if ($dados[0][0]['total'] > 0) {
                $error = 1;
            }
        }
        return !$error;
    }

    /**
     * Registers a new user
     *
     * Options:
     * - bool emailVerification : Default is true, generates the token for email verification
     * - bool removeExpiredRegistrations : Default is true, removes expired registrations to do cleanup when no cron is configured for that
     * - bool returnData : Default is true, if false the method returns true/false the data is always available through $this->User->data
     *
     * @param array $postData Post data from controller
     * @param mixed should be array now but can be boolean for emailVerification because of backward compatibility
     * @return mixed
     */
    public function register($userData = array(), $options = array()) {

        if (!isset($userData['User']['oid'])) {
            return parent::register($userData, $options);
        }

        $defaults = array(
            'removeExpiredRegistrations' => true,
            'returnData' => true
        );
        extract(array_merge($defaults, $options));

        $userData = $this->_beforeRegistration($userData, false);

        if ($removeExpiredRegistrations) {
            $this->_removeExpiredRegistrations();
        }
        
        $this->set($userData);
        $this->validate = $this->validateOAuth;

        if ($this->validates()) {
            $this->data['ok'] = true;
            if ($returnData) {
                return $this->data;
            }
            return true;
        }
        return false;
    }

    protected function _removeExpiredRegistrations() {

        $this->deleteAll(array(
            $this->alias . '.email_verified' => 0,
            $this->alias . '.email_token_expires <' => date('Y-m-d H:i:s')));
    }

    /**
     * Optional data manipulation before the registration record is saved      
     *
     * @param array post data array
     * @param boolean Use email generation, create token, default true
     * @return array
     */
    protected function _beforeRegistration($postData = array(), $useEmailVerification = true) {

        if ($useEmailVerification == true) {
            $postData["RedesUser"]['email_token'] = $this->generateToken();
            $postData["RedesUser"]['email_token_expires'] = date('Y-m-d H:i:s', time() + 86400);
        } else {
            $postData["RedesUser"]['email_verified'] = 1;
        }
        $postData["RedesUser"]['active'] = 1;
        $defaultRole = Configure::read('Users.defaultRole');
        if ($defaultRole) {
            $postData["RedesUser"]['role'] = $defaultRole;
        } else {
            $postData["RedesUser"]['role'] = 'registered';
        }
        return $postData;
    }
}