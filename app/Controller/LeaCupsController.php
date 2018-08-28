<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Class RetiradasController
 *
 */
class LeaCupsController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    var $uses = [
        'League',
        'LeaCup'
    ];

    public function index($modal = 0) {

        $this->League->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
                'League.context' => 'cup'
            ],
            'limit' => 50,
            'order' => array('League.id' => 'desc'),
            'contain' => [],
            'joins' => [
                [
                    'alias' => 'LeaCup',
                    'table' => 'lea_cups',
                    'type' => 'LEFT',
                    'conditions' => 'LeaCup.league_id = League.id'
                ]
            ],
            'fields' => array('League.*', 'LeaCup.*'),
        );

        if(isset($query['name'])) {
            $options['conditions']['League.name LIKE'] = '%'.$query['name'].'%';
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

        $dados = $this->paginate('League');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));

        $this->set('query', http_build_query($query));
        $this->set('model', $this->League);

        //die(var_dump($this->request->method()));
        if ($this->request->is('ajax') && $this->request->method() == 'GET') {
            $this->layout = false;
            $this->render('index_table');
        }

    }

    private function addValidateFields() {
        $this->League->validate['number_team'] = [
            'required' => [
                'rule' => array('checkVazio', 'number_team'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ]
        ];
    }

    public function add() {
        $this->League->recursive = -1;
        $this->LeaCup->recursive = -1;
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['League']['value'] = $this->App->formataValorDouble($this->request->data['League']['value']);
            $league = $this->request->data;
            $league['League']['context'] = 'cup';
            unset($league['League']['bg_image']);
            //Adicionando campos extras para validação
            $this->addValidateFields();
            if ($this->League->save($league)) {
                $this->LeaCup->create();
                $leaCup['LeaCup']['league_id'] = $this->League->id;
                $leaCup['LeaCup']['one_x_one'] = $league['League']['one_x_one'];
                $leaCup['LeaCup']['number_team'] = $league['League']['number_team'];
                $this->LeaCup->save($leaCup);
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        /*$this->League->id = $id;
        $this->League->recursive = -1;*/

        $this->LeaCup->id = $id;
        $this->LeaCup->recursive = -1;

        //Verifica se a liga mata mata existe
        if (!$this->LeaCup->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $leaCup = $this->LeaCup->read(null, $id);
            //Pegando os dados da liga
            $league_id = $leaCup['LeaCup']['league_id'];
            $this->request->data['League']['id'] = $league_id;
            $this->request->data['League']['value'] = $this->App->formataValorDouble($this->request->data['League']['value']);
            $league = $this->request->data;
            unset($league['League']['bg_image']);
            //Adicionando campos extras para validação
            $this->addValidateFields();
            if ($this->League->save($league)) {
                $leaCup['LeaCup']['one_x_one'] = $league['League']['one_x_one'];
                $leaCup['LeaCup']['number_team'] = $league['League']['number_team'];
                $this->LeaCup->save($leaCup);
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {

            //Pegando dados da liga mata mata
            $leaCup = $this->LeaCup->read(null, $id);
            $this->set('leaCup', $leaCup);

            //Pegando os dados da liga
            $league_id = $leaCup['LeaCup']['league_id'];
            $this->request->data = $this->League->read(null, $league_id);
        }


    }

    public function delete($id = null) {
        $this->modelClass = 'LeaCup';
        $leaCup = $this->LeaCup->read(null, $id);
        $this->League->id = $leaCup['LeaCup']['league_id'];
        $this->League->delete($leaCup['LeaCup']['league_id']);
        $this->LeaCup->id = $leaCup['LeaCup']['id'];
        $this->_delete($id, false);
    }

}
