<?php

class SocConfRodadasController extends AppController {

    public function beforeRender()
    {
        parent::beforeRender();
        $this->SocConfRodada->recursive = -1;
    }

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->SocConfRodada->recursive = 0;
        $this->SocConfRodada->validate = [];

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'SocConfRodada.nome') {
                $options['conditions'][$field . ' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->SocConfRodada->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
    }

    public function add($socRodadaId) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->SocConfRodada->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {

            $this->set('socRodadaId', $socRodadaId);

            $this->request->data = $this->SocConfRodada->find('first', [
                'conditions' => [
                    'SocConfRodada.soc_rodada_id' => $socRodadaId
                ]
            ]);

            $this->set('id', count($this->request->data) > 0 ? $this->request->data['SocConfRodada']['id'] : null);
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->SocConfRodada->id = $id;
        if (!$this->SocConfRodada->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SocConfRodada']['id'] = $id;
            if ($this->SocConfRodada->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->SocConfRodada->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }
   
}