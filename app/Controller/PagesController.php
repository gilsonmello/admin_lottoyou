<?php
App::uses('AppController', 'Controller');

/**
 * Pages Controller.
 * 
 * Controller responsável por gerenciar as páginas do site.
 */
class PagesController extends AppController {

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @return void
     */
    public function beforeFilter() {
        // LIBERA ACESSO AO CONTEÚDO DO SITE
        $this->Auth->allow(array('home','cadastro','checaEmail'));

        // CONFIGURA LAYOUT
        $this->layout = 'site';
    }

    /**
     * Displays home
     *
     * @return void
     */
    public function home(){

        $this->redirect(['controller' => 'users', 'action' => 'login']);
        
        // PEGA REQUISIÇÕES CADASTRADOS
//        $this->loadModel('Promocao');
//        $dados = $this->Promocao->find('all', array(
//            'fields' => array('User.name', 'Promocao.*'),
//            'joins' => array(
//                array(
//                    'table' => 'users',
//                    'alias' => 'User',
//                    'type' => 'inner',
//                    'conditions' => array('User.id = Promocao.user_id')
//                )
//            )
//        ));

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados'));
    }

    public function cadastro(){
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        // SALVA O REGISTRO CASO O FORMULÁRIO SEJA SUBMITADO
        if ($this->request->is('post') || $this->request->is('put')) {
            // IMPORTA MODELS
            $this->loadModel('User');
            $this->loadModel('GelEmpresa');
            $this->loadModel('FinCategoria');

            // INICIALIZA VARIÁVEIS
            $empresaData['GelEmpresa']['nome'] = $this->data['Cadastro']['empresa'];
            $empresaData['GelEmpresa']['matriz'] = 1;
            $userData['User']['name'] = $this->data['Cadastro']['nome'];
            $userData['User']['phone'] = $this->data['Cadastro']['telefone'];
            $userData['User']['username'] = $this->data['Cadastro']['email'];
            $userData['User']['password'] = $this->data['Cadastro']['senha'];
            $userData['User']['group_id'] = $this->data['Cadastro']['group_id'];
            $userData['User']['active'] = 0;
            $msg = array();
            $error = 0;

            // VERIFICA DADOS DA EMPRESA
            $this->GelEmpresa->create($empresaData);
            unset($this->GelEmpresa->validate['gel_empresa_id']);
            unset($this->GelEmpresa->validate['user_id']);
            if (!$this->GelEmpresa->validates()){
                $invalidFields = $this->GelEmpresa->validationErrors;
                $error = 1;

                if (isset($invalidFields['nome'])){
                    $msg[]['empresa'] = $invalidFields['nome'];
                }
            } else {
                // SIMULA UMA EMPRESA PARA VALIDAR. DURANTE O CADASTRO O ID
                // SERÁ INFORMADO CORRETAMENTE
                $userData['User']['gel_empresa_id'] = 1;

                // VERIFICA DADOS DO USUÁRIO
                $this->User->create($userData);
                if (!$this->User->validates($userData)){
                    $invalidFields = $this->User->validationErrors;
                    $error = 1;

                    if (isset($invalidFields['name'])){
                        $msg[]['nome'] = $invalidFields['name'];
                    }

                    if (isset($invalidFields['phone'])){
                        $msg[]['telefone'] = $invalidFields['phone'];
                    }

                    if (isset($invalidFields['password'])){
                        $msg[]['senha'] = $invalidFields['password'];
                    }

                    if (isset($invalidFields['username'])){
                        $msg[]['email'] = $invalidFields['username'];
                    }
                } 
            }
            
            // VERIFICA SE NÃO HÁ ERROS   
            if (count($msg) == 0 && $error == 0){
                // INICIA UMA TRANSAÇÃO
                $this->User->begin();

                // CADASTRA EMPRESA
                $resultGelEmpresa = $this->GelEmpresa->save($empresaData);
                $gel_empresa_id = $this->GelEmpresa->getLastInsertID();

                // CADASTRA USUÁRIO
                $userData['User']['gel_empresa_id'] = $gel_empresa_id;
                $userData['User']['passwordchangecode'] = md5(time() * rand() . $userData['User']['username']);
                $resultUser = $this->User->save($userData);
                $user_id = $this->User->getLastInsertID();

                // ATUALIZA DADOS DA EMPRESA
                $this->GelEmpresa->id = $gel_empresa_id;
                $this->GelEmpresa->save(array('GelEmpresa'=>array('gel_empresa_id'=>$gel_empresa_id, 'user_id' => $user_id)));

                // CADASTRA PRINCIPAIS CATEGORIAS DE DESPESA
                $resultFinCategoria = $this->FinCategoria->setCategoriasPrincipais($gel_empresa_id, $user_id);
                
                if ($resultGelEmpresa && $resultUser && $resultFinCategoria){
                    // ENVIA E-MAIL PARA CONFIRMAÇÃO DE CADASTRO
                    $this->loadModel('SisEmailTemplate');
                    $dados = $this->SisEmailTemplate->findByCodigo('CONFIRMARCADASTRO');
                    
                    $to = $userData['User']['username'];
                    $subject = $dados['SisEmailTemplate']['assunto'];
                    $message = $dados['SisEmailTemplate']['html'];

                    App::uses('HtmlHelper', 'View/Helper');
                    $html = new HtmlHelper(new View());
                    $link_confirmacao = $html->url(array('controller'=>'users','action'=>'confirm_password', $user_id, $userData['User']['passwordchangecode']), true);

                    // INFORMA PARÂMTROS DO E-MAIL 
                    $message = str_replace('{{nome}}', $userData['User']['name'], $message);
                    $message = str_replace('{{link_confirmacao}}', $link_confirmacao, $message);
                    $message = str_replace('{{email}}', $userData['User']['username'], $message);

                    if ($this->enviarEmail($to, $subject, $message, 'falecom@gopontoaponto.com.br')){
                        // SE TUDO OCORREU BEM CONFIRMA A TRANSAÇÃO
                        $this->User->commit();

                        $this->Session->setFlash('<h4>Acabamos de te enviar um e-mail.</h4> Para liberar seu acesso ao sistema, primeiro confirme o recebimento deste e-mail.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-info'));
                    } else {
                        // CASO CONTRÁRIO DESFAZ A TRANSAÇÃO
                        $this->User->rollback();
                    }
                } else {
                    // CASO CONTRÁRIO DESFAZ A TRANSAÇÃO
                    $this->User->rollback();
                    $error = 1;
                }
            } else {
                //fb($invalidFields);
            }

            echo json_encode(compact('error', 'msg'));
            exit;
        }
    }

    public function checaEmail(){
        // INICIALIZA VARIÁVEIS
        $email = strtolower(trim($this->data['email']));
        $error = 0;
        
        // VERIFICA FORMATO DO E-MAIL
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = 1;
        } else {
            // VERIFICA DOMÍNIO
            $aux = explode('@',$email);
            if(!checkdnsrr($aux[1],'A')){
                $error = 1;
            }
        }

        // CONSULTA O E-MAIL NA BASE DE DADOS DE USUÁRIO
        $this->loadModel('User');
        $total = $this->User->find('count', array('conditions'=>array('username'=>$email)));

        // VERIFICA SE O E-MAIL INFORMADO JÁ ESTÁ EM USO
        if ($total > 0){
            $error = 2;
        }
        
        // ENVIA DADOS PARA A SESSÃO
        echo json_encode(compact('error'));
        exit;
    }

    public function unauthorized(){
        // CONFIGURA LAYOUT
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        } else {
            $this->layout = 'default';
        }
    }

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     * @throws NotFoundException When the view file could not be found
     *  or MissingViewException in debug mode.
     */
    /*public function display() {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        
        // CONFIGURA O LAYOUT
        if ($path[0] == 'unauthorized'){
            $this->layout = 'default';
        }

        try {
            $this->render(implode('/', $path));
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }*/
}
