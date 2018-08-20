<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Class RetiradasController
 *
 */
class LeaPackagesController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    public $uses = [
        'LeaPackage',
        'League'
    ];

    public function index($modal = 0) {

        $this->LeaPackage->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
            ],
            'limit' => 50,
            'order' => array('LeaPackage.id' => 'desc'),
            'contain' => [],
            'joins' => [
            ],
            //'fields' => array('Retirada.*', 'Agent.*, Country.*'),
        );

        if(isset($query['name'])) {
            $options['conditions']['LeaPackage.name LIKE'] = '%'.$query['name'].'%';
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

        $dados = $this->paginate('LeaPackage');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));

        $this->set('query', http_build_query($query));
        $this->set('model', $this->LeaPackage);

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
            $this->request->data['LeaPackage']['value'] = $this->App->formataValorDouble($this->request->data['LeaPackage']['value']);
            $league = $this->request->data;
            unset($league['LeaPackage']['bg_image']);
            if ($this->LeaPackage->save($league)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
            //$this->render(false);
        } else {
            $this->League->recursive = -1;
            $this->set('leagues', $this->League->find('list', [
                'order' => ['name asc']
            ]));
        }

    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LeaPackage->id = $id;
        if (!$this->LeaPackage->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['LeaPackage']['id'] = $id;
            $this->request->data['LeaPackage']['value'] = $this->App->formataValorDouble($this->request->data['LeaPackage']['value']);
            $league = $this->request->data;
            unset($league['LeaPackage']['bg_image']);
            if ($this->LeaPackage->save($league)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->League->recursive = -1;
        $this->LeaPackage->recursive = -1;
        $leagues = $this->League->find('list', [
            'order' => ['name asc']
        ]);
        $this->set('leagues', $leagues);
        $selected = $this->LeaPackage->LeaPackagesHasLeague->find('list', [
            'conditions' => [
                'lea_package_id' => $id
            ],
            'fields' => [
                'league_id'
            ]
        ]);
        $this->set('selected', $selected);
        $this->request->data = $this->LeaPackage->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
