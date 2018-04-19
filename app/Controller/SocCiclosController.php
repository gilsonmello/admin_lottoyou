<?php

class SocCiclosController extends AppController {

    public $components = array('App');

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->SocCiclo->recursive = 0;
        $this->SocCiclo->validate = array();

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'SocCiclo.soc_categoria_id') {
                //$options['conditions'][$field] = $value;
                //unset($options['conditions'][$field]);
            }
        }

        
        $optionsCategorias = $this->SocCiclo->SocCategoria->find('list');
        $this->set('optionsCategorias', $optionsCategorias);

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->SocCiclo->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        
        $optionsCategorias = $this->SocCiclo->SocCategoria->find('list');
        $this->set('optionsCategorias', $optionsCategorias);
        
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->SocCiclo->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $optionsCategorias = $this->SocCiclo->SocCategoria->find('list');
        $this->set('optionsCategorias', $optionsCategorias);

        $this->SocCiclo->id = $id;
        if (!$this->SocCiclo->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SocCiclo']['id'] = $id;
            if ($this->SocCiclo->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->SocCiclo->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
