<?php

class SocJogosController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();

        #Permitindo que os usuários se registrem
        $this->Auth->allow('lista');
    }

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
//        $options = parent::_index();               
        // PREPARA MODEL       

        $this->loadModel('SocCategoria');
        $this->SocCategoria->recursive = -1;
        $dadosCategorias = $this->SocCategoria->find('all', array('conditions' => array("SocCategoria.active" => '1')));

        $this->loadModel('SocRodada');
        $this->SocRodada->recursive = 1;
        $this->SocRodada->validate = array();

        

        // PEGA REQUISIÇÕES CADASTRADOS
        if (!empty($this->request->data['id'])) {
            $conditions = array("SocRodada.active" => '1', 'SocRodada.soc_categoria_id' => $this->request->data['id']);
        } else {
            $conditions = array("SocRodada.active" => '1');
        }
        $dados = $this->SocRodada->find('all', array('conditions' => $conditions));
        
//        fb::info($dados, "\$dados");
        
        $this->loadModel('SocAposta');
        $this->SocAposta->recursive = -1;
        $minhasRodadas = $this->SocAposta->find('list', array(
            'fields' => array('SocAposta.soc_rodada_id'),
            'conditions' => array('SocAposta.user_id' => $this->Session->read('Auth.User.id')),
            'group' => array('SocAposta.soc_rodada_id')
        ));

        $meusDados = $this->SocRodada->find('all', array(
            'conditions' => array('SocRodada.id' => $minhasRodadas)
        ));
        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal', 'meusDados', 'dadosCategorias'));
    }

    public function add($idRodada) {

        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
//            fb::info($this->request->data, "\$this->request->data");
            $msg = 'Registro salvo com sucesso.';
            $class = 'alert-success';
            $ok = true;

            $bolaoId = $this->request->data['SocJogo']['soc_bolao_id'];
            $rodadaId = $this->request->data['SocJogo']['soc_rodada_id'];
            
            unset($this->request->data['SocJogo']['soc_bolao_id']);
            unset($this->request->data['SocJogo']['local']);
            unset($this->request->data['SocJogo']['data']);
            unset($this->request->data['SocJogo']['hora']);
            unset($this->request->data['SocJogo']['soc_rodada_id']);
            unset($this->request->data['SocJogo']['soc_semana_id']);
            unset($this->request->data['SocJogo']['rodada_id']);
            unset($this->request->data['SocJogo']['data']);
            unset($this->request->data['SocJogo']['hora']);
            unset($this->request->data['SocJogo']['gel_clube_casa_id']);
            unset($this->request->data['SocJogo']['gel_clube_fora_id']);

            $this->StartTransaction();
            foreach ($this->request->data['SocJogo'] as $v) {
                
                $validate = true;

                if(empty($v['local']) || !isset($v['local'])) {
                    $validate = false;
                }

                if(empty($v['data']) || !isset($v['data'])) {
                    $validate = false;
                }

                if(empty($v['gel_clube_casa_id']) || !isset($v['gel_clube_casa_id'])) {
                    $validate = false;
                }

                if(empty($v['gel_clube_fora_id']) || !isset($v['gel_clube_fora_id'])) {
                    $validate = false;
                }

                if(empty($v['hora']) || !isset($v['hora'])) {
                    $validate = false;
                }
                
                if($validate) {
                    $value['soc_bolao_id'] = $bolaoId;
                    $value['soc_rodada_id'] = $rodadaId;
                    $value['local'] = $v['local'];
                    $value['data'] = $v['data'];
                    $value['hora'] = $v['hora'];
                    $value['gel_clube_casa_id'] = $v['gel_clube_casa_id'];
                    $value['gel_clube_fora_id'] = $v['gel_clube_fora_id'];


                    $this->SocJogo->create();
                    if (!$this->SocJogo->save($value)) {
                        $msg = 'Não foi possível editar o registro. Favor tentar novamente.';
                        $class = 'alert-danger';
                        $ok = false;
                    }
                }
            }
            $this->validaTransacao($ok);
            $this->Session->setFlash($msg, 'alert', array('plugin' => 'BoostCake', 'class' => $class));
        } else {


            $this->loadModel('GelClube');
            $this->GelClube->recursive = -1;
            $optionsClubes = $this->GelClube->find('list');

            $this->loadModel('SocBolao');
            $this->SocBolao->recursive = -1;
            $optionsBoloes = $this->SocBolao->find('list');

            $this->loadModel('SocRodada');
            $this->SocRodada->recursive = -1;
            $dadosRodada = $this->SocRodada->find('first', [
                'conditions' => [
                    'SocRodada.id' => $idRodada
                ]
            ]);
            //die(var_dump($dadosRodada));
            $this->set(compact('optionsClubes', 'idRodada', 'dadosRodada', 'optionsBoloes'));
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel('SocBolao');
        $optionsBoloes = $this->SocBolao->find('list');
        $this->set(compact('optionsBoloes'));

        if ($this->request->is('post') || $this->request->is('put')) {

            $msg = 'Registro salvo com sucesso.';
            $class = 'alert-success';
            $ok = true;

            $bolaoId = $this->request->data['SocJogo']['soc_bolao_id'];
            $rodadaId = $this->request->data['SocJogo']['soc_rodada_id'];
            $dataTermino = $this->request->data['SocJogo']['data'];
            $horaTermino = $this->request->data['SocJogo']['hora'];

            unset($this->request->data['SocJogo']['soc_bolao_id']);
            unset($this->request->data['SocJogo']['data']);
            unset($this->request->data['SocJogo']['hora']);
            unset($this->request->data['SocJogo']['soc_rodada_id']);
            unset($this->request->data['SocJogo']['rodada_id']);
            unset($this->request->data['SocJogo']['data']);
            unset($this->request->data['SocJogo']['hora']);
            unset($this->request->data['SocJogo']['gel_clube_casa_id']);
            unset($this->request->data['SocJogo']['gel_clube_fora_id']);
            unset($this->request->data['SocJogo']['data']);
            unset($this->request->data['SocJogo']['hora']);

            $this->StartTransaction();
            foreach ($this->request->data['SocJogo'] as $k => $v) {

                $value['id'] = $k;
                $value['resultado_clube_casa'] = $v['resultado_clube_casa'];
                $value['resultado_clube_fora'] = $v['resultado_clube_fora'];

                $this->SocJogo->create(false);
                if (!$this->SocJogo->save($value)) {
                    $msg = 'Não foi possível editar o registro. Favor tentar novamente.';
                    $class = 'alert-danger';
                    $ok = false;
                }
            }
            $this->validaTransacao($ok);
//            die();
            $this->Session->setFlash($msg, 'alert', array('plugin' => 'BoostCake', 'class' => $class));
        } else {

            $this->loadModel('SocRodada');
            $this->SocRodada->recursive = 1;
            $dados = $this->SocRodada->find('all', array('conditions' => array('SocRodada.id' => $id)));

            fb::info($dados, "\$dados");
            $this->loadModel('GelClube');
            $optionsClubes = $this->GelClube->find('list');

            $this->loadModel('SocBolao');
            $optionsBoloes = $this->SocBolao->find('list');

            $this->loadModel('SocRodada');
            $optionsRodadas = $this->SocRodada->find('list', array('conditions' => array('SocRodada.id' => $id)));

            $this->set(compact('optionsClubes', 'optionsBoloes', 'optionsSemanas', 'dados', 'optionsRodadas'));
        }
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

    public function lista($id = null, $userId = 0) {

        if ($this->request->is('post') || $this->request->is('put')) {

            $msg = 'Registro salvo com sucesso.';
            $class = 'alert-success';
            $ok = true;

            $this->loadModel('SocAposta');
            $this->StartTransaction();

//            $socRodadaId = $this->request->data['SocAposta']['soc_rodada_id'];
            foreach ($this->request->data['SocAposta'] as $key => $value) {
                $arr['soc_jogo_id'] = $key;
                $arr['soc_rodada_id'] = $value['soc_rodada_id'];
                $arr['soc_clube_casa_id'] = $value['soc_clube_casa_id'];
                $arr['resultado_clube_casa'] = $value['resultado_clube_casa'];
                $arr['soc_clube_fora_id'] = $value['soc_clube_fora_id'];
                $arr['resultado_clube_fora'] = $value['resultado_clube_fora'];

                $this->SocAposta->create();
                if (!$this->SocAposta->save($arr)) {
                    $msg = 'Não foi possível editar o registro. Favor tentar novamente.';
                    $class = 'alert-danger';
                    $ok = false;
                }
            }
            $this->validaTransacao($ok);
            $this->Session->setFlash($msg, 'alert', array('plugin' => 'BoostCake', 'class' => $class));
        } else {
            // PEGA REQUISIÇÕES CADASTRADOS
            $dadosUser = array();

            $this->loadModel('SocRodada');
            $this->SocRodada->recursive = 1;
            $dados = $this->SocRodada->find('all', array('conditions' => array('SocRodada.id' => $id)));

            if (!empty($userId)) {
                $this->loadModel('SocAposta');
                $this->SocAposta->recursive = 0;
                $dadosUser = $this->SocAposta->find('all', array('conditions' => array('SocAposta.soc_rodada_id' => $id, 'SocAposta.user_id' => $userId)));

                $this->set(compact('dadosUser'));
                $this->render('lista_user');
            }
            // ENVIA DADOS PARA A SESSÃO
            $this->set(compact('dados'));
            $this->set('soc_rodada_id', $id);
        }
    }

}
