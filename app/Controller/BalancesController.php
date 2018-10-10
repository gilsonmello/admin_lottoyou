<?php

App::uses('CakeEmail', 'Network/Email');
require("../Vendor/mailgun-php/vendor/autoload.php");

use Mailgun\Mailgun;

/**
 * Class RetiradasController
 *
 */
class BalancesController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    var $uses = [
        'Balance',
        'BalanceWithdraw'
    ];

    public function index($modal = 0) {

        $this->Balance->recursive = -1;
        $query = $this->request->query;

        $balanceTotal = $this->Balance->find('first', [
            'fields' => [
                'SUM(Balance.value) AS balance_total'
            ],
        ]);


        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = array(
            'conditions' => [
            ],
            'limit' => 50,
            'order' => array('Owner.name' => 'asc', 'Owner.last_name' => 'asc'),
            'contain' => [],
            'joins' => [
                array(
                    'alias' => 'Owner',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'Owner.id = Balance.owner_id'
                ),

            ],
            'fields' => array('Balance.*, Owner.*'),
        );

        if(isset($query['name']) && $query['name'] != '') {
            $options['conditions']['Owner.name LIKE'] = '%'.$query['name'].'%';
        }

        if(isset($query['email']) && $query['email'] != '') {
            $options['conditions']['Owner.email LIKE'] = '%'.$query['email'].'%';
        }

        if(isset($query['conditional']) && $query['conditional'] != '') {

            $value = $this->App->formataValorDouble($query['value']);

            $options['conditions']['Balance.value '.$query['conditional']] = $value;

        }

        $this->paginate = $options;

        $dados = $this->paginate('Balance');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal', 'balanceTotal'));

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

    public function withdraw($id = null) {
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
                $amount = $this->request->data['Balance']['value'];
                $data_save['Balance']['id'] = $id;
                $data_save['Balance']['value'] = $to = $balance['Balance']['value'] - $this->request->data['Balance']['value'];
                //Verificando se o saldo é menor do que zero
                $data_save['Balance']['value'] = $data_save['Balance']['value'] < 0 ? 0 : $data_save['Balance']['value'];
                $this->Balance->validate = [];
                if ($this->Balance->save($data_save)) {

                    $this->loadModel('HistoricBalance');
                    $this->HistoricBalance->recursive = -1;
                    $this->HistoricBalance->validate = [];
                    $historicBalance['HistoricBalance']['owner_id'] = $balance['Balance']['owner_id'];
                    $historicBalance['HistoricBalance']['balance_id'] = $balance['Balance']['id'];
                    $historicBalance['HistoricBalance']['from'] = $from;

                    //Verificando se o saldo é menor do que zero
                    $to = $to < 0 ? 0 : $to;
                    $historicBalance['HistoricBalance']['to'] = $to;
                    $historicBalance['HistoricBalance']['type'] = 0;
                    $historicBalance['HistoricBalance']['amount'] = $amount > $balance['Balance']['value']
                        ? $balance['Balance']['value']
                        : ($amount ) * -1;
                    
                    //$historicBalance['HistoricBalance']['balance_insert_id'] = $this->BalanceInsert->id;
                    $historicBalance['HistoricBalance']['modality'] = 'withdrawal';
                    $historicBalance['HistoricBalance']['description'] = 'O sistema interno removeu R$'. $amount .' do seu saldo';
                    $historicBalance['HistoricBalance']['context'] = 'balance_withdraw';
                    $historicBalance['HistoricBalance']['context_message'] = 'internal.withdrawal';
                    $historicBalance['HistoricBalance']['system'] = 0;
                    $this->HistoricBalance->create();
                    $this->HistoricBalance->save($historicBalance);



                    $this->BalanceWithdraw->recursive = -1;
                    $this->BalanceWithdraw->validate = [];
                    $balanceWithdraw['BalanceWithdraw']['owner_id'] = $balance['Balance']['owner_id'];
                    $balanceWithdraw['BalanceWithdraw']['user_id'] = $user_id;
                    $balanceWithdraw['BalanceWithdraw']['finish'] = 1;
                    $balanceWithdraw['BalanceWithdraw']['value'] = $this->request->data['Balance']['value'];
                    $balanceWithdraw['BalanceWithdraw']['reason'] = $this->request->data['Balance']['reason'];
                    $balanceWithdraw['BalanceWithdraw']['historic_balance_id'] = $this->HistoricBalance->id;
                    $this->BalanceWithdraw->create();
                    $this->BalanceWithdraw->save($balanceWithdraw);


                    $this->validaTransacao(true);

                    $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                } else {
                    $this->validaTransacao(false);
                    $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                }
                $this->render(false);
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

                    $this->loadModel('HistoricBalance');
                    $this->HistoricBalance->recursive = -1;
                    $this->HistoricBalance->validate = [];
                    $historicBalance['HistoricBalance']['owner_id'] = $balance['Balance']['owner_id'];
                    $historicBalance['HistoricBalance']['balance_id'] = $balance['Balance']['id'];
                    $historicBalance['HistoricBalance']['from'] = $from;
                    $historicBalance['HistoricBalance']['to'] = $to;
                    $historicBalance['HistoricBalance']['type'] = 1;
                    $historicBalance['HistoricBalance']['amount'] = $amount;
                    //$historicBalance['HistoricBalance']['balance_insert_id'] = $this->BalanceInsert->id;
                    $historicBalance['HistoricBalance']['modality'] = 'deposit';
                    $historicBalance['HistoricBalance']['description'] = 'O sistema interno inseriu R$'. $amount .' no seu saldo';
                    $historicBalance['HistoricBalance']['context'] = 'balance_inserts';
                    $historicBalance['HistoricBalance']['context_message'] = 'internal.deposit';
                    $historicBalance['HistoricBalance']['system'] = 1;
                    $this->HistoricBalance->create();
                    $this->HistoricBalance->save($historicBalance);


                    $this->loadModel('BalanceInsert');
                    $this->BalanceInsert->recursive = -1;
                    $this->BalanceInsert->validate = [];
                    $balanceInsert['BalanceInsert']['owner_id'] = $balance['Balance']['owner_id'];
                    $balanceInsert['BalanceInsert']['user_id'] = $user_id;
                    $balanceInsert['BalanceInsert']['value'] = $this->request->data['Balance']['value'];
                    $balanceInsert['BalanceInsert']['reason'] = $this->request->data['Balance']['reason'];
                    $balanceInsert['BalanceInsert']['historic_balance_id'] = $this->HistoricBalance->id;
                    $this->BalanceInsert->create();
                    $this->BalanceInsert->save($balanceInsert);


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
