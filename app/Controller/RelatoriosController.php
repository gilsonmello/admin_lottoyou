<?php

class RelatoriosController extends AppController {

    public $components = array('App');

    public function itens($modal = 0) {

    }

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->RasTabelasDesconto->recursive = 0;
        $this->RasTabelasDesconto->validate = array();

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'RasTabelasDesconto.tema_id') {
                $options['conditions'][$field] = $value;
                //unset($options['conditions'][$field]);
            }
            if ($field == 'RasTabelasDesconto.quantity') {
                $options['conditions'][$field. ' LIKE'] = "%$value%";
            }
            if ($field == 'RasTabelasDesconto.percentage') {
                $options['conditions'][$field. ' LIKE'] = "%$value%";
            }
        }


        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->RasTabelasDesconto->find('all', $options);

        $this->loadModel('TemasRaspadinha');
        $optionsTemas = $this->TemasRaspadinha->find('list');
        $this->set(compact('optionsTemas'));

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel('TemasRaspadinha');
        $optionsTemas = $this->TemasRaspadinha->find('list');
        $this->set(compact('optionsTemas'));
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->RasTabelasDesconto->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel('TemasRaspadinha');
        $optionsTemas = $this->TemasRaspadinha->find('list');
        $this->set(compact('optionsTemas'));

        $this->RasTabelasDesconto->id = $id;
        if (!$this->RasTabelasDesconto->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['RasTabelasDesconto']['id'] = $id;
            if ($this->RasTabelasDesconto->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->RasTabelasDesconto->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
