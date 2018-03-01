<?php

class RasLotesController extends AppController {

    public $components = array('App');

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->RasLote->recursive = 0;
        $this->RasLote->validate = array();

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'RasLote.nome') {
                $options['conditions'][$field . ' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->RasLote->find('all', $options);

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
            $this->request->data['RasLote']['qtd_geradas'] = $this->request->data['RasLote']['qtd_premiadas'];
            if ($this->RasLote->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function addRaspadinhas($id = NULL) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            $error = 0;

            if (isset($this->request->data['RasLote'])) {
                $lote = $this->RasLote->find('first', array('conditions' => array('RasLote.id' => $id)));
                if (($lote['RasLote']['valor_premio'] - $lote['RasLote']['total_premiadas']) >= $this->request->data['RasLote']['qtd_premiadas']) {

                    $this->request->data['RasLote']['valor_premiado'] = $this->App->formataValorDouble($this->request->data['RasLote']['valor_premiado']);
                    $this->request->data['RasLote']['qtd_geradas'] = $this->request->data['RasLote']['qtd_premiadas'];
//                    $this->request->data['RasLote']['tema_id'] = $this->request->data['RasLote']['tema_id'];

                    $msg = 'Registro salvo com sucesso.';
                    $error = 0;
                    if ($this->request->data['RasLote']['qtd_premiadas'] <= $this->request->data['RasLote']['qtd_geradas']) {
                        $this->loadModel('RasLote');
                        $this->RasLote->criarRaspadinha($this->request->data);
                    } else {
                        $msg = 'Não foi possível salvar o registro.<br/>Número de Raspadinhas Premiadas é maior que a quantidade Gerada.';
                        $error = 1;
                    }
                    echo json_encode(compact('error', 'msg'));
                    exit;
                } else {
                    $msg = 'Não foi possível salvar o registro.<br/>Número de Raspadinhas Premiadas é maior que a quantidade Gerada.';
                    $error = 1;
                    echo json_encode(compact('error', 'msg'));
                    exit;
                }
            } else {
                $this->loadModel('RasLote');
                $this->request->data['RasLote']['lote_id'] = $this->request->data['lote_id'];
                $this->request->data['RasLote']['qtd_premiadas'] = 0;
                $this->request->data['RasLote']['qtd_geradas'] = $this->request->data['raspadinhas_restantes'];
                $this->request->data['RasLote']['user_id'] = $this->request->data['user_id'];
                $this->request->data['RasLote']['valor_premiado'] = 0;
                $this->request->data['RasLote']['tema_id'] = $this->request->data['tema_id'];
//                die('ak');
                $msg = 'Registro salvo com sucesso.';
                $error = 0;
                $this->RasLote->criarRaspadinha($this->request->data);
//                if () {
//                    $msg = 'Erro não foi possivel salvar os registros.';
//                    $error = 1;
//                }
                echo json_encode(compact('error', 'msg'));
                exit;
            }
        } else {
//            $this->loadModel('Raspadinha');
//            $temasVinculados = $this->Raspadinha->find('all', array('group' => array('Raspadinha.tema_id')));
//            fb::info($temasVinculados, "\$temasVinculados");
            $dados = $this->RasLote->relRaspadinhas($id);
            $dadosSemPremio = $this->RasLote->relRaspadinhasSemPremio($id);
            $lote = $this->RasLote->find('first', array('conditions' => array('RasLote.id' => $id)));
//            fb::info($lote, "\$lote");
            $this->set(compact('id', 'dados', 'lote', 'dadosSemPremio'));
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel('TemasRaspadinha');
        $optionsTemas = $this->TemasRaspadinha->find('list');
        $this->set(compact('optionsTemas'));

        $this->RasLote->id = $id;
        if (!$this->RasLote->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['RasLote']['id'] = $id;
            if ($this->RasLote->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->RasLote->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
