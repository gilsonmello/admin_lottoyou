<?php

class RelatorioPaypalDepositosController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    public function index($modal = 0) {

        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
                'BalanceOrder.submit' => 1,
                'NOT' => [
                    'BalanceOrder.status_paypal' => null,
                ]
            ],
            'limit' => 10,
            'order' => array('id' => 'desc'),
            'contain' => [],
            'joins' => [
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'User.id = BalanceOrder.owner_id'
                ),
            ],
            'fields' => array('User.*', 'BalanceOrder.*'),
        );


        $this->loadModel('BalanceOrder');
        $this->BalanceOrder->recursive = -1;
        $this->BalanceOrder->validate = [];

        if(isset($query['nome'])) {
            $options['conditions']['User.name LIKE'] = '%'.$query['nome'].'%';
        }

        if(isset($query['status']) && $query['status'] != '') {
            $options['conditions']['BalanceOrder.status_paypal'] = $query['status'];
        }

        if(isset($query['email'])) {
            $options['conditions']['User.username LIKE'] = '%'.$query['email'].'%';
        }

        if(isset($query['valor']) && $query['valor'] != '') {
            $valor = $this->App->formataValorDouble($query['valor']);
            $options['conditions']['BalanceOrder.sub_total'] = $valor;
        }

        if(isset($query['dt_inicio']) && !empty($query['dt_inicio'])) {
            $dt_inicio = implode('-', array_reverse(explode('/', $query['dt_inicio'])));
            $options['conditions']['BalanceOrder.created >='] = $dt_inicio . ' 00:00:00';
        }

        if(isset($query['dt_fim']) && !empty($query['dt_fim'])) {
            $dt_fim = implode('-', array_reverse(explode('/', $query['dt_fim'])));
            $options['conditions']['BalanceOrder.created <='] = $dt_fim . ' 23:59:59';
        }

        $this->paginate = $options;

        $dados = $this->paginate('BalanceOrder');

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
