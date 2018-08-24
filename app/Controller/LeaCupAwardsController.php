<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Class RetiradasController
 *
 */
class LeaCupAwardsController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    var $uses = [
        'LeaCupAward',
        'LeaCup'
    ];

    public function index($modal = 0) {

        $this->LeaCupAward->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
            ],
            'limit' => 50,
            'order' => array('LeaCupAward.id' => 'desc'),
            'contain' => [],
            'joins' => [
            ],
            //'fields' => array('Retirada.*', 'Agent.*, Country.*'),
        );

        if(isset($query['lea_cup_id']) && $query['lea_cup_id'] != '') {
            $options['conditions']['LeaCupAward.lea_cup_id'] = $query['lea_cup_id'];
        }

        /*if(isset($query['email'])) {
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

        $dados = $this->paginate('LeaCupAward');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));

        $this->set('query', http_build_query($query));
        $this->set('model', $this->LeaCupAward);
        $this->set('optionsLeaCup', $this->LeaCup->find('list'));

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
            $this->request->data['LeaCupAward']['value'] = $this->App->formataValorDouble($this->request->data['LeaCupAward']['value']);
            if ($this->LeaCupAward->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
        $this->set('optionsLeaCup', $this->LeaCup->find('list'));
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LeaCupAward->id = $id;
        if (!$this->LeaCupAward->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['LeaCupAward']['id'] = $id;
            $this->request->data['LeaCupAward']['value'] = $this->App->formataValorDouble($this->request->data['LeaCupAward']['value']);
            if ($this->LeaCupAward->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->LeaCupAward->read(null, $id);
        $this->set('optionsLeaCup', $this->LeaCup->find('list'));
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
