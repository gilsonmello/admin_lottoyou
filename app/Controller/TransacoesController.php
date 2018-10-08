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

        //Diferente de premio e devolução
        $options = array(
            'conditions' => [
                'HistoricBalance.modality !=' => 'award',
                'HistoricBalance.devolution' => 0,
            ],
            'limit' => 50,
            'order' => array('HistoricBalance.id' => 'desc'),
            'contain' => [],
            'joins' => [
                [
                    'alias' => 'Owner',
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => 'Owner.id = HistoricBalance.owner_id'
                ]/*,
                [
                    'alias' => 'SocAposta',
                    'table' => 'soc_apostas',
                    'type' => 'LEFT',
                    'conditions' => 'SocAposta.historic_balance_id = HistoricBalance.id'
                ],
                [
                    'alias' => 'LotUserJogo',
                    'table' => 'lot_users_jogos',
                    'type' => 'LEFT',
                    'conditions' => 'LotUserJogo.historic_balance_id = HistoricBalance.id'
                ],
                [
                    'alias' => 'Raspadinha',
                    'table' => 'raspadinhas',
                    'type' => 'LEFT',
                    'conditions' => 'Raspadinha.historic_balance_id = HistoricBalance.id'
                ],
                [
                    'alias' => 'PedidoPaypal',
                    'table' => 'paypal_orders',
                    'type' => 'LEFT',
                    'conditions' => 'PedidoPaypal.historic_balance_id = HistoricBalance.id'
                ],
                [
                    'alias' => 'PedidoPagseguro',
                    'table' => 'pagseguro_orders',
                    'type' => 'LEFT',
                    'conditions' => 'PedidoPagseguro.historic_balance_id = HistoricBalance.id'
                ],
                [
                    'alias' => 'Item',
                    'table' => 'order_items',
                    'type' => 'LEFT',
                    'conditions' => 'Item.historic_balance_id = HistoricBalance.id'
                ],
                [
                    'alias' => 'BalanceInsert',
                    'table' => 'balance_inserts',
                    'type' => 'LEFT',
                    'conditions' => 'BalanceInsert.historic_balance_id = HistoricBalance.id'
                ],
                [
                    'alias' => 'RetiradaAgente',
                    'table' => 'agent_withdraw',
                    'type' => 'LEFT',
                    'conditions' => 'RetiradaAgente.historic_balance_id = HistoricBalance.id'
                ]*/
            ],
            'fields' => array(
                'HistoricBalance.id',
                'HistoricBalance.owner_id',
                'HistoricBalance.description',
                'HistoricBalance.amount',
                'HistoricBalance.type',
                'HistoricBalance.system',
                'HistoricBalance.created',
                'HistoricBalance.context',
                'HistoricBalance.message',
                'HistoricBalance.modality',
                'Owner.id',
                'Owner.name',
                'Owner.last_name',
                'Owner.username',
                /*'SocAposta.id',
                'LotUserJogo.id',
                'Raspadinha.id',
                'PedidoPaypal.id',
                'PedidoPagseguro.id',
                'Item.id',
                'BalanceInsert.id',
                'RetiradaAgente.id'*/
            ),
        );

        if(isset($query['modality']) && is_array($query['modality'])) {
            if(in_array(1, $query['modality'])) {
                /*$options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM soc_apostas SocAposta WHERE SocAposta.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];*/
                $options['conditions']['AND']['OR'][] = ['HistoricBalance.modality' => 'buy'];
            }

            if(in_array(2, $query['modality'])) {
                /*$options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM lot_users_jogos LotUserJogo WHERE LotUserJogo.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];*/
                $options['conditions']['AND']['OR'][] = ['HistoricBalance.modality' => 'deposit'];
            }

            if(in_array(3, $query['modality'])) {
                /*$options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM lot_users_jogos LotUserJogo WHERE LotUserJogo.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];*/
                $options['conditions']['AND']['OR'][] = ['HistoricBalance.modality' => 'withdrawal'];
            }

            /*if(in_array(3, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM raspadinhas Raspadinha WHERE Raspadinha.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
            }

            if(in_array(4, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM paypal_orders PedidoPaypal WHERE PedidoPaypal.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
            }

            if(in_array(5, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM pagseguro_orders PedidoPagseguro WHERE PedidoPagseguro.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
            }

            if(in_array(6, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM order_items Orderitem WHERE Orderitem.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
            }

            if(in_array(7, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM balance_inserts BalanceInsert WHERE BalanceInsert.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
            }

            if(in_array(8, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM balance_withdraw BalanceWithdraw WHERE BalanceWithdraw.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
            }*/
        }

        if(isset($query['type']) && is_array($query['type'])) {

            if(in_array(1, $query['type'])) {
                $options['conditions']['OR'][]['HistoricBalance.description'] = 'buy';
            }

            if(in_array(2, $query['type'])) {
                $options['conditions']['OR'][]['HistoricBalance.description'] = 'agent withdrawal';
            }

            /*if(in_array(3, $query['type'])) {
                $options['conditions']['OR'][]['HistoricBalance.description'] = 'award';
            }*/

            if(in_array(4, $query['type'])) {
                $options['conditions']['OR'][]['HistoricBalance.description'] = 'internal withdrawal';
            }

            if(in_array(5, $query['type'])) {
                $options['conditions']['OR'][]['HistoricBalance.description'] = 'paypal deposit';
            }

            if(in_array(6, $query['type'])) {
                $options['conditions']['OR'][]['HistoricBalance.description'] = 'pagseguro deposit';
            }

            if(in_array(7, $query['type'])) {
                $options['conditions']['OR'][]['HistoricBalance.description'] = 'internal deposit';
            }

            if(in_array(8, $query['type'])) {
                $options['conditions']['OR'][]['HistoricBalance.context'] = 'league classic';
            }

            if(in_array(9, $query['type'])) {
                $options['conditions']['OR'][]['HistoricBalance.context'] = 'league cup';
            }

        }

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

        $totalEntradaConditions = $options['conditions'];
        $totalEntradaConditions['HistoricBalance.system'] = 1;
        $totalEntrada = $this->HistoricBalance->find('first', [
            'joins' => [
                [
                    'alias' => 'Owner',
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => 'Owner.id = HistoricBalance.owner_id'
                ]
            ],
            'fields' => [
                //'ABS(SUM(HistoricBalance.amount)) AS total_entrada'
                'SUM(ABS(HistoricBalance.amount)) AS total_entrada'
            ],
            'conditions' => $totalEntradaConditions,
        ]);


        $totalSaidaConditions = $options['conditions'];
        $totalSaidaConditions['HistoricBalance.system'] = 0;
        $totalSaida = $this->HistoricBalance->find('first', [
            'joins' => [
                [
                    'alias' => 'Owner',
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => 'Owner.id = HistoricBalance.owner_id'
                ]
            ],
            'fields' => [
                //'ABS(SUM(HistoricBalance.amount)) AS total_entrada'
                'SUM(ABS(HistoricBalance.amount)) AS total_saida'
            ],
            'conditions' => $totalSaidaConditions,
        ]);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
        $this->set('model', $this->HistoricBalance);
        $this->set('totalEntrada', $totalEntrada);
        $this->set('totalSaida', $totalSaida);


        $this->set('query_string', http_build_query($query));

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
