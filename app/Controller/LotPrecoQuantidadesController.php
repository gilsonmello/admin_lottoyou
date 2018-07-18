<?php

/**
 * Class LotPrecoQuantidadesController
 */
class LotPrecoQuantidadesController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    public function index($modal = 0) {

        $this->LotPrecoQuantidade->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
            ],
            'limit' => 50,
            'order' => array('LotPrecoQuantidade.id' => 'desc'),
            'contain' => [],
            'joins' => [
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'User.id = LotPrecoQuantidade.user_id'
                ),
                array(
                    'alias' => 'LotCategoria',
                    'table' => 'lot_categorias',
                    'type' => 'INNER',
                    'conditions' => 'LotCategoria.id = LotPrecoQuantidade.lot_categoria_id'
                ),
            ],
            'fields' => array('LotPrecoQuantidade.*, User.*, LotCategoria.*'),
        );

        if(isset($query['lot_categoria_id']) && $query['lot_categoria_id'] != '') {
            $options['conditions']['LotCategoria.id ='] = $query['lot_categoria_id'];
        }

        $this->paginate = $options;

        $dados = $this->paginate('LotPrecoQuantidade');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));

        $this->set('query', http_build_query($query));

        $this->loadModel('LotCategoria');
        $this->LotCategoria->recursive = -1;
        $categorias = $this->LotCategoria->find('list', [
            'conditions' => [

            ]
        ]);
        $this->set('categorias', $categorias);

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
            $valor = $this->request->data['LotPrecoQuantidade']['valor'];
            $this->request->data['LotPrecoQuantidade']['valor'] = $this->App->formataValorDouble($valor);
            if ($this->LotPrecoQuantidade->save($this->request->data)) {
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

        $this->LotPrecoQuantidade->id = $id;
        if (!$this->LotPrecoQuantidade->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $valor = $this->request->data['LotPrecoQuantidade']['valor'];
            $this->request->data['LotPrecoQuantidade']['id'] = $id;
            $this->request->data['LotPrecoQuantidade']['valor'] = $this->App->formataValorDouble($valor);
            if ($this->LotPrecoQuantidade->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->LotPrecoQuantidade->read(null, $id);
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
