<?php

class RelatorioItensController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    public function index($modal = 0) {

        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [],
            'limit' => 50,
            'order' => array('id' => 'desc'),
            'contain' => [],
            'joins' => [
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'User.id = OrderItem.user_id'
                ),
            ],
            'fields' => array('User.*', 'OrderItem.*'),
        );


        $this->loadModel('OrderItem');
        $this->OrderItem->recursive = -1;
        $this->OrderItem->validate = [];

        if(isset($query['nome'])) {
            $options['conditions']['User.name LIKE'] = '%'.$query['nome'].'%';
        }

        if(isset($query['email'])) {
            $options['conditions']['User.username LIKE'] = '%'.$query['email'].'%';
        }

        if(isset($query['modalidade']) && $query['modalidade'] != '') {
            if($query['modalidade'] == 0) {
                $options['conditions']['NOT'] = ['OrderItem.soccer_expert_id' => null];
            } else if($query['modalidade'] == 1) {
                $options['conditions']['NOT'] = ['OrderItem.lottery_id' => null];
            } else if($query['modalidade'] == 2) {
                $options['conditions']['NOT'] = ['OrderItem.scratch_card_id' => null];
            }
        }

        if(isset($query['dt_inicio']) && !empty($query['dt_inicio'])) {
            $dt_inicio = implode('-', array_reverse(explode('/', $query['dt_inicio'])));
            $options['conditions']['OrderItem.created_at >='] = $dt_inicio . ' 00:00:00';
        }

        if(isset($query['dt_fim']) && !empty($query['dt_fim'])) {
            $dt_fim = implode('-', array_reverse(explode('/', $query['dt_fim'])));
            $options['conditions']['OrderItem.created_at <='] = $dt_fim . ' 23:59:59';
        }

        $this->paginate = $options;

        $dados = $this->paginate('OrderItem');

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

        $this->loadModel('TemasRaspadinha');
        $optionsTemas = $this->TemasRaspadinha->find('list');
        $this->set(compact('optionsTemas'));
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->RasTabelasDesconto->save($this->request->data)) {
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

        $this->RasTabelasDesconto->id = $id;
        if (!$this->RasTabelasDesconto->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['RasTabelasDesconto']['id'] = $id;
            if ($this->RasTabelasDesconto->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->RasTabelasDesconto->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
