<?php

/**
 * Class LotPremiosController
 */
class RelTranPremiadasController extends AppController {

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
                'HistoricBalance.modality =' => 'award',
                'HistoricBalance.devolution' => 0
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
                ]
            ],
            'fields' => array(
                'HistoricBalance.id',
                'HistoricBalance.owner_id',
                'HistoricBalance.description',
                'HistoricBalance.amount',
                'HistoricBalance.type',
                'HistoricBalance.created',
                'HistoricBalance.context',
                'HistoricBalance.context_message',
                'Owner.id',
                'Owner.name',
                'Owner.last_name',
                'Owner.username',
            ),
        );

        if(isset($query['modality']) && is_array($query['modality'])) {
            if(in_array(1, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM soc_apostas SocAposta WHERE SocAposta.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
            }

            if(in_array(2, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM lot_users_jogos LotUserJogo WHERE LotUserJogo.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
            }

            if(in_array(3, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM raspadinhas Raspadinha WHERE Raspadinha.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
            }

            if(in_array(4, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM lea_classic_teams LeaClassicTeam WHERE LeaClassicTeam.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
            }

            if(in_array(5, $query['modality'])) {
                $options['conditions']['AND']['OR'][] = [
                    "exists (SELECT 1 FROM lea_cup_teams LeaCupTeam WHERE LeaCupTeam.historic_balance_id = HistoricBalance.id LIMIT 1)"
                ];
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

        $total = $this->HistoricBalance->find('first', [
            'joins' => [
                [
                    'alias' => 'Owner',
                    'table' => 'users',
                    'type' => 'LEFT',
                    'conditions' => 'Owner.id = HistoricBalance.owner_id'
                ]
            ],
            'fields' => [
                'SUM(HistoricBalance.amount) AS total',
                'HistoricBalance.amount',
                'HistoricBalance.owner_id',
                'Owner.id',
            ],
            'conditions' => $options['conditions'],
        ]);
        /*
        $totalSaida = $this->HistoricBalance->find('first', [
            'fields' => [
                'SUM(HistoricBalance.amount) AS total_saida'
            ],
            'conditions' => [
                'HistoricBalance.type' => 0
            ]
        ]);*/

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
        $this->set('total', $total);
        $this->set('model', $this->HistoricBalance);

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

}
