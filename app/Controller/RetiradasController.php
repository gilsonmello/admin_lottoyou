<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Class RetiradasController
 *
 */
class RetiradasController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    public function index($modal = 0) {

        $this->Retirada->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
            ],
            'limit' => 50,
            'order' => array('id' => 'desc'),
            'contain' => [],
            'joins' => [
                array(
                    'alias' => 'Agent',
                    'table' => 'withdraw_agent',
                    'type' => 'INNER',
                    'conditions' => 'Retirada.id = Agent.withdraw_id'
                ),
                array(
                    'alias' => 'Country',
                    'table' => 'countries',
                    'type' => 'INNER',
                    'conditions' => 'Agent.country_id = Country.id'
                ),
            ],
            'fields' => array('Retirada.*', 'Agent.*, Country.*'),
        );

        /*if(isset($query['name'])) {
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
        }*/

        $this->paginate = $options;

        $dados = $this->paginate('Retirada');

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

        $this->Retirada->id = $id;
        if (!$this->Retirada->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Retirada']['id'] = $id;
            if ($this->Retirada->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->Retirada->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
