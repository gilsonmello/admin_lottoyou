<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Class RetiradasController
 *
 */
class LeaClassicsController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    var $uses = [
        'League',
        'LeaClassic'
    ];

    public function index($modal = 0) {
        $this->League->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
                'League.context' => 'classic'
            ],
            'limit' => 50,
            'order' => array('League.id' => 'desc'),
            'contain' => [],
            'joins' => [
                [
                    'alias' => 'LeaClassic',
                    'table' => 'lea_classics',
                    'type' => 'INNER',
                    'conditions' => 'LeaClassic.league_id = League.id'
                ]
            ],
            'fields' => array('League.*', 'LeaClassic.*'),
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

    public function add() {
        $this->League->recursive = -1;
        $this->LeaClassic->recursive = -1;
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['League']['value'] = $this->App->formataValorDouble($this->request->data['League']['value']);
            $league = $this->request->data;
            $league['League']['context'] = 'classic';
            unset($league['League']['bg_image']);

            $this->addValidateFields();
            if ($this->League->save($league)) {
                $this->LeaClassic->create();
                $leaClassic['LeaClassic']['league_id'] = $this->League->id;
                $leaClassic['LeaClassic']['type_award_id'] = $league['League']['type_award_id'];
                $leaClassic['LeaClassic']['min_players'] = $league['League']['min_players'];
                $leaClassic['LeaClassic']['max_players'] = $league['League']['max_players'];
                $this->LeaClassic->save($leaClassic);

                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    private function addValidateFields() {
        $this->League->validate['type_award_id'] = [
            'required' => [
                'rule' => array('checkVazio', 'type_award_id'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ]
        ];
        $this->League->validate['min_players'] = [
            'required' => [
                'rule' => array('checkVazio', 'min_players'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ]
        ];
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LeaClassic->id = $id;
        $this->LeaClassic->recursive = -1;

        //Verifica se a liga clássica existe
        if (!$this->LeaClassic->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $leaClassic = $this->LeaClassic->read(null, $id);
            //Pegando os dados da liga
            $league_id = $leaClassic['LeaClassic']['league_id'];
            $this->request->data['League']['id'] = $league_id;
            $this->request->data['League']['value'] = $this->App->formataValorDouble($this->request->data['League']['value']);
            $league = $this->request->data;
            unset($league['League']['bg_image']);
            //Adicionando campos extras para validação
            $this->addValidateFields();
            if ($this->League->save($league)) {
                $leaClassic['LeaClassic']['type_award_id'] = $league['League']['type_award_id'];
                $leaClassic['LeaClassic']['min_players'] = $league['League']['min_players'];
                $leaClassic['LeaClassic']['max_players'] = $league['League']['max_players'];
                $this->LeaClassic->save($leaClassic);
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $leaClassic = $this->LeaClassic->read(null, $id);
            $this->set('leaClassic', $leaClassic);

            $league_id = $leaClassic['LeaClassic']['league_id'];
            $this->request->data = $this->League->read(null, $league_id);
        }

    }

    /**
     * @param null $id
     */
    public function delete($id = null) {
        $this->modelClass = 'LeaClassic';
        $leaClassic = $this->LeaClassic->read(null, $id);
        $this->League->id = $leaClassic['LeaClassic']['league_id'];
        $this->League->delete($leaClassic['LeaClassic']['league_id']);
        $this->LeaClassic->id = $leaClassic['LeaClassic']['id'];
        $this->_delete($id, false);
    }

}
