<?php

class SocBoloesController extends AppController {

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->SocBolao->recursive = 0;
        $this->SocBolao->validate = array();

        // TRATA CONDIÇÕES
        foreach($options['conditions'] as $field => $value){
            if ($field == 'SocBolao.nome'){
                $options['conditions'][$field.' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }
        
        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->SocBolao->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados','modal'));
    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->SocBolao->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->set('optionsSocCategorias', $this->SocBolao->SocCategoria->find('list'));
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->SocBolao->id = $id;
        if (!$this->SocBolao->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SocBolao']['id'] = $id;
            if ($this->SocBolao->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->SocBolao->read(null, $id);
        $this->set('optionsSocCategorias', $this->SocBolao->SocCategoria->find('list'));
    }

    public function delete($id = null) {
        parent::_delete($id);
    }
}