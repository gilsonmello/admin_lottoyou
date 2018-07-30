<?php

/**
 * Class RetiradasController
 *
 */
class BalanceInsertsController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    public function index($modal = 0) {

        $this->BalanceInsert->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
            ],
            'limit' => 50,
            'order' => array('BalanceInsert.id' => 'desc'),
            'contain' => [],
            'joins' => [
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'User.id = BalanceInsert.user_id'
                ),
                array(
                    'alias' => 'Owner',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'Owner.id = BalanceInsert.owner_id'
                ),
            ],
            'fields' => array('BalanceInsert.*, User.*, Owner.*'),
        );

        if(isset($query['nome']) && $query['nome'] != '') {
            $options['conditions']['Owner.name LIKE'] = '%'.$query['nome'].'%';
        }

        if(isset($query['email']) && $query['email'] != '') {
            $options['conditions']['Owner.username ='] = '%'.$query['email'].'%';
        }

        if(isset($query['dt_inicio']) && !empty($query['dt_inicio'])) {
            $dt_inicio = implode('-', array_reverse(explode('/', $query['dt_inicio'])));
            $options['conditions']['BalanceInsert.created >='] = $dt_inicio . ' 00:00:00';
        }

        if(isset($query['dt_fim']) && !empty($query['dt_fim'])) {
            $dt_fim = implode('-', array_reverse(explode('/', $query['dt_fim'])));
            $options['conditions']['BalanceInsert.created <='] = $dt_fim . ' 23:59:59';
        }

        $this->paginate = $options;

        $dados = $this->paginate('BalanceInsert');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
        $total = $this->BalanceInsert->find('first', [
            'joins' => [
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'User.id = BalanceInsert.user_id'
                ),
                array(
                    'alias' => 'Owner',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'Owner.id = BalanceInsert.owner_id'
                ),
            ],
            'fields' => [
                //'ABS(SUM(HistoricBalance.amount)) AS total_entrada'
                'SUM(ABS(BalanceInsert.value)) AS total'
            ],
            'conditions' => $options['conditions'],
        ]);

        $this->set('query', http_build_query($query));
        $this->set('total', $total);

        //die(var_dump($this->request->method()));
        if ($this->request->is('ajax') && $this->request->method() == 'GET') {
            $this->layout = false;
            $this->render('index_table');
        }

    }
}
