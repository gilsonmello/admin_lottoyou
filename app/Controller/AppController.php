<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('Hash', 'Utility');
App::uses('ConnectionManager', 'Model');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session',
        'Cookie',
        'RequestHandler',
        'Paginator',
        'Auth' => array(
            'authorize' => array(
                'Controller',
            ),
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login',
            ),
            'unauthorizedRedirect' => array(
                'controller' => 'pages',
                'action' => 'unauthorized',
            ),
            'authError' => 'Você não tem permissão para acessar: ',
            'flash' => array(
                'element' => 'alert',
                'key' => 'auth',
                'params' => array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-error',
                ),
            ),
        ),
    );
    public $helpers = array(
        'Session',
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Js' => ['Jquery'],
        'Paginator'
            //'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
    );


    public $meses = array(
        "01" => "Janeiro",
        "02" => "Fevereiro",
        "03" => "Março",
        "04" => "Abril",
        "05" => "Maio",
        "06" => "Junho",
        "07" => "Julho",
        "08" => "Agosto",
        "09" => "Setembro",
        "10" => "Outubro",
        "11" => "Novembro",
        "12" => "Dezembro",
    );

    // A CADA REQUISIÇÃO FEITA PELO O USUÁRIO O SISTEMA DEVE AVALIAR SE O MESMO
    // TEM PERMISSÃO PARA FAZÊ-LO E SE SUA SESSÃO ESTÁ ATIVIDA
    public function beforeFilter() {
        // HABILITA A ESCRITA DE COOKIES
        $this->Cookie->httpOnly = true;

        // CASO A SESSÃO DO USUÁRIO NÃO ESTEJA ATIVA, VERIFICA SE SEU COOKIE ESTÁ VÁLIDO
        // CASO ESTEJA UTILIZA AS INFORMAÇÕES DO COOKIE PARA FAZER O LOGIN
        if (!$this->Auth->loggedIn() && $this->Cookie->read('rememberMe')) {
            $cookie = $this->Cookie->read('rememberMe');

            // VERIFICA SE O USUÁRIO INFORMADO EXISTE E SE A SENHA DELE É A MESMA DE QUANDO
            // SALVOU O COOKIE DURANTE O LOGIN
            $this->loadModel('User');
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $cookie['username'],
                    'User.password' => $cookie['password'],
                ),
            ));

            // CASO O USUÁRIO EXISTA, VERIFICA SE CONSEGUE FAZER O LOGIN COM ESTAS INFORMAÇÕES
            // CASO CONTRÁRIO, REDIRECIONA O USUÁRIO PARA A TELA DE LOGIN
            if ($user && !$this->Auth->login($user['User'])) {
                $this->redirect('/users/logout');
            }
        }

        // CONFIGURA SE O LAYOUT DEVE SER LOGIN
        $request = $this->request->params['controller'] . '.' . $this->request->params['action'];
        if (in_array($request, array('users.login', 'users.forgot_password', 'users.confirm_password', 'users.recover_password', 'users.deny_password_recover', 'users.lock'))) {
            $this->layout = 'login';
        }

        // CASO A REQUISIÇÃO SEJA AJAX O LAYOUT POR PADRÃO DEVE SER O AJAX, CASO
        // HAJA NECESSIDADE É POSSÍVEL ALTERAR ESTA INFORMAÇÃO DIRETAMENTE DA ACTION REQUISITADA
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }

        // CONFIGURA O LOGGABLE BEHAVIOR PARA PEGAR OS DADOS DO USUÁRIO LOGADO
        if (sizeof($this->uses) && $this->{$this->modelClass}->Behaviors->attached('Logable')) {
            $this->{$this->modelClass}->setUserData(array('User' => $this->Auth->user()));
        }

        // PERMITE O USO DE ACTIONS
        $this->Auth->allow('listSelectOptions');

        // CONFIGURA O REDIRENCINADO DO LOGIN QUANDO OCORRER
        $this->Auth->loginRedirect = array('controller' => 'dashboard');
        $this->Auth->logoutRedirect = array('controller' => 'home');
    }

    /**
     * Chamado depois da ação do controller ser executada, porém antes do 
     * processemento de sua exibição. 
     *
     * @return void
     */
    public function beforeRender() {
        // CONFIGURA O LAYOUT QUANDO O USUÁRIO TENTAR ACESSAR 
        // UMA FUNCONALIDADE INEXISTENTE SEM ESTAR LOGADO
        if ($this->name == 'CakeError' && !$this->Auth->loggedIn()) {
            $this->layout = 'site';
        }

        // CONFIGURA O COMPORTAMENTO DA INCLUSÃO DOS ARQUIVOS JS. CASO A REQUISIÇÃO
        // SEJA AJAX, O SISTEMA DEVE FAZER A INCLUSÃO DIRETAMENTE NA PÁGINA, POIS
        // DESTA FORMA O JS SERÁ CARREGADO AUTOMATICAMENTE APÓS A PÁGINA SER CARREGADA
        // CASO CONTRÁRIO A INCLUSÃO DEVE SER FEITA DE FORMA SEQUENCIAL PELO CAKE
        $pageJsBehavior = ($this->request->is('ajax')) ? array() : array('inline' => false);
        $this->set(compact('pageJsBehavior'));
    }

    // VERIFICA SE O USUÁRIO LOGADO TEM ACESSO A FUNCIONALIDADE REQUISITADA
    public function isAuthorized($user) {
        App::import('Model', 'Group');
        $thisGroup = new Group;

        // VERIFICA SE IRÁ CARREGAR OS DADOS DE PERMISSÃO DA BASE OU DA SESSÃO
        if (Configure::read('checkPermissionInSession') == 1 && $this->Session->check('Auth.User.Permission')) {
            $data = $this->Session->read('Auth.User.Permission');
        } else {
            // PESQUISA PERMISSÕES DO GRUPO
            $data = $thisGroup->getFuncionalidadesPermissoes($user['group_id']);
            $this->Session->write('Auth.User.Permission', $data);
        }

        //die(var_dump($data));

        // PEGA CONTROLLER E ACTION REQUISITADA
        $controller = $this->request->params['controller'];
        $action = $this->request->params['action'];

        // CASO SEJA REQUISITADO O CONTROLLER PAGES O SISTEMA DARAR 
        // ACESSO IRRESTRITO A TODAS O ACESSO A TODAS AS ACTIONS
        if ($controller == 'pages') {
            return true;
        }

        // VERIFICA SE O USUÁRIO TEM PERMISSÃO OU NÃO PARA ACESSAR 
        // A FUNCIONALIDADE REQUISITADA
        $permissao = $controller . '.' . $action;
        $temPermissao = in_array($permissao, $data);

        // CASO NÃO TENHA PREENCE A VARÁVEL DADOS COM O NOME DA 
        // PERMISSÃO REQUISITADA
        if (!$temPermissao) {
            $dados = $thisGroup->Funcionalidade->Permission->find('all', array('conditions' => array('Permission.name =' => $permissao)));
        }

        //die(var_dump($temPermissao));

        return $temPermissao;
    }

    // PREPARA CAMPOS QUE SÃO DA TABELA. ESTA FUNCIONALIDADE É UTILIZADA PARA
    // TRATAR OS CAMPO QUE SERÃO UTILIZADO NO INDEX DA GRID (W2UI -> W2GRUI)
    public function _preparaCampos($data) {
        // INICIALIZA VARIÁVEIS
        $campos = array();
        foreach ($data as $model => $field) {
            if (is_array($field)) {
                foreach ($field as $k => $v) {
                    if ($v != '' && $model != 'selectAlldata' && $model != 'selectGroupdata' && $model != 'selectItemdata') {
                        $campos[$model . '.' . $k] = $v;
                    }
                }
            } else {
                $campos[$this->modelClass . '.' . $model] = $field;
            }
        }
        return $campos;
    }

    /**
     * _index method
     * 
     * @desciption Prepara a consulta motando $conditions e o $order  
     * @return array($order, $conditions)
     */
    public function _index() {
        // INICIALIZA VARIÁVEIS
        $conditions = '';

        // CASO SEJA INFORMADO CAMPOS DE PESQUISA CRIA CONDITION
        if ($this->request->is(array('post', 'get'))) {

            // VERIFICA SE EXISTEM CAMPOS DE OUTRAS TABELAS PARA PREPARAR A QUERY
            $this->request->data = $this->_preparaCampos($this->data);

            // TODO: TRATA CAMPOS COM VALUE_ID IGUAL A NULL
            // SETA CONDITIONS
            $conditions = $this->request->data;
        }

        return compact('conditions');
    }

    /**
     * Deleta registros de uma tabela
     *
     * @param null $id
     * @param null $cascade
     */
    public function _delete($id = null, $cascade = null) {
        // INICIALIZA VARIÁVEIS
        $error = 0;
        $exception = '';
        $code = '';
        $msg = 'Registro excluído com sucesso.';
        $this->autoRender = ($this->request->is('ajax')) ? false : true;
        $model = $this->modelClass;

        try {
            if (!$this->request->is('post') || $this->autoRender == true) {
                throw new MethodNotAllowedException();
            }

            $this->$model->id = $id;

            if (!$this->$model->exists()) {
                throw new CakeException('Registro inexistente.', 501);
            }

            if (!$this->$model->delete($id, $cascade)) {
                $msg = 'Erro desconhecido.';
                if (isset($this->$model->validationErrors['msg'])) {
                    throw new CakeException($this->$model->validationErrors['msg'], 1);
                } else {
                    throw new CakeException('Erro desconhecido.');
                }
            }
            
        } catch (Exception $exception) {
            $error = 1;
            $code = $exception->getCode();
            $message = $exception->getMessage();
            switch ($code) {
                case '405':
                    $msg = 'Não foi possível excluir o registro selecionado, pois o método útilizado não é permitido.';
                    break;
                case '501':
                    $msg = 'Não foi possível excluir o registro selecionado, pois o mesmo não existe mais. Provavelmente, este registro foi excluído por outro usuário do sistema.';
                    break;
                case '23000':
                    $msg = 'Não foi possível excluir o registro selecionado, pois o mesmo encontra-se em uso no sistema.';
                    break;
                case '1':
                    $msg = $exception->getMessage();
                    break;
                default:
                    $msg = 'Não foi possível excluir o registro.<br/>Favor tentar novamente. Caso o problema persista favor entrar em contato com o administrador do sistema.';
                    break;
            }
        }

        echo json_encode(compact('error', 'msg', 'exception', 'code', 'message'));
        exit;
    }

    /**
     * Função generica para enviar e-mail.
     * 
     * @param type $to - String com o destinatário do e-mail
     * @param type $subject - String com o ASSUNTO do e-mail
     * @param type $message - String com o conteudo do e-mail
     * @param type $cc - Array de String  que será enviado copias de e-mails em oculto ( Exemplo: array(teste@teste.com, email2@teste.com) )
     * @return boolean
     */
    public function enviarEmail($to = NULL, $subject = NULL, $message = null, $cc = array()) {
        

        return !$error;
    }

    /**
     * Método padrão para recarregar campos aninhados, este método ainda 
     * está em fase de aprimoramento, postanto não deve funcionar para todos os casos.
     *
     * @return json
     */
    public function listSelectOptions() {
        // INICIALIZA VARIÁVEIS
        $error = 0;
        $total = 0;
        $dados = array();
        $exception = '';
        $msg = 'Lista retornada com sucesso.';
        $this->autoRender = false;
        $model = $this->modelClass;
        $options = array();

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options['order'] = $model . '.' . $this->$model->displayField . ' ASC';
        $options['conditions'] = $this->data;

        // VERIFICA SE DEVE CARREFAR LISTA COM GROUP OPTIONS
        if (isset($options['conditions']['groupPath'])) {
            $options['fields'] = array('id', $this->$model->displayField, $options['conditions']['groupPath']);
            unset($options['conditions']['groupPath']);
        }

        try {
            if (!$this->request->is(array('post', 'get')) || $this->autoRender == true) {
                throw new MethodNotAllowedException();
            }

            if (!is_object($this->$model)) {
                throw new CakeException('Model inexistente.', 501);
            }

            // PEGA REGISTROS
            $dados = $this->$model->find('list', $options);
            $total = count($dados);

            // TRATA DADOS
            $aux = array();
            foreach ($dados as $id => $nome) {
                $aux[] = compact('id', 'nome');
            }
            $dados = $aux;
        } catch (Exception $exception) {
            $error = 1;

            switch ($exception->getCode()) {
                case '405':
                    $msg = 'Não foi possível retornar a lista,<br/>pois o método útilizado não é permitido.';
                    break;
                case '501':
                    $msg = 'Não foi possível retornar a lista,<br/>pois model não exite. Provavelmente,<br/>ainda não foi criado.';
                    break;
                default:
                    $msg = 'Não foi possível retornar a lista.<br/>Favor tentar novamente. Caso o problema<br/>persista favor entrar em contato com o<br/>administrador do sistema.';
                    break;
            }
        }

        echo json_encode(compact('total', 'dados', 'error', 'msg', 'exception'));
        exit;
    }

    private function GetDataSource() {
        if (!isset($this->datasource)) {
            $this->datasource = ConnectionManager::getDataSource('default');
        }
    }

    #incia uma transação

    protected function StartTransaction() {
        $this->GetDataSource();
        $this->datasource->begin();
    }

    # efetiva uma trasação

    protected function CommitTransaction() {
        $this->GetDataSource();
        $this->datasource->commit();
    }

    #descarta uma transacao

    protected function RollbackTransaction() {
        $this->GetDataSource();
        $this->datasource->rollback();
    }

    public function validaTransacao($ok = NULL) {
        if ($ok) {
            fb::info("Commit", "");
            $this->CommitTransaction();
            return true;
        } else {
            fb::info("Rollback", "");
            $this->RollbackTransaction();
            return false;
        }
    }
    
    public function formataValorDouble($Cdata) {
        if ($Cdata != "") {
            $Cdata = str_replace('.', '', $Cdata);
            $Cdata = str_replace(',', '.', $Cdata);
            $Cdata = str_replace('R$ ', '', $Cdata);
        }
        return $Cdata;
    }

    public function formatWithMask($date, $condition)
    {
        if ($date == NULL) {
            return NULL;
        } else {
            $date = explode(' ', $date);
            $time = '';
            //$date = explode($condition, $date);
            if(count($date) >= 2) {
                $time = ' '.$date[1];
                $date = $date[0];
            } else {
                $date = $date[0];
            }
            $date = explode($condition, $date);
            return $date[2].'/'.$date[1].'/'.$date[0].$time;
        }
    }

    public function formatWithoutMask($date, $condition)
    {
        if ($date == NULL) {
            return NULL;
        } else {
            $date = explode(' ', $date);
            $time = '';
            //$date = explode($condition, $date);
            if(count($date) >= 2) {
                $time = ' '.$date[1];
                $date = $date[0];
            } else {
                $date = $date[0];
            }
            $date = explode($condition, $date);
            return $date[2].'-'.$date[1].'-'.$date[0].$time;
        }
    }

    public function curl_download($url) {
        $ch = curl_init();

//        curl_setopt($ch, CURLOPT_SSLVERSION,2); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36');
        curl_setopt($ch, CURLOPT_HEADER, false);        

        $output = curl_exec($ch);

        if ($output === false) {
            echo "Error Number:" . curl_errno($ch) . "<br>";
            echo "Error String:" . curl_error($ch);
        }

        curl_close($ch);
        return $output;
    }
}
