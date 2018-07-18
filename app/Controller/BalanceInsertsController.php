<?php

/**
 * Class RetiradasController
 *
 */
class BalanceInsertsController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    public function index($modal = 0) {

        $this->BalanceInsert->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
            ],
            'limit' => 1,
            'order' => array('BalanceInsert.id' => 'desc'),
            'contain' => [],
            'joins' => [
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'User.id = BalanceInsert.user_id'
                ),
                array(
                    'alias' => 'Owner',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'Owner.id = BalanceInsert.owner_id'
                ),
            ],
            'fields' => array('BalanceInsert.*, User.*, Owner.*'),
        );

        if(isset($query['name'])) {
            $options['conditions']['User.name LIKE'] = '%'.$query['name'].'%';
        }

        $this->paginate = $options;

        $dados = $this->paginate('BalanceInsert');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));

        $this->set('query', http_build_query($query));

        //die(var_dump($this->request->method()));
        if ($this->request->is('ajax') && $this->request->method() == 'GET') {
            $this->layout = false;
            $this->render('index_table');
        }

    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Contatos->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    /**
     * @param null $id
     * @throws \Mailgun\Messages\Exceptions\MissingRequiredMIMEParameters
     */
    public function insert($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->Balance->id = $id;
        if (!$this->Balance->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Balance']['id'] = $id;

            $key = $this->Session->read('Auth.User.key');
            $user_id = $this->Session->read('Auth.User.id');

            $this->StartTransaction();

            //Verificando a chave de segurança
            if($key != $this->request->data['Balance']['key']) {
                $this->Session->setFlash('Chave inválida', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                $this->render(false);
            } else if($this->request->data['Balance']['reason'] == '') {
                $this->Session->setFlash('Campo motivo inválido', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                $this->render(false);
            } else {
                $balance = $this->Balance->read(null, $id);
                $from = $balance['Balance']['value'];
                $this->request->data['Balance']['value'] = $amount = $this->App->formataValorDouble($this->request->data['Balance']['value']);
                $data_save['Balance']['id'] = $id;
                $data_save['Balance']['value'] = $to = $balance['Balance']['value'] + $this->request->data['Balance']['value'];
                $this->Balance->validate = [];
                if ($this->Balance->save($data_save)) {

                    $this->loadModel('BalanceInsert');
                    $this->BalanceInsert->recursive = -1;
                    $this->BalanceInsert->validate = [];
                    $balanceInsert['BalanceInsert']['owner_id'] = $balance['Balance']['owner_id'];
                    $balanceInsert['BalanceInsert']['user_id'] = $user_id;
                    $balanceInsert['BalanceInsert']['value'] = $this->request->data['Balance']['value'];
                    $balanceInsert['BalanceInsert']['reason'] = $this->request->data['Balance']['reason'];
                    $this->BalanceInsert->create();
                    $this->BalanceInsert->save($balanceInsert);


                    $this->loadModel('HistoricBalance');
                    $this->HistoricBalance->recursive = -1;
                    $this->HistoricBalance->validate = [];
                    $historicBalance['HistoricBalance']['owner_id'] = $balance['Balance']['owner_id'];
                    $historicBalance['HistoricBalance']['balance_id'] = $balance['Balance']['id'];
                    $historicBalance['HistoricBalance']['from'] = $from;
                    $historicBalance['HistoricBalance']['to'] = $to;
                    $historicBalance['HistoricBalance']['type'] = 1;
                    $historicBalance['HistoricBalance']['amount'] = $amount;
                    $historicBalance['HistoricBalance']['balance_insert_id'] = $this->BalanceInsert->id;
                    $historicBalance['HistoricBalance']['modality'] = 'balance';
                    $historicBalance['HistoricBalance']['description'] = 'balance';
                    $this->HistoricBalance->create();
                    $this->HistoricBalance->save($historicBalance);

                    $this->validaTransacao(true);

                    /*$this->loadModel('User');
                    $this->User->recursive = -1;
                    $user = $this->User->read(null, $balance['Balance']['owner_id']);

                    $view = new View($this);
                    $view->set('balance', $balance);
                    $view->set('user', $user);
                    $view->layout = false;
                    $view_output = $view->render('../Emails/html/mensagem_agente');

                    $mgClient = new Mailgun($_ENV['MAILGUN_SECRET']);

                    # Make the call to the client.
                    $result = $mgClient->sendMessage($_ENV['MAILGUN_DOMAIN'], array(
                        'from' => $_ENV['MAIL_FROM_NAME'] . ' <' . $_ENV['MAIL_FROM_ADDRESS'] . '>',
                        'to' => $user['User']['name'] . ' ' . $user['User']['last_name'] . ' <' . $user['User']['username'] . '>',
                        'subject' => 'Transferência efetuada com sucesso.',
                        'html' => $view_output
                    ));*/

                    $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                } else {
                    $this->validaTransacao(false);
                    $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                }
            }
        } else {
            $this->request->data = $this->Balance->read(null, $id);
            $balance = $this->Balance->read(null, $id);
            $this->loadModel('User');
            $this->User->recursive = -1;
            $user = $this->User->read(null, $balance['Balance']['owner_id']);
            $this->set('user', $user);
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->Balance->id = $id;
        if (!$this->Balance->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Balance']['id'] = $id;
            if ($this->Balance->save($this->request->data)) {

                $balance = $this->Balance->read(null, $id);

                $this->loadModel('User');
                $this->User->recursive = -1;
                $user = $this->User->read(null, $balance['Balance']['owner_id']);

                /*$email = new CakeEmail('mailgun');
                $email->to([$contato['Contato']['email'] => $contato['Contato']['name']])
                    ->template('resposta_contato', null)
                    ->emailFormat('html')
                    ->viewVars(['contato' => $contato])
                    ->subject('resposta')
                    ->send();*/

                $view = new View($this);
                $view->set('balance', $balance);
                $view->set('user', $user);
                $view->layout = false;
                $view_output = $view->render('../Emails/html/mensagem_agente');

                $mgClient = new Mailgun($_ENV['MAILGUN_SECRET']);

                # Make the call to the client.
                $result = $mgClient->sendMessage($_ENV['MAILGUN_DOMAIN'], array(
                    'from'    => $_ENV['MAIL_FROM_NAME'].' <'.$_ENV['MAIL_FROM_ADDRESS'].'>',
                    'to'      => $user['User']['name'].' '.$user['User']['last_name'].' <'.$user['User']['username'].'>',
                    'subject' => 'Transferência efetuada com sucesso.',
                    'html'    => $view_output
                ));

                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->loadModel('Country');
        $this->Country->recursive = -1;

        $this->request->data = $this->Balance->read(null, $id);
        $country = $this->Country->read(null, $this->request->data['Balance']['country_id']);
        $this->set('country', $country);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
