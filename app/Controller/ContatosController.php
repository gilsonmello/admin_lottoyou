<?php

App::uses('CakeMail', 'Network/Email');

class ContatosController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

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

                $contato = $this->Contato->read(null, $id);

                $email = new CakeEmail('mailgun');
                $email->to([$contato['Contato']['email'] => $contato['Contato']['name']])
                    ->template('resposta_contato')
                    ->emailFormat('html')
                    ->viewVars(['contato' => $contato])
                    ->subject('resposta')
                    ->send();
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
            $options['conditions']['Contato.name LIKE'] = '%'.$query['nome'].'%';
        }

        if(isset($query['email'])) {
            $options['conditions']['Contato.email LIKE'] = '%'.$query['email'].'%';
        }

        if(isset($query['dt_begin']) && !empty($query['dt_begin'])) {
            $dt_inicio = implode('-', array_reverse(explode('/', $query['dt_begin'])));
            $options['conditions']['Contato.created >='] = $dt_inicio . ' 00:00:00';
        }

        if(isset($query['dt_end']) && !empty($query['dt_end'])) {
            $dt_fim = implode('-', array_reverse(explode('/', $query['dt_end'])));
            $options['conditions']['Contato.created <='] = $dt_fim . ' 23:59:59';
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
