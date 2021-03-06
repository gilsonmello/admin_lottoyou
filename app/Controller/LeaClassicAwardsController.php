<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Class RetiradasController
 *
 */
class LeaClassicAwardsController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    var $uses = [
        'LeaClassicAward',
        'League',
        'LeagueAward'
    ];

    private function addValidateFields()
    {

    }

    public function index($modal = 0) {

        $this->LeagueAward->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = array(
            'conditions' => [
                'LeagueAward.context' => 'classic'
            ],
            'limit' => 50,
            'order' => array('LeagueAward.position' => 'asc'),
            'contain' => [],
            'joins' => [
                [
                    'alias' => 'LeaClassicAward',
                    'table' => 'lea_classic_awards',
                    'type' => 'INNER',
                    'conditions' => 'LeaClassicAward.league_award_id = LeagueAward.id'
                ]
            ],
            'fields' => array('LeagueAward.*', 'LeaClassicAward.*'),
        );

        if(isset($query['league_id']) && $query['league_id'] != '') {
            $options['conditions']['LeagueAward.league_id'] = $query['league_id'];
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
                'League.context' => 'classic'
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
            $this->request->data['LeagueAward']['context'] = 'classic';
            if ($this->LeagueAward->save($this->request->data)) {
                $this->LeaClassicAward->create();
                $classic['LeaClassicAward']['league_award_id'] = $this->LeagueAward->id;
                $this->LeaClassicAward->save($classic);
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
        $this->set('optionsLeague', $this->League->find('list', [
            'conditions' => [
                'League.context' => 'classic'
            ]
        ]));
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LeaClassicAward->id = $id;
        if (!$this->LeaClassicAward->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $award = $this->LeaClassicAward->read(null, $id);

            $leaAwardId = $award['LeaClassicAward']['league_award_id'];

            $this->request->data['LeagueAward']['id'] = $leaAwardId;
            //$this->request->data['LeagueAward']['value'] = $this->App->formataValorDouble($this->request->data['LeagueAward']['value']);
            if ($this->LeagueAward->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $award = $this->LeaClassicAward->read(null, $id);
            $leaAwardId = $award['LeaClassicAward']['league_award_id'];
            $this->request->data = $this->LeagueAward->read(null, $leaAwardId);
            $this->set('optionsLeague', $this->League->find('list', [
                'conditions' => [
                    'League.context' => 'classic'
                ]
            ]));
            $this->set('award', $award);
        }

    }

    public function delete($id = null) {
        $this->modelClass = 'LeaClassicAward';
        $award = $this->LeaClassicAward->read(null, $id);
        $this->LeagueAward->id = $award['LeaClassicAward']['league_award_id'];
        $this->LeagueAward->delete($award['LeaClassicAward']['league_award_id']);
        $this->LeaClassicAward->id = $award['LeaClassicAward']['id'];
        $this->_delete($id, false);
    }

}
