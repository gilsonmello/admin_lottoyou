<?php

class LotJogosResultadosController extends AppController {

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->LotJogosResultado->recursive = 0;
        $this->LotJogosResultado->validate = array();

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'LotJogosResultado.sorteio') {
                $options['conditions'][$field . ' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->LotJogosResultado->find('all', $options);
        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
    }

    public function add($lotJogoId = null) {
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            if (!empty($this->request->data['LotJogosResultado']['concurso_data']) && !empty($this->request->data['LotJogosResultado']['lot_jogo_id'])) {
                $data['LotJogosResultado'] = $this->request->data['LotJogosResultado'];
                $data['LotJogosResultado']['user_id'] = $this->Session->read('Auth.User.id');
                $data['LotJogosResultado']['numeros_sorteados'] = '';
                $data['LotJogosResultado']['contador'] = 0;
                foreach ($this->request->data['D'] as $v) {
                    if (!is_array($v) && !empty($v) && empty($data['LotJogosResultado']['numeros_sorteados'])) {
                        $data['LotJogosResultado']['numeros_sorteados'] = $v;
                        $data['LotJogosResultado']['contador'] ++;
                    } elseif (!is_array($v) && !empty($v)) {
                        $data['LotJogosResultado']['numeros_sorteados'] .= ' - ' . $v;
                        $data['LotJogosResultado']['contador'] ++;
                    }
                }
                $data['LotJogosResultado']['numeros_sorteados_extra'] = '';
                foreach ($this->request->data['d'] as $v) {
                    if (!is_array($v) && !empty($v) && empty($data['LotJogosResultado']['numeros_sorteados_extra'])) {
                        $data['LotJogosResultado']['numeros_sorteados'] = $v;
                        $data['LotJogosResultado']['contador_extra'] ++;
                    } elseif (!is_array($v) && !empty($v)) {
                        $data['LotJogosResultado']['numeros_sorteados'] .= ' + ' . $v;
                        $data['LotJogosResultado']['contador_extra'] ++;
                    }
                }

                $this->loadModel('LotJogo');
                $this->LotJogo->recursive = 2;
                $lotJogo = $this->LotJogo->find('first', array('conditions' => array('LotJogo.id' => $data['LotJogosResultado']['lot_jogo_id'])));

                //$data['LotJogosResultado']['lot_jogo_id']


                if ($lotJogo['LotCategoria']['dezena_sel'] != $data['LotJogosResultado']['contador']) {
                    $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                } else {
                    if ($this->LotJogosResultado->save($data)) {
                        $lotJogo['LotJogo']['lot_jogos_resultado_id'] = $this->LotJogosResultado->getLastInsertId();
                        $this->LotJogo->save($lotJogo['LotJogo']);
                        $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                    } else {
                        $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                    }
                }
            } else {
                $this->Session->setFlash('Por favor, informe o Campo:<br/> <u>Data do resultado</u>.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $this->loadModel('LotJogo');
            $dados = $this->LotJogo->find('first', array('conditions' => array('LotJogo.id' => $lotJogoId)));

            $exits = $this->LotJogosResultado->find('first', array('conditions' => array('LotJogosResultado.lot_jogo_id' => $lotJogoId)));
            if (count($exits) > 0) {
//                


                $this->request->data['LotJogosResultado'] = $exits['LotJogosResultado'];
                $numb = explode(' + ', $exits['LotJogosResultado']['numeros_sorteados']);
                $numeros = explode(' - ', $numb[0]);
                unset($numb[0]);
                $dezenas = array();
                for ($index = 0; $index < $dados['LotCategoria']['dezena']; $index++) {
                    foreach ($numeros as $k => $v) {
                        if ($index == $v) {
                            $dezenas[$index] = 1;
                        }
                    }
                }
                for ($index = 0; $index < $dados['LotCategoria']['dezena_extra']; $index++) {
                    foreach ($numb as $k => $v) {
                        if ($index == $v) {
                            $dezenas2[$index] = 1;
                        }
                    }
                }
                $this->set(compact('tiposJogos', 'dados', 'lotJogoId', 'dezenas2', 'dezenas'));

                $this->Session->setFlash('Resultado, já informado previamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            } else {
                $this->set(compact('tiposJogos', 'dados', 'lotJogoId'));
            }
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LotJogosResultado->id = $id;
        if (!$this->LotJogosResultado->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['LotJogosResultado']['id'] = $id;
            if ($this->LotJogosResultado->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $this->loadModel('LotCategoria');
            $gelCategorias = $this->LotCategoria->find('list', array('fields' => array('id', 'nome')));
            $this->set(compact('gelCategorias'));
        }

        $this->request->data = $this->LotJogosResultado->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

    public function tabela($tipo) {
        $this->loadModel('LotJogo');
        $dados = $this->LotJogo->find('first', array('conditions' => array('LotJogo.id' => $tipo)));

        fb($dados, '$dados');
        $this->set(compact('dados'));
    }

}
