<?php

class LotUserJogosController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        #Permitindo que os usuários se registrem
        $this->Auth->allow('tabela', 'tabelaView');
    }

    public function index($modal = 0) {
        $this->loadModel('LotJogo');
        $this->LotJogo->recursive = 0;
        $dados = $this->LotJogo->find('all', array('conditions' => array('LotJogo.active' => '1', 'LotJogo.data_fim >=' => date('Y-m-d'))));

        $this->LotUserJogo->recursive = 2;
        $userJogos = $this->LotUserJogo->find('all', array('conditions' => array('LotUserJogo.jogador_id' => $this->Session->read('Auth.User.id'))));

        $this->set(compact('dados', 'modal', 'userJogos'));
    }

    public function add($lotJogoId = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';
        if ($this->request->is('post') || $this->request->is('put')) {
            //Organiza o que vai ser salvo 
            for ($index = 0; $index < 4; $index++) {
                $data[$index]['LotUserJogo'] = $this->request->data['LotUserJogo'];
                $data[$index]['LotUserJogo']['status'] = 1;
                $data[$index]['LotUserJogo']['jogador_id'] = $this->Session->read('Auth.User.id');
                $data[$index]['LotUserJogo']['numeros'] = '';
                switch ($index) {
                    case 0:
                        $data[$index]['LotUserJogo']['contador'] = 0;
                        foreach ($this->request->data['D'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' - ' . $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            }
                        }
                        break;
                    case 1:
                        $data[$index]['LotUserJogo']['contador'] = 0;
                        foreach ($this->request->data['E'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' - ' . $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            }
                        }
                        break;
                    case 2:
                        $data[$index]['LotUserJogo']['contador'] = 0;
                        foreach ($this->request->data['F'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' - ' . $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            }
                        }
                        break;
                    case 3:
                        $data[$index]['LotUserJogo']['contador'] = 0;
                        foreach ($this->request->data['G'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' - ' . $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            }
                        }
                        break;
                }
            }

            $this->loadModel('LotJogo');
            $this->LotJogo->recursive = 2;
            $lotJogo = $this->LotJogo->find('first', array('conditions' => array('LotJogo.id' => $data[0]['LotUserJogo']['lot_jogo_id'])));
            if ($lotJogo['LotCategoria']['dezena_sel'] != $data[0]['LotUserJogo']['contador']) {
                unset($data[0]);
            }
            if ($lotJogo['LotCategoria']['dezena_sel'] != $data[1]['LotUserJogo']['contador']) {
                unset($data[1]);
            }
            if ($lotJogo['LotCategoria']['dezena_sel'] != $data[2]['LotUserJogo']['contador']) {
                unset($data[2]);
            }
            if ($lotJogo['LotCategoria']['dezena_sel'] != $data[3]['LotUserJogo']['contador']) {
                unset($data[3]);
            }

            $ok = 0;
            foreach ($data as $k => $v) {
                if (!empty($v['LotUserJogo']['numeros'])) {
                    $ok = 1;
                }
            }


            if ($this->LotUserJogo->saveAll($data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. LT125', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
//            } else {
//                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
//            }
        } else {
            $this->loadModel('LotJogo');
            $tiposJogos = $this->LotJogo->find('list', array(
                'fields' => array('id', 'sorteio'),
                'order' => 'sorteio',
                'conditions' => array('LotJogo.data_fim >=' => date('Y-m-d'))
            ));
            $this->set(compact('tiposJogos', 'lotJogoId'));
        }
    }

    public function edit($id = null) {

        $this->LotUserJogo->id = $id;
        if (!$this->LotUserJogo->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        } else {
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->request->data['LotUserJogo']['id'] = $id;
                if ($this->LotUserJogo->save($this->request->data)) {
                    $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                } else {
                    $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                }
            } else {
                $this->loadModel('LotJogo');
                $tiposJogos = $this->LotJogo->find('list', array(
                    'fields' => array('id', 'sorteio'),
                    'order' => 'sorteio',
                    'conditions' => array('LotJogo.data_fim >=' => date('Y-m-d'))
                ));

                $this->set(compact('tiposJogos'));


                $this->request->data = $this->LotUserJogo->read(null, $id);
            }
        }
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

    public function tabela($tipo, $site = 0) {
        if ($this->request->is('post') || $this->request->is('put')) {
            fb($this->request->data, 'data');
            for ($index = 0; $index < 6; $index++) {
                $data[$index]['LotUserJogo'] = $this->request->data['LotUserJogo'];
                $data[$index]['LotUserJogo']['status'] = 1;
                $data[$index]['LotUserJogo']['jogador_id'] = $this->Session->read('Auth.User.id');
                $data[$index]['LotUserJogo']['numeros'] = '';
                switch ($index) {
                    case 0:
                        $data[$index]['LotUserJogo']['contador'] = 0;
                        foreach ($this->request->data['D'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' - ' . $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            }
                        }
                        $data[$index]['LotUserJogo']['contador_extra'] = 0;
                        foreach ($this->request->data['d'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' + ' . $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            }
                        }
                        break;
                    case 1:
                        $data[$index]['LotUserJogo']['contador'] = 0;
                        foreach ($this->request->data['E'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' - ' . $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            }
                        }
                        $data[$index]['LotUserJogo']['contador_extra'] = 0;
                        foreach ($this->request->data['e'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' + ' . $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            }
                        }
                        break;
                    case 2:
                        $data[$index]['LotUserJogo']['contador'] = 0;
                        foreach ($this->request->data['F'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' - ' . $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            }
                        }
                        $data[$index]['LotUserJogo']['contador_extra'] = 0;
                        foreach ($this->request->data['f'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' + ' . $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            }
                        }
                        break;
                    case 3:
                        $data[$index]['LotUserJogo']['contador'] = 0;
                        foreach ($this->request->data['G'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' - ' . $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            }
                        }
                        $data[$index]['LotUserJogo']['contador_extra'] = 0;
                        foreach ($this->request->data['g'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' + ' . $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            }
                        }
                        break;
                    case 4:
                        $data[$index]['LotUserJogo']['contador'] = 0;
                        foreach ($this->request->data['H'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' - ' . $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            }
                        }
                        $data[$index]['LotUserJogo']['contador_extra'] = 0;
                        foreach ($this->request->data['h'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' + ' . $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            }
                        }
                        break;
                    case 5:
                        $data[$index]['LotUserJogo']['contador'] = 0;
                        foreach ($this->request->data['I'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' - ' . $v;
                                $data[$index]['LotUserJogo']['contador'] ++;
                            }
                        }
                        $data[$index]['LotUserJogo']['contador_extra'] = 0;
                        foreach ($this->request->data['i'] as $v) {
                            if (!is_array($v) && !empty($v) && empty($data[$index]['LotUserJogo']['numeros'])) {
                                $data[$index]['LotUserJogo']['numeros'] = $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            } elseif (!is_array($v) && !empty($v)) {
                                $data[$index]['LotUserJogo']['numeros'] .= ' + ' . $v;
                                $data[$index]['LotUserJogo']['contador_extra'] ++;
                            }
                        }
                        break;
                }
            }

            $this->loadModel('LotJogo');
            $this->LotJogo->recursive = 2;
            $lotJogo = $this->LotJogo->find('first', array('conditions' => array('LotJogo.id' => $data[0]['LotUserJogo']['lot_jogo_id'])));

            if ($lotJogo['LotCategoria']['dezena_sel'] != $data[0]['LotUserJogo']['contador']) {
                unset($data[0]);
            }
            if ($lotJogo['LotCategoria']['dezena_sel'] != $data[1]['LotUserJogo']['contador']) {
                unset($data[1]);
            }
            if ($lotJogo['LotCategoria']['dezena_sel'] != $data[2]['LotUserJogo']['contador']) {
                unset($data[2]);
            }
            if ($lotJogo['LotCategoria']['dezena_sel'] != $data[3]['LotUserJogo']['contador']) {
                unset($data[3]);
            }
            if ($lotJogo['LotCategoria']['dezena_sel'] != $data[4]['LotUserJogo']['contador']) {
                unset($data[4]);
            }
            if ($lotJogo['LotCategoria']['dezena_sel'] != $data[5]['LotUserJogo']['contador']) {
                unset($data[5]);
            }

            $ok = 0;
            foreach ($data as $k => $v) {
                if (!empty($v['LotUserJogo']['numeros'])) {
                    $ok = 1;
                }
            }
            $datar = str_replace('/', '-', $lotJogo['LotJogo']['data_fim'] . ' ' . $lotJogo['LotJogo']['hora_fim']);
            $data1 = new DateTime(date('d-m-Y H:m:s'));
            $data2 = new DateTime($datar);
            $intervalo = $data1->diff($data2);
            if ($intervalo->d == 0 && $intervalo->h == 0 && $intervalo->i <= 30 || $intervalo->invert == 1) {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Prazo encerrado.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            } else {
                if ($this->LotUserJogo->saveAll($data)) {
                    $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                } else {
                    $this->Session->setFlash('Não foi possível salvar o registro. LT125', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                }
            }
        } else {
            $this->loadModel('LotJogo');
            $dados = $this->LotJogo->find('first', array('conditions' => array('LotJogo.id' => $tipo, 'LotJogo.data_fim >=' => date('Y-m-d'))));
            fb($dados, 'tabela lotjogo');
            $this->set(compact('dados'));
            if ($site == 1)
                $this->render('tabela_site');
        }
    }

    public function detalhar($id = null) {
        $this->loadModel('LotUserJogo');
//        $dado = $this->LotUserJogo->query(
//                'SELECT 
//                LotUserJogo.*,
//                lot_jogos.*,
//                lot_jogos_resultados.*,
//                LotCategoria.*
//            FROM
//                lot_users_jogos AS LotUserJogo
//            LEFT JOIN
//                lot_jogos ON LotUserJogo.lot_jogo_id = lot_jogos.id
//            LEFT JOIN
//                lot_jogos_resultados ON lot_jogos.lot_jogos_resultado_id = lot_jogos_resultados.id
//            LEFT JOIN
//                lot_categorias as LotCategoria ON lot_jogos.lot_categoria_id = LotCategoria.id
//            WHERE
//                LotUserJogo.id = ' . $id
//        );
//        $dados = $dado[0];
        $dados = $this->LotUserJogo->find('first', array('conditions'=>array('LotUserJogo.id' => $id)));
        
        $this->set(compact('dados'));
    }

}
