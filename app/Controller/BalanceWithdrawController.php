<?php

/**
 * Class RetiradasController
 *
 */
class BalanceWithdrawController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    var $uses = [
        'BalanceWithdraw'
    ];

    public function index($modal = 0) {

        $this->BalanceWithdraw->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
            ],
            'limit' => 50,
            'order' => array('BalanceWithdraw.id' => 'desc'),
            'contain' => [],
            'joins' => [
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'User.id = BalanceWithdraw.user_id'
                ),
                array(
                    'alias' => 'Owner',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'Owner.id = BalanceWithdraw.owner_id'
                ),
            ],
            'fields' => array('BalanceWithdraw.*, User.*, Owner.*'),
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

        $dados = $this->paginate('BalanceWithdraw');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));

        $this->set('query', http_build_query($query));

        //die(var_dump($this->request->method()));
        if ($this->request->is('ajax') && $this->request->method() == 'GET') {
            $this->layout = false;
            $this->render('index_table');
        }

    }
}
