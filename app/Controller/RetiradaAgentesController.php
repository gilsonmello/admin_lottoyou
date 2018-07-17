<?php

App::uses('CakeEmail', 'Network/Email');
require("../Vendor/mailgun-php/vendor/autoload.php");

use Mailgun\Mailgun;

/**
 * Class RetiradasController
 *
 */
class RetiradaAgentesController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    public function index($modal = 0) {

        $this->RetiradaAgente->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
            ],
            'limit' => 10,
            'order' => array('id' => 'desc'),
            'contain' => [],
            'joins' => [
                array(
                    'alias' => 'Retirada',
                    'table' => 'balance_withdraw',
                    'type' => 'INNER',
                    'conditions' => 'RetiradaAgente.withdraw_id = Retirada.id'
                ),
                array(
                    'alias' => 'Country',
                    'table' => 'countries',
                    'type' => 'INNER',
                    'conditions' => 'RetiradaAgente.country_id = Country.id'
                ),
            ],
            'fields' => array('Retirada.*', 'RetiradaAgente.*, Country.*'),
        );

        if(isset($query['name'])) {
            $options['conditions']['RetiradaAgente.name LIKE'] = '%'.$query['name'].'%';
        }

        if(isset($query['dt_begin']) && $query['dt_begin'] != '') {
            $dt_inicio = implode('-', array_reverse(explode('/', $query['dt_begin'])));
            $options['conditions']['RetiradaAgente.created >='] = $dt_inicio . ' 00:00:00';
        }

        if(isset($query['dt_end']) && $query['dt_end'] != '') {
            $dt_fim = implode('-', array_reverse(explode('/', $query['dt_end'])));
            $options['conditions']['RetiradaAgente.created <='] = $dt_fim . ' 23:59:59';
        }

        $this->paginate = $options;

        $dados = $this->paginate('RetiradaAgente');

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

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->RetiradaAgente->id = $id;
        if (!$this->RetiradaAgente->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['RetiradaAgente']['id'] = $id;
            if ($this->RetiradaAgente->save($this->request->data)) {

                $retiradaAgente = $this->RetiradaAgente->read(null, $id);

                $this->loadModel('User');
                $this->User->recursive = -1;
                $user = $this->User->read(null, $retiradaAgente['RetiradaAgente']['owner_id']);

                /*$email = new CakeEmail('mailgun');
                $email->to([$contato['Contato']['email'] => $contato['Contato']['name']])
                    ->template('resposta_contato', null)
                    ->emailFormat('html')
                    ->viewVars(['contato' => $contato])
                    ->subject('resposta')
                    ->send();*/

                $view = new View($this);
                $view->set('retiradaAgente', $retiradaAgente);
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

        $this->request->data = $this->RetiradaAgente->read(null, $id);
        $country = $this->Country->read(null, $this->request->data['RetiradaAgente']['country_id']);
        $this->set('country', $country);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
