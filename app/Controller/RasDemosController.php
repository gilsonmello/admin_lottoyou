<?php

class RasDemosController extends AppController {

    public $components = array('App');
    
    public function beforeRender()
    {
        parent::beforeRender();
        $this->RasDemo->recursive = -1;
    }

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->RasDemo->recursive = 0;
        $this->RasDemo->validate = [];

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'RasDemo.active') {
                
            }
        }

        //die(var_dump($options));

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->RasDemo->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
        $this->set('optionsTemas', $this->RasDemo->TemasRaspadinha->find('list'));
    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['RasTabelasPremio']['quantia'] = $this->App->formataValorDouble($this->request->data['RasTabelasPremio']['quantia']);
            if ($this->RasTabelasPremio->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } 
    
        $this->set('optionsTemas', $this->RasTabelasPremio->TemasRaspadinha->find('list'));
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->RasTabelasPremio->id = $id;
        if (!$this->RasTabelasPremio->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['RasTabelasPremio']['id'] = $id;
            $this->request->data['RasTabelasPremio']['quantia'] = $this->App->formataValorDouble($this->request->data['RasTabelasPremio']['quantia']);
            if ($this->RasTabelasPremio->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->RasTabelasPremio->read(null, $id);
        $this->set('optionsTemas', $this->RasTabelasPremio->TemasRaspadinha->find('list'));
    }

    public function delete($id = null) {
        parent::_delete($id);
    }
   
}