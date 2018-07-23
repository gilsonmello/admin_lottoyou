<?php

class RelatorioRaspadinhasController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    var $uses = [
        'RasLote',
        'Raspadinha',
        'TemasRaspadinha'
    ];

    public function index($modal = 0) {
        $query = $this->request->query;
        $this->Raspadinha->recursive = -1;
        $this->RasLote->recursive = -1;
        $this->TemasRaspadinha->recursive = -1;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [],
            'limit' => 50,
            //'order' => array('RasLote.id' => 'desc'),
            'contain' => [],
            'joins' => [
                /*array(
                    'alias' => 'RasLote',
                    'table' => 'ras_lotes',
                    'type' => 'LEFT',
                    'conditions' => 'RasLote.id = Raspadinha.lote'
                ),*/
                array(
                    'alias' => 'TemasRaspadinha',
                    'table' => 'temas_raspadinhas',
                    'type' => 'LEFT',
                    'conditions' => 'TemasRaspadinha.id = RasLote.temas_raspadinha_id'
                ),
            ],
            'fields' => [
                'RasLote.id',
                'RasLote.nome',
                'RasLote.qtd_raspadinhas',
                'TemasRaspadinha.id',
                'TemasRaspadinha.nome',
            ],
        );


        if(isset($query['temas_raspadinha_id']) && $query['temas_raspadinha_id'] != '') {
            $options['conditions']['TemasRaspadinha.id'] = $query['temas_raspadinha_id'];
        }

        if(isset($query['lote_id']) && $query['lote_id'] != '') {
            $options['conditions']['RasLote.id'] = $query['lote_id'];
        }

        /*if(isset($query['modalidade']) && $query['modalidade'] != '') {
            if($query['modalidade'] == 0) {
                $options['conditions']['NOT'] = ['OrderItem.soccer_expert_id' => null];
            } else if($query['modalidade'] == 1) {
                $options['conditions']['NOT'] = ['OrderItem.lottery_id' => null];
            } else if($query['modalidade'] == 2) {
                $options['conditions']['NOT'] = ['OrderItem.scratch_card_id' => null];
            }
        }*/
        /*
            if(isset($query['dt_inicio']) && !empty($query['dt_inicio'])) {
                $dt_inicio = implode('-', array_reverse(explode('/', $query['dt_inicio'])));
                $options['conditions']['OrderItem.created_at >='] = $dt_inicio . ' 00:00:00';
            }

            if(isset($query['dt_fim']) && !empty($query['dt_fim'])) {
                $dt_fim = implode('-', array_reverse(explode('/', $query['dt_fim'])));
                $options['conditions']['OrderItem.created_at <='] = $dt_fim . ' 23:59:59';
            }*/

        $this->paginate = $options;

        $dados = $this->paginate('RasLote');

        $optionsLotes = $this->RasLote->find('list', [

        ]);

        $optionsTemas = $this->TemasRaspadinha->find('list', [

        ]);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal', 'optionsLotes', 'optionsTemas'));

        $this->set('model', $this->RasLote);

        $this->set('query', http_build_query($query));

        //die(var_dump($this->request->method()));
        if ($this->request->is('ajax') && $this->request->method() == 'GET') {
            $this->layout = false;
            $this->render('index_table');
        }
    }
}
