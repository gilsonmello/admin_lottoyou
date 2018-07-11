<?php

App::uses('CakeEmail', 'Network/Email');

//require("../Vendor/sendgrid-php/sendgrid-php.php");
require("../Vendor/mailgun-php/vendor/autoload.php");

use Mailgun\Mailgun;

class ContatosController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    private function sendEmail($id) {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://lottoyou.bet/api/contacts/'.$id.'/reply_email',
            CURLOPT_POST => 1,
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Send the request & save response to $resp
        $resp = curl_exec($curl);

        // Close request to clear up some resources
        curl_close($curl);

        return $resp;
    }

    public function answer($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->Contato->id = $id;
        $this->Contato->validate = [];
        if (!$this->Contato->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Contato']['id'] = $id;
            $this->request->data['Contato']['answered'] = 1;
            if ($this->Contato->save($this->request->data)) {

                //$this->sendEmail($id);
                $contato = $this->Contato->read(null, $id);

                /*$email = new CakeEmail('mailgun');
                $email->to([$contato['Contato']['email'] => $contato['Contato']['name']])
                    ->template('resposta_contato', null)
                    ->emailFormat('html')
                    ->viewVars(['contato' => $contato])
                    ->subject('resposta')
                    ->send();*/

                $view = new View($this);
                $view->set('contato', $contato);
                $view->layout = false;
                $view_output = $view->render('../Emails/html/resposta_contato');

                $mgClient = new Mailgun();
                $domain = "lottoyou-adm.com";

                # Make the call to the client.
                $result = $mgClient->sendMessage($domain, array(
                    'from'    => $_ENV['MAIL_FROM_NAME'].' <'.$_ENV['MAIL_FROM_ADDRESS'].'>',
                    'to'      => $contato['Contato']['name'].' <'.$contato['Contato']['email'].'>',
                    'subject' => 'Resposta',
                    'html'    => $view_output
                ));


                /*$email = new \SendGrid\Mail\Mail();
                $email->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
                $email->setSubject("Resposta");
                $email->addTo($contato['Contato']['email'], $contato['Contato']['name']);

                $email->addContent(
                    "text/html", $view_output
                );

                $sendgrid = new \SendGrid($_ENV['SENDGRID_API_KEY']);
                try {
                    $response = $sendgrid->send($email);
                    print $response->statusCode() . "\n";
                    print_r($response->headers());
                    print $response->body() . "\n";
                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }*/

                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->Contato->read(null, $id);
    }

    public function index($modal = 0) {

        $this->Contato->recursive = -1;
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
                    'alias' => 'ContatoCategoria',
                    'table' => 'contact_categories',
                    'type' => 'INNER',
                    'conditions' => 'Contato.category_id = ContatoCategoria.id'
                ),
            ],
            'fields' => array('Contato.*', 'ContatoCategoria.*'),
        );

        if(isset($query['name'])) {
            $options['conditions']['Contato.name LIKE'] = '%'.$query['name'].'%';
        }

        if(isset($query['email'])) {
            $options['conditions']['Contato.email LIKE'] = '%'.$query['email'].'%';
        }

        if(isset($query['dt_begin']) && $query['dt_begin'] != '') {
            $dt_inicio = implode('-', array_reverse(explode('/', $query['dt_begin'])));
            $options['conditions']['Contato.created >='] = $dt_inicio . ' 00:00:00';
        }

        if(isset($query['dt_end']) && $query['dt_end'] != '') {
            $dt_fim = implode('-', array_reverse(explode('/', $query['dt_end'])));
            $options['conditions']['Contato.created <='] = $dt_fim . ' 23:59:59';
        }

        if(isset($query['answered']) && $query['answered'] != '') {
            $options['conditions']['Contato.answered'] = $query['answered'];
        }

        $this->paginate = $options;

        $dados = $this->paginate('Contato');

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

        $this->loadModel('TemasRaspadinha');
        $optionsTemas = $this->TemasRaspadinha->find('list');
        $this->set(compact('optionsTemas'));

        $this->Contato->id = $id;
        if (!$this->Contato->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Contato']['id'] = $id;
            if ($this->Contato->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->Contato->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
