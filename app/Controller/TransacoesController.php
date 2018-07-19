<?php

/**
 * Class LotPremiosController
 */
class TransacoesController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    var $uses = [
        'HistoricBalance'
    ];

    public function index($modal = 0) {

        $this->HistoricBalance->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
            ],
            'limit' => 50,
            'order' => array('HistoricBalance.id' => 'desc'),
            'contain' => [],
            'joins' => [
                array(
                    'alias' => 'Owner',
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => 'Owner.id = HistoricBalance.owner_id'
                ),
                array(
                    'alias' => 'LotUserJogo',
                    'table' => 'lot_users_jogos',
                    'type' => 'LEFT',
                    'conditions' => 'LotUserJogo.historic_balance_id = HistoricBalance.id'
                ),
                array(
                    'alias' => 'SocAposta',
                    'table' => 'soc_apostas',
                    'type' => 'LEFT',
                    'conditions' => 'SocAposta.historic_balance_id = HistoricBalance.id'
                ),
                array(
                    'alias' => 'Raspadinha',
                    'table' => 'raspadinhas',
                    'type' => 'LEFT',
                    'conditions' => 'Raspadinha.historic_balance_id = HistoricBalance.id'
                ),
                array(
                    'alias' => 'PedidoPaypal',
                    'table' => 'paypal_orders',
                    'type' => 'LEFT',
                    'conditions' => 'PedidoPaypal.historic_balance_id = HistoricBalance.id'
                ),
                array(
                    'alias' => 'PedidoPagseguro',
                    'table' => 'pagseguro_orders',
                    'type' => 'LEFT',
                    'conditions' => 'PedidoPagseguro.historic_balance_id = HistoricBalance.id'
                ),
                array(
                    'alias' => 'Item',
                    'table' => 'order_items',
                    'type' => 'LEFT',
                    'conditions' => 'Item.historic_balance_id = HistoricBalance.id'
                ),
                array(
                    'alias' => 'BalanceInsert',
                    'table' => 'balance_inserts',
                    'type' => 'LEFT',
                    'conditions' => 'BalanceInsert.historic_balance_id = HistoricBalance.id'
                ),
                array(
                    'alias' => 'RetiradaAgente',
                    'table' => 'agent_withdraw',
                    'type' => 'LEFT',
                    'conditions' => 'RetiradaAgente.historic_balance_id = HistoricBalance.id'
                ),
            ],
            'fields' => array(
                'HistoricBalance.*',
                'Owner.*',
                'LotUserJogo.*',
                'SocAposta.*',
                'Raspadinha.*',
                'PedidoPaypal.*',
                'PedidoPagseguro.*',
                'Item.*',
                'BalanceInsert.*',
                'RetiradaAgente.*',
            ),
        );

        if(isset($query['nome'])) {
            $options['conditions']['Owner.name LIKE'] = '%'.$query['nome'].'%';
        }

        if(isset($query['dt_inicio']) && !empty($query['dt_inicio'])) {
            $dt_inicio = implode('-', array_reverse(explode('/', $query['dt_inicio'])));
            $options['conditions']['HistoricBalance.created >='] = $dt_inicio . ' 00:00:00';
        }

        if(isset($query['dt_fim']) && !empty($query['dt_fim'])) {
            $dt_fim = implode('-', array_reverse(explode('/', $query['dt_fim'])));
            $options['conditions']['HistoricBalance.created <='] = $dt_fim . ' 23:59:59';
        }

        /*if(isset($query['lot_categoria_id']) && $query['lot_categoria_id'] != '') {
            $options['conditions']['LotCategoria.id ='] = $query['lot_categoria_id'];
        }*/

        $this->paginate = $options;

        $dados = $this->paginate('HistoricBalance');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));

        $this->set('query', http_build_query($query));

        /*$this->loadModel('LotCategoria');
        $this->LotCategoria->recursive = -1;
        $categorias = $this->LotCategoria->find('list', [
            'conditions' => [

            ]
        ]);
        $this->set('categorias', $categorias);*/

        //die(var_dump($this->request->method()));
        if ($this->request->is('ajax') && $this->request->method() == 'GET') {
            $this->layout = false;
            $this->render('index_table');
        }

    }

    /**
     *
     */
    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            $value = $this->request->data['LotPremio']['value'];
            $this->request->data['LotPremio']['value'] = $this->App->formataValorDouble($value);
            if ($this->LotPremio->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
        $this->loadModel('LotCategoria');
        $this->LotCategoria->recursive = -1;
        $categorias = $this->LotCategoria->find('list', [
            'conditions' => [

            ]
        ]);
        $this->set('categorias', $categorias);
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LotPremio->id = $id;
        if (!$this->LotPremio->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $value = $this->request->data['LotPremio']['value'];
            $this->request->data['LotPremio']['id'] = $id;
            $this->request->data['LotPremio']['value'] = $this->App->formataValorDouble($value);
            if ($this->LotPremio->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->LotPremio->read(null, $id);
        $this->loadModel('LotCategoria');
        $this->LotCategoria->recursive = -1;
        $categorias = $this->LotCategoria->find('list', [
            'conditions' => [

            ]
        ]);
        $this->set('categorias', $categorias);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}