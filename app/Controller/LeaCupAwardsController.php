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
        'League',
        'LeagueAward'
    ];

    public function index($modal = 0) {

        $this->LeagueAward->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
                'LeagueAward.context' => 'cup'
            ],
            'limit' => 50,
            'order' => array('LeagueAward.id' => 'desc'),
            'contain' => [],
            'joins' => [
                [
                    'alias' => 'LeaCupAward',
                    'table' => 'lea_cup_awards',
                    'type' => 'INNER',
                    'conditions' => 'LeaCupAward.league_award_id = LeagueAward.id'
                ]
            ],
            'fields' => array('LeagueAward.*', 'LeaCupAward.*'),
        );

        if(isset($query['lea_cup_id']) && $query['lea_cup_id'] != '') {
            $options['conditions']['LeagueAward.lea_cup_id'] = $query['lea_cup_id'];
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

        $dados = $this->paginate('LeagueAward');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));

        $this->set('query', http_build_query($query));
        $this->set('model', $this->LeagueAward);
        $this->set('optionsLeague', $this->League->find('list', [
            'conditions' => [
                'League.context' => 'cup'
            ]
        ]));

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
            //$this->request->data['LeagueAward']['value'] = $this->App->formataValorDouble($this->request->data['LeagueAward']['value']);
            $this->request->data['LeagueAward']['context'] = 'cup';
            if ($this->LeagueAward->save($this->request->data)) {
                $this->LeaCupAward->create();
                $cup['LeaCupAward']['league_award_id'] = $this->LeagueAward->id;
                $this->LeaCupAward->save($cup);
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
        $this->set('optionsLeague', $this->League->find('list', [
            'conditions' => [
                'League.context' => 'cup'
            ]
        ]));
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LeaCupAward->id = $id;
        if (!$this->LeaCupAward->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $award = $this->LeaCupAward->read(null, $id);

            $leaAwardId = $award['LeaCupAward']['league_award_id'];

            $this->request->data['LeagueAward']['id'] = $leaAwardId;
            //$this->request->data['LeagueAward']['value'] = $this->App->formataValorDouble($this->request->data['LeagueAward']['value']);
            if ($this->LeagueAward->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $award = $this->LeaCupAward->read(null, $id);
            $leaAwardId = $award['LeaCupAward']['league_award_id'];
            $this->request->data = $this->LeagueAward->read(null, $leaAwardId);
            $this->set('optionsLeague', $this->League->find('list', [
                'conditions' => [
                    'League.context' => 'cup'
                ]
            ]));
            $this->set('award', $award);
        }
    }

    public function delete($id = null) {
        $this->modelClass = 'LeaCupAward';
        $award = $this->LeaCupAward->read(null, $id);

        //Deletando a premiação
        $this->LeagueAward->id = $award['LeaCupAward']['league_award_id'];
        $this->LeagueAward->delete($award['LeaCupAward']['league_award_id']);

        //Deletando premiação do tipo copa
        $this->LeaCupAward->id = $award['LeaCupAward']['id'];
        $this->_delete($id, false);
    }

}
