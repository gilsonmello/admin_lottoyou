<?php
/**
 * CakePHP UsersController
 * @author 
 */
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {

    public $components = array('ExtAuth', 'Auth', 'Session', 'RequestHandler', 'ClientInfo.ClientInfo');

    public function beforeFilter() {
        parent::beforeFilter();
        

        #Permitindo que os usuários se registrem
        $this->Auth->allow('apiEdit', 'assign', 'logout', 'login', 'keepalive', 'forgot_password', 'recover_password', 'confirm_password', 'deny_password_recover', 'access_denied', 'change_photo', 'lock', 'check', 'contatos', 'auth_login', 'auth_callback');
    }



    //Método responsável por receber requisição do servidor de frontend
    public function apiEdit() {
        CakeLog::info(print_r($_POST, true));

    }

    /*
     * Funções CRUD do model USER
     */
    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();    

        //var_dump($this->Session->read('Auth.User'));           

        // PREPARA MODEL       
        $this->User->recursive = 1;
        $this->User->validate = array();

        // TRATA CONDIÇÕES
        foreach($options['conditions'] as $field => $value){
            if ($field == 'User.name'){
                $options['conditions'][$field.' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }

        $options['conditions']['deleted'] = null;
        
        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->User->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados','modal'));
    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        // SALVA USUÁRIO
        if ($this->request->is('post') || $this->request->is('put')) {
            // INICIALIZA VARIÁVEIS
            $msg = "Registro salvo com sucesso.";
            $class = "alert-success";

            // INICIA A TRANSAÇÃO
            $this->User->begin();


            unset($this->User->validate['key']);
            
            try {
                // VERIFICA SE A AÇÃO É PARA INSERIR UM NOVO REGISTRO
                if (!isset($this->request->data['User']['id'])){
                    // GERA CÓDIGO HASH ANTES DE SALVAR
                    $this->request->data['User']['passwordchangecode'] = md5(time() * rand() . $this->request->data['User']['username']);
                }

                // CADASTRA O USUÁRIO
                if ($this->User->save($this->request->data)) {
                    // ENVIA E-MAIL PARA CONFIRMAÇÃO DE CADASTRO
                    $this->loadModel('SisEmailTemplate');
                    $dados = $this->SisEmailTemplate->findByCodigo('CONFIRMARCADASTRO');
                    
                    $to = $this->request->data['User']['username'];
                    $subject = $dados['SisEmailTemplate']['assunto'];
                    $message = $dados['SisEmailTemplate']['html'];

                    App::uses('HtmlHelper', 'View/Helper');
                    $html = new HtmlHelper(new View());
                    $link_confirmacao = $html->url(array('controller'=>'users','action'=>'confirm_password', $this->User->getLastInsertID(), $this->request->data['User']['passwordchangecode']), true);

                    // INFORMA PARÂMTROS DO E-MAIL 
                    $message = str_replace('{{nome}}', $this->request->data['User']['name'], $message);
                    $message = str_replace('{{link_confirmacao}}', $link_confirmacao, $message);
                    $message = str_replace('{{email}}', $this->request->data['User']['username'], $message);

                    /*if ($this->enviarEmail($to, $subject, $message)){
                        // CONFIRMA TRANSAÇÃO
                        $this->User->commit(); 
                    }*/
                    $this->User->commit();
                } else {
                    // DESFAZ TRANSAÇÃO
                    $this->User->rollback();   
                    
                    $msg = 'Não foi possível editar o registro. Favor tentar novamente.';
                    $class = "alert-danger";   
                    
                    if (isset($this->User->validationErrors['gel_empresa_id'])){
                        $msg .= '<br/>* Empresa destino não identificada.';
                    }
                }
            } catch (Exception $e) {
                // DESFAZ TRANSAÇÃO
                $this->User->rollback();   

                $msg = 'Não foi possível editar o registro. Favor tentar novamente.';
                $class = "alert-danger";                     
            }

            // EXIBE RESULTADO
            $this->Session->setFlash($msg, 'alert', array('plugin' => 'BoostCake', 'class' => $class));
        } else {
            // DADOS DO USUÁRIO
            $grupo_tipo = CakeSession::read('Auth.User.Group.tipo');

            // PEGA LISTA DE GRUPOS ATIVOS
            $this->set('groups', $this->User->Group->find('list', array('conditions' => array('Group.tipo' => $grupo_tipo))));

            // ENVIA DADOS PARA A VIEW
            $this->set(compact('grupo_tipo'));
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->request->data['User']['password2'] != '') {
                $this->request->data['User']['password'] = $this->request->data['User']['password2'];
            }

            if ($this->User->save($this->request->data)) {
                if ($this->request->is('ajax')) {
                    $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                } else {
                    //VERIFICA SE O USUÁRIO LOGADO PARA DEFINIR COMO SERÁ FEITO O REDIREDIONAMENTO
                    if (!$this->Session->check('Auth.User.id')) {
                        $this->redirect(array('action' => 'login'));
                    }
                }
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));

                if (isset($this->User->validationErrors['password'])){
                    $this->User->validationErrors['password2'] = $this->User->validationErrors['password'];
                }
            }
        } else {
            // PEGA DADOS DO USUÁRIO
            $this->request->data = $this->User->read(null, $id);
            
            // REMOVE SENHA DO ARRAY, POIS A SENHA SALVA NÃO DEVE SER EXIBIDA
            unset($this->request->data['User']['password']);

            // DADOS DO USUÁRIO
            $grupo_tipo = CakeSession::read('Auth.User.Group.tipo');

            // PEGA LISTA DE GRUPOS ATIVOS
            /*$this->set('groups', $this->User->Group->find('list', array('conditions' => array('Group.tipo' => $grupo_tipo))));*/

            $this->set('groups', $this->User->Group->find('list', array('conditions' => array())));

            // ENVIA DADOS PARA A VIEW
            $this->set(compact('grupo_tipo'));
        }
    }

    public function delete($id = null) {

        $this->autoRender =  false;
        $user = $this->User->read(null, $id);
        $user['User']['deleted'] = date('Y-m-d H:i:s');

        $msg = 'Error ao deletar usuário';
        $error = 1;

        $this->User->validate = [];

        if ($this->User->save($user)) {
            $msg = 'Registro excluído com sucesso.';
            $error = 0;
        }

        echo json_encode(compact('error', 'msg', 'exception', 'code'));
        exit;

    }

    /*
     * Função restrira para desenvolvedores e administradores do sistema 
     * deve ser utilizada para facilitar o processo de cadastramento de novas
     * funcionalidades e associar funcionalidades a perfis e módulos
     */
    public function restrict($modal = 0) {
        // PEGA PERMISSOES
        $dadosPermissions = $this->requestAction(array('controller'=>'permissions', 'action'=>'index'));

        // PEGA FUNCIONLIDADES
        $dadosFuncionalidades = $this->requestAction(array('controller'=>'funcionalidades', 'action'=>'index'));
        
        // PEGA MÓDULOS
        $dadosModulos = $this->requestAction(array('controller'=>'modulos', 'action'=>'index'));
        
        // PEGA GRUPOS
        $dadosGrupos = $this->requestAction(array('controller'=>'groups', 'action'=>'index'));

        // PEGA USUÁRIO
        $dadosUser = $this->User->read(null,$this->Session->read('Auth.User.id'));
        
        // ENVIA DADOS PARA A VIEW
        $this->set(compact('modal','dadosFuncionalidades','dadosPermissions','dadosModulos','dadosGrupos','dadosUser'));
    }

    /*
     * Funções para manipulação de dados do perfil do usuário 
     */
    public function profile() {
        // CRIA VALIDAÇÃO DE CAMPOS DO FORMULÁRIO
        $this->User->validate['name'] = array('required' => array('rule' => 'notEmpty', 'message' => 'Nome obrigatório.', 'required' => true));
        $this->User->validate['active'] = array('required' => array('rule' => 'notEmpty', 'message' => 'Ativo obrigatório.', 'required' => true));

        // PEGA ID DA SESSÃO
        $id = $this->Session->read('Auth.User.id');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Conta atualizada com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                $this->redirect(array('action' => 'profile'));
                /*if($this->request->is('ajax')){
                   $error = 0;
                   $url = Router::url(array('action'=>'index'), true);
                   echo json_encode(compact('error','url'));
                   exit;
                } else {
                   $this->redirect(array('action' => 'login'));
                }*/
            } else {
                $this->Session->setFlash('Não foi possível atualizar a senha. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));

                $this->request->data = $this->User->find('first', array('conditions' => array('User.id' => $id)));
                unset($this->request->data['User']['password']);
                $this->set('groups', $this->User->Group->find('list', array('conditions' => array('Group.id' => $this->request->data['User']['group_id']))));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            $this->request->data['User']['born'] = ($this->request->data['User']['born'] == '31/12/1969') ? '' : $this->request->data['User']['born'];
            $grupos = array();
            unset($this->request->data['User']['password']);
            $this->loadModel('Group');
            if($this->request->data['User']['group_id'] != 1){
                $grupos =  $this->Group->find('list', array('conditions' => array('Group.id <>' => array('1','2'))));                
            }
            $this->set(compact('grupos'));
            $this->set('groups', $this->User->Group->find('list', array('conditions' => array('Group.id' => $this->request->data['User']['group_id']))));
        }
    }

    public function change_photo($user_id) {
        if (!empty($_FILES)) {
            $parts = pathinfo($_FILES['file']['name']);
            $tempFile = $_FILES['file']['tmp_name'];
            $targetPath = 'img/avatar/';
            //$newFileName = $user_id.'-'.date('ymdHis').'.'.$parts['extension'];
            $newFileName = $user_id . '.' . strtolower($parts['extension']);
            $targetFile = $targetPath . $newFileName;
            $error = 0;

            if (move_uploaded_file($tempFile, $targetFile)) {
                // SALVA NO BANCO NO NOME DA IMAGEM
                $data['User']['id'] = $user_id;
                $data['User']['photo'] = strtolower($newFileName);
                $data['User']['modified'] = date('d/m/Y H:i:s');
                $this->User->id = $user_id;
                $this->User->save($data, false);
                $this->Session->write('Auth.User.photo',$data['User']['photo']);
                $error = 0;
            } else {
                $error = 1;
            }

            echo json_encode(compact('error'));
            exit;
        }
    }

    /*
     * Funções de cadastro, autenticação, confirmação e recuperação de senha.
     * Estas funcionalidades devem ser irrestritras, permitindo o acesso a 
     * qualquer usuário idenpedente se possui ou não senha de acesso
     */
    public function login() {

        if ($this->request->is('post')) {
            // VERIFICA SE O USUÁRIO INFORMOU AS CREDENCIAIS DE ACESSO CORRETAMENTE
            if ($this->Auth->login()) {
                // LIBERA O ACESSO A APLICAÇÕES BÁSICAS PARA UTILIZAÇÃO DO SISTEMA
                $dados = $this->Session->read('Auth.User');

                App::import('Model', 'Group');
                $thisGroup = new Group;

                // VERIFICA SE IRÁ CARREGAR OS DADOS DE PERMISSÃO DA BASE OU DA SESSÃO
                if (Configure::read('checkPermissionInSession') == 1 && $this->Session->check('Auth.User.Permission')) {
                    $data = $this->Session->read('Auth.User.Permission');
                } else {
                    // PESQUISA PERMISSÕES DO GRUPO
                    $data = $thisGroup->getFuncionalidadesPermissoes($dados['group_id']);
                    $this->Session->write('Auth.User.Permission', $data);
                }

                // VERIFICA SE O USUÁRIO ESTÁ AUTORIZADO A ENTRAR NO SISTEMA
                if ($dados['active'] == 1) {
                    // VERIFICA SE O USUÁRIO IRÁ PERMANCER LOGADO OU NÃO
                    if (isset($this->request->data['User']['rememberMe']) && $this->request->data['User']['rememberMe'] == 1) {
                        // AFTER WHAT TIME FRAME SHOULD THE COOKIE EXPIRE
                        $cookieTime = "1 week"; // YOU CAN DO E.G: 1 WEEK, 17 WEEKS, 14 DAYS
                        // REMOVE "REMEMBER ME CHECKBOX"
                        unset($this->request->data['User']['rememberMe']);

                        // HASH THE USER'S PASSWORD FOR GUARENTEE THE SECURITY
                        $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);

                        // WRITE THE COOKIE
                        $this->Cookie->write('rememberMe', $this->request->data['User'], true, $cookieTime);
                    }

                    // SETA EMPRESA INICIAL
                    $this->Session->write('Auth.Company', $dados['GelEmpresa']);

                    // REGISTRA O ACESSO DO USUÁRIO
                    $now = date('Y-m-d H:i:s');
                    $this->User->id = $dados['id'];
                    $this->User->saveField('last_login', $now);

                    // REDIRECIONA PARA A HOME DO SISTEMA
                    return $this->redirect($this->Auth->redirect());
                } else {
                    if ($dados['passwordchangecode'] == '') {
                        $this->Session->setFlash('<h4>Cadastro inativado</h4>', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                    } else {
                        $this->Session->setFlash('<h4>Cadastro bloqueado</h4>A confirmação do e-mail enviado durante o cadastro é obrigatória para liberar seu acesso ao sistema.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                    }
                }
            } else {
                $this->Session->setFlash('<h4>E-mail e/ou Senha incorretos</h4> Verifique as informações e tente novamente...', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            // SE EXISTIR ALGUMA MENSAGEM A EXIBIR, NÃO EXIBE A MENSAGEM PADRÃO
            if (!$this->Session->check('Message.flash')) {
                //$this->Session->setFlash('Para entrar preencha o formulário e clique em <b>Entrar</b>.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-info'));
            }
        }
    }

    public function lock() {
        // ALTERA O LAYOUT
        $this->layout = 'ajax';

        // CAPITURA DADOS DO USUÁRIO LOGADO
        $user_id = $this->Session->read('Auth.User.id');
        $dados = $this->User->read(null, $user_id);

        $name = $dados['User']['name'];
        $username = $dados['User']['username'];
        $photo = $dados['User']['photo'];

        // ENVIA DADOS PARA VIEW
        $this->set(compact('name', 'username', 'photo'));

        // MATA A SESSÃO DO USUÁRIO
        $this->Auth->logout();
    }

    public function check() {
        $error = 0;
        $msg = '';

        if ($this->request->is('post')) {
            // VERIFICA SE O USUÁRIO INFORMOU AS CREDENCIAIS DE ACESSO CORRETAMENTE
            if ($this->Auth->login()) {
                // LIBERA O ACESSO A APLICAÇÕES BÁSICAS PARA UTILIZAÇÃO DO SISTEMA
                $dados = $this->Session->read('Auth.User');

                // VERIFICA SE O USUÁRIO ESTÁ AUTORIZADO A ENTRAR NO SISTEMA
                if ($dados['active'] == 1) {
                    // VERIFICA SE O USUÁRIO IRÁ PERMANCER LOGADO OU NÃO
                    if (isset($this->request->data['User']['rememberMe']) && $this->request->data['User']['rememberMe'] == 1) {
                        // After what time frame should the cookie expire
                        $cookieTime = "1 week"; // You can do e.g: 1 week, 17 weeks, 14 days
                        // remove "remember me checkbox"
                        unset($this->request->data['User']['rememberMe']);

                        // hash the user's password for guarentee the security
                        $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);

                        // write the cookie
                        $this->Cookie->write('rememberMe', $this->request->data['User'], true, $cookieTime);
                    }

                    // REGISTRA O ACESSO DO USUÁRIO
                    $now = date('Y-m-d H:i:s');
                    $this->User->id = $dados['id'];
                    $this->User->saveField('last_login', $now);
                } else {
                    if ($dados['passwordchangecode'] == '') {
                        $msg = 'Senha inativa.';
                        $error = 1;
                    } else {
                        $msg = 'Senha bloqueada.';
                        $error = 1;
                    }
                }
            } else {
                $msg = 'Senha incorreta.';
                $error = 1;
            }
        } else {
            $msg = 'Senha obrigatória.';
            $error = 1;
        }

        if ($error == 0){
            $this->Session->setFlash('Login revalidado com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
        } else {
            $this->Session->setFlash('Erro ao efetuar o login: <br/><b>'.$msg.'</b>', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }
    }

    public function logout() {
        // MATA O COOKIE CRIADO
        $this->Cookie->delete('rememberMe');

        // REMOVE DADOS DA SESSÃO
        $this->Session->delete('Auth');
        $this->Session->delete('ClientInfo');

        // ENCERRA A SESSÃO
        $url = $this->Auth->logout();

        // EFETUA O REDIRECIONAMENTO
//        $this->redirect($url);
        $this->redirect('../');
    }

    public function forgot_password() {
        if ($this->request->is('post') || $this->request->is('put')) {

            // VERIFICA SE O E-MAIL DO USUÁRIO EXISTE
            $dados = $this->User->find('first', array('conditions' => array('username' => $this->request->data['User']['username'])));

            if ($dados) {
                // INICIA TRANSAÇÃO
                $this->User->begin();

                $num_code = str_replace('.','',substr(time()*rand(), 0, 6));
                $md5_code = $dados['User']['passwordchangecode'] = md5($num_code . $dados['User']['username']);
                $data['User']['id'] = Set::classicExtract($dados, 'User.id');
                $data['User']['username'] = Set::classicExtract($dados, 'User.username');
                $data['User']['passwordchangecode'] = Set::classicExtract($dados, 'User.passwordchangecode');

                if ($this->User->save($data, false)) {
                    // ENVIA E-MAIL PARA CONFIRMAÇÃO DE CADASTRO
                    $this->loadModel('SisEmailTemplate');
                    $template = $this->SisEmailTemplate->findByCodigo('RECUPERARSENHA');
                    
                    $to = $data['User']['username'];
                    $subject = $template['SisEmailTemplate']['assunto'];
                    $message = $template['SisEmailTemplate']['html'];

                    App::uses('HtmlHelper', 'View/Helper');
                    $html = new HtmlHelper(new View());
                    $link_redefinicao = $html->url(array('controller'=>'users','action'=>'recover_password', $data['User']['id'], $dados['User']['passwordchangecode']), true);
                    $link_aviso_email_pessoa_errada = $html->url(array('controller'=>'users','action'=>'deny_password_recover', $data['User']['id'], $dados['User']['passwordchangecode']), true);

                    // INFORMA PARÂMTROS DO E-MAIL 
                    $message = str_replace('{{nome}}', $dados['User']['name'], $message);
                    $message = str_replace('{{link_redefinicao}}', $link_redefinicao, $message);
                    $message = str_replace('{{email}}', $dados['User']['username'], $message);
                    $message = str_replace('{{codigo_redefinicao}}', $num_code, $message);
                    $message = str_replace('{{link_aviso_email_pessoa_errada}}', $link_aviso_email_pessoa_errada, $message);

                    if ($this->enviarEmail($to, $subject, $message)){
                        // SE TUDO OCORREU BEM CONFIRMA A TRANSAÇÃO
                        $this->User->commit();
                        $this->Session->setFlash('<h4>Acabamos de te enviar um e-mail para confirmação.</h4>Favor verificar sua caixa de entrada e seguir as instruções de recuperação de senha.</div>', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                        $this->redirect(array('action' => 'confirm_password',$data['User']['id'],'code', true));
                    } else {
                        // CASO CONTRÁRIO DESFAZ A TRANSAÇÃO
                        $this->User->rollback();
                        $this->Session->setFlash('<b>Atenção!</b> Ocorreu um erro ao tentar recuperar a senha. Tente novamente mais tarde.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                        $this->redirect(array('action' => 'login'));
                    }
                } else {
                    $this->Session->setFlash('<b>Atenção!</b> Ocorreu um erro ao tentar recuperar a senha. Tente novamente mais tarde.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                }
            } else {
                $this->Session->setFlash('<h4>Atenção!</h4> O e-mail informado não possui conta associada.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            //$this->Session->setFlash('Para recuperar sua senha de acesso informe seu e-mail e clique em <b>Recuperar</b>.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-info'));
        }
    }

    public function confirm_password($user_id = null, $key = null, $by_code = false) {
        // VERIFICA SE FOI PASSADA A CHAVE
        if ($user_id == null || $key == null) {
            $this->Session->setFlash('<b>Error: </b>Chave de confirmação de senha de acesso inexistente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            $this->redirect(array('action' => 'login'));
        }

        // CARREGA DADOS DO USUÁRIO CASO ELE EXISTA
        $this->User->recursive = 0;
        $user = $this->User->findById($user_id);

        // VERIFICA SE O USUÁRIO EXISTE
        if ($user) {
            // VERIFICA FORMATO DE CONFIRMAÇÃO
            if ($by_code){
                // SE INFORMOU O CÓDIGO
                if ($this->request->is(array('post','put'))){
                    // MONTA HASH DE VERIFICAÇÃO
                    $key = md5($this->data['User']['codigo'] . $user['User']['username']);

                    // VERIFICA FORMATO DO CÓDIGO DE REDEFINICAÇÃO DE SENHA
                    if ($this->data['User']['codigo'] == '' || strlen($this->data['User']['codigo']) != 6) {
                        $this->Session->setFlash('<b>Error: </b>Código de redefinição de senha inválido.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                    } else {
                        // VERIFICA SE A CHAVE É IGUAL A EXISTENTE NO CADASTRO DO USUÁRIO
                        if ($user['User']['passwordchangecode'] == $key) {
                            // CONFIRMA CADASTRO DE SENHA DE ACESSO
                            $this->redirect(array('action' => 'recover_password', $user['User']['active'], $key));
                        } else {
                            $this->Session->setFlash('<b>Error: </b>Chave de confirmação inexistente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                            $this->redirect(array('action' => 'login'));
                        }
                    }
                }
            } else {
                // VERIFICA SE A CHAVE É IGUAL A EXISTENTE NO CADASTRO DO USUÁRIO
                if ($user['User']['passwordchangecode'] == $key) {
                    // CONFIRMA CADASTRO DE SENHA DE ACESSO
                    $user['User']['active'] = 1;
                    $user['User']['passwordchangecode'] = '';
                    unset($user['User']['password']);

                    // SALVA OS DADOS DO USUÁRIO
                    if ($this->User->save($user, false)) {
                        $this->Session->setFlash('<h4>Confirmação de cadastro realizado com sucesso.</h4>Para acessar o sistema preencha o formulário abaixo e clique em entrar.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                        $this->redirect(array('action' => 'login'));
                    } else {
                        $this->Session->setFlash('<b>Error: </b>A confirmação de cadastro não pode ser realizada.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                        $this->redirect(array('action' => 'login'));
                    }
                } else {
                    $this->Session->setFlash('<b>Error: </b>Chave de confirmação inexistente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                    $this->redirect(array('action' => 'login'));
                }
            }
        } else {
            // USUÁRIO INEXISTENTE
            $this->Session->setFlash('<b>Error: </b>Chave de confirmação inexistente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            $this->redirect(array('action' => 'login'));
        }
    }

    public function recover_password($user_id = null, $key = null) {
        // Verifica se foi passado a chave
        if ($key == null) {
            $this->Session->setFlash('<h4>Atenção!</h4>Chave de recuperação de senha de acesso inexistente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            $this->redirect(array('action' => 'login'));
        }

        // Verifica se realmente existe um usuário com a chave passada
        $this->User->recursive = 0;
        $user = $this->User->findByPasswordchangecode($key);

        if (!$user) {
            $this->Session->setFlash('<h4>Atenção!</h4>Não há pedido de recuperação de senha para o usuário informado. Caso o erro persista entre em contato conosco através do e-mail: <h4><a href="mailto:sac@consultoriatrend.com.br">sac@consultoriatrend.com.br</a></h4>', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            $this->redirect(array('action' => 'login'));
        } else {
            $this->Session->setFlash('Para recuperar sua senha de acesso preencha o formulário<br/>e clique em <b>Recuperar</b>.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-info'));
        }

        $datacompleta = explode(' ', $user['User']['modified']);
        $data = $datacompleta[0];
        $hora = $datacompleta[1];
        $datadividida = explode('/', $data);
        $user['User']['modified'] = $datadividida[2] . '-' . $datadividida[1] . '-' . $datadividida[0] . ' ' . $hora;

        // Verifica se ainda está dentro do prazo de validade estabelecido nas configurações
        $prazo_validate = Configure::read('NucleOS.password_change_code.limit');
        $data_start = strtotime($user['User']['modified']);
        $data_end = strtotime(date("Y-m-d H:i:s"));
        $diff = $data_end - $data_start;

        App::uses('HtmlHelper', 'View/Helper');
        $html = new HtmlHelper(new View());
        $link_esquecesenha = $html->url(array('controller'=>'users','action'=>'forgot_password'), true);

        if ($diff > $prazo_validate) {
            $this->Session->setFlash('<h4>Atenção!</h4>O prazo para recuperação de senha expirou. Para iniciar novamente o processo de recuperação de senha clique em "<b><a href="'.$link_esquecesenha.'">Esqueceu sua senha?</a></b>".', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            $this->redirect(array('action' => 'login'));
        }

        $this->set(array('user_id'=>$user['User']['id']));

        if ($this->request->is('post') || $this->request->is('put')) {
            // Define o campo passwordchangecode como vazio para não mais permitir a alteração da senha
            // a nao ser que o usuário inicie o novo processo
            $this->request->data['User']['passwordchangecode'] = '';

            // Obtém os dados necessários para serem validados
            $this->request->data['User']['name'] = $user['User']['name'];
            $this->request->data['User']['username'] = $user['User']['username'];

            // Inicia transação
            $this->User->begin();

            // Obtém os outros dados para permtir
            if ($this->User->save($this->request->data)) {
                // ENVIA E-MAIL PARA CONFIRMAÇÃO DE CADASTRO
                $this->loadModel('SisEmailTemplate');
                $template = $this->SisEmailTemplate->findByCodigo('REDEFINICAOSENHA');
                
                $to = $user['User']['username'];
                $subject = $template['SisEmailTemplate']['assunto'];
                $message = $template['SisEmailTemplate']['html'];

                App::uses('HtmlHelper', 'View/Helper');
                $html = new HtmlHelper(new View()); 
                $link_redefinicao = $html->url(array('controller'=>'users','action'=>'recover_password', $user['User']['id'], $user['User']['passwordchangecode']), true);
                $link_bloquear_acesso = $html->url(array('controller'=>'users','action'=>'deny_password_recover', $user['User']['id'], md5($user['User']['username'])), true);

                $aux = CakeSession::read('ClientInfo.Browser');

                // INFORMA PARÂMTROS DO E-MAIL 
                $message = str_replace('{{nome}}', $user['User']['name'], $message);
                $message = str_replace('{{email}}', $user['User']['username'], $message);
                $message = str_replace('{{sistema_operacional}}', CakeSession::read('ClientInfo.Os'), $message);
                $message = str_replace('{{navegador}}', $aux['name'].'('.$aux['version'].')', $message);
                $message = str_replace('{{ip}}', $this->RequestHandler->getClientIp(), $message);
                $message = str_replace('{{data_hora}}', strftime('%A, %d de %B de %Y', strtotime('today')).' às '.date('H:i:s'), $message);
                $message = str_replace('{{link_bloquear_acesso}}', $link_bloquear_acesso, $message);

                if ($this->enviarEmail($to, $subject, $message)){
                    // SE TUDO OCORREU BEM CONFIRMA A TRANSAÇÃO
                    $this->User->commit();

                    $this->Session->setFlash('<h4>Acabamos de te enviar um e-mail para confirmação.</h4>Favor verificar sua caixa de entrada e seguir as instruções de recuperação de senha.</div>', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                } else {
                    // CASO CONTRÁRIO DESFAZ A TRANSAÇÃO
                    $this->User->rollback();
                }

                $this->Session->setFlash('<h4>Senha de acesso recuperada com sucesso.</h4>Para entrar no sistema preencha o formulário e clique em <b>Entrar</b>.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash('<h4>Atenção!</h4>A senha não pode ser alterada. Favor verificar e tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                //$this->redirect(array('action' => 'recover_password', $key));
            }
        }
    }

    public function deny_password_recover($user_id = null, $key = null){
        // Verifica se foi passado a chave
        if ($key == null) {
            $this->Session->setFlash('<h4>Atenção!</h4>Chave de recuperação de senha de acesso inexistente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            $this->redirect(array('action' => 'login'));
        }

        // Verifica se realmente existe um usuário com a chave passada
        $this->User->recursive = 0;
        $user = $this->User->findById($user_id);

        if (!$user) {
            $this->Session->setFlash('<h4>Atenção!</h4>Não há pedido de recuperação de senha para o usuário informado. Caso o erro persista entre em contato conosco através do e-mail: <h4><a href="mailto:sac@consultoriatrend.com.br">sac@consultoriatrend.com.br</a></h4>', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            $this->redirect(array('action' => 'login'));
        } else {
            $this->Session->setFlash('Para recuperar sua senha de acesso preencha o formulário<br/>e clique em <b>Recuperar</b>.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-info'));
        }
    }

    public function keepalive() {
        session_start();
        if ($this->Session->check('Auth.User')) {
            echo 'OK';
        } else {
            echo 'NOK';
        }
        exit;
    }

    public function auth_login($provider) {
     
    }

    public function auth_callback($provider) {
        
    }

    private function __successfulExtAuth($incomingProfile, $accessToken) {
       
        
    }

    private function __doAuthLogin($user) {
        
        
    }

    public function assign($dadosRedeSocial = array()) {

       
    }
}