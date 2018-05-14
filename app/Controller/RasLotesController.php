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
            $value = $this->request->data['RasLote']['value'];
            $this->request->data['RasLote']['value'] = $this->App->formataValorDouble($value);
            if ($this->RasLote->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function removerNumeros($id = null) {
        $msg = "Salvo com Sucesso";
        $class = "alert alert-success";

        $this->loadModel('RasLotesNumero');

        $this->RasLotesNumero->recursive = -1;

        if ($this->request->is('post') || $this->request->is('put')) {
            $ras_lotes_numeros = $this->RasLotesNumero->read(null, $id);
        
            unlink(WWW_ROOT.$ras_lotes_numeros['RasLotesNumero']['img']);        
            
            $this->RasLotesNumero->delete($id, false);
        }

        $this->autoRender = false;
        $this->response->type('json');
        $json = json_encode(['msg' => 'Deletado com sucesso', 'status' => true]);
        $this->response->body($json);
        
    }

    public function addDemos($id = null) {
        $this->layout = 'ajax';

        $msg = "Salvo com Sucesso";
        $class = "alert alert-success";

        $this->loadModel('RasLotesNumero');
        $this->RasLotesNumero->recursive = -1;

        if ($this->request->is('post') || $this->request->is('put')) {
                    
            $valor_premiado = [];

            if(isset($this->request->data['RasDemo']['valor_premiado']) && !empty($this->request->data['RasDemo']['valor_premiado'])) {
                //Pegando o valor premiado
                $valor_premiado = $this->RasLotesNumero->read(null, $this->request->data['RasDemo']['valor_premiado']);
            }       

            if(count($valor_premiado) == 0)
                $this->request->data['RasDemo']['valor_premiado'] = 0.00;
            else 
                $this->request->data['RasDemo']['valor_premiado'] = $valor_premiado['RasLotesNumero']['number'];    
            

            if ($status = $this->RasLote->criarRaspadinhaDemo($this->request->data)) {

                if($status['status'] === false) {
                    $msg = $status['msg'];
                    $error = 1;
                    $class = 'alert alert-danger';
                }

            } else {
                $msg = 'Não foi possível salvar o registro.<br/>';
                $error = 1;
            }

            $this->Session->setFlash($msg, 'alert', array('plugin' => 'BoostCake', 'class' => $class));
        }

        $numeros_possiveis = $this->RasLotesNumero->find('list', [
            'conditions' => [
                'ras_lote_id' => $id
            ]
        ]);

        
        $this->RasLote->RasDemo->recursive = -1;
        $this->RasLote->recursive = -1;

        
        $this->set('lote', $this->RasLote->read(null, $id));
        $this->set('numeros_possiveis', $numeros_possiveis);
        $this->set('demos', $this->RasLote->RasDemo->find('all', [
            'fields' => ['RasDemo.premio', 'RasDemo.total_geradas'],
            'conditions' => [
                'RasDemo.lote_id' => $id
            ],
            'group' => [
                'RasDemo.premio'
            ],
            'order' => ['RasDemo.premio' => 'DESC']
        ]));
        //$this->request->data = $this->RasLote->read(null, $id);
    }

    public function addNumeros($id = null) {
        $this->layout = 'ajax';

        $msg = "Salvo com Sucesso";
        $class = "alert alert-success";

        $this->loadModel('RasLotesNumero');

        $this->RasLotesNumero->recursive = -1;

        if ($this->request->is('post') || $this->request->is('put')) {

            if(!is_dir(WWW_ROOT.'/files/Raspadinha_Lotes')) {
                mkdir(WWW_ROOT.'/files/Raspadinha_Lotes', 0775, true);
            }

            $this->RasLotesNumero->validate = array();
            $i = 0;

            
            foreach($this->request->data['RasLotesNumero'] as $key => $data) {
                $data['number'] = str_replace('$', '', $data['number']);
                $data['number'] = str_replace(' ', '', $data['number']);
                $data['number'] = str_replace('.', '', $data['number']);
                $data['number'] = str_replace(',', '.', $data['number']);
                $data['number'] = (double) $data['number'];

                $data['number'] = number_format($data['number'], 2, '.', '');
                if(empty($data['number']) && empty($data['img']['name'])) {
                    unset($this->request->data['RasLotesNumero'][$key]);
                }
            }

            //die(var_dump($this->request->data['RasLotesNumero']));
            foreach($this->request->data['RasLotesNumero'] as $key => $data) {
                $data['number'] = str_replace('$', '', $data['number']);
                $data['number'] = str_replace(' ', '', $data['number']);
                $data['number'] = str_replace('.', '', $data['number']);
                $data['number'] = str_replace(',', '.', $data['number']);
                $data['number'] = (double) $data['number'];
                $data['number'] = number_format($data['number'], 2, '.', '');
                //var_dump($data['number']);

                $save_data = array();
                if(isset($data['id']) && !empty($data['id'])) {

                    $save_data['RasLotesNumero']['id'] = $data['id'];

                }

                $validate_number = $this->RasLotesNumero->find('all', [
                    'conditions' => [
                        'RasLotesNumero.number =' => $data['number'],
                        'RasLotesNumero.ras_lote_id =' => $id,
                        'RasLotesNumero.id <>' => $data['id']
                    ]
                ]);


                if(count($validate_number) >= 1) {
                    $msg = "Número ". $validate_number[0]['RasLotesNumero']['number']." já existe. Por favor informe outro.";
                    $class = "alert alert-danger";
                    break;
                }


                $img = $this->moveArquivos($id, $data);
                
                if($img['status']) {

                    if(isset($data['id']) && !empty($data['id'])) {
                        $ras_lotes_numeros = $this->RasLotesNumero->read(null, $data['id']);

                        if($ras_lotes_numeros['RasLotesNumero']['number'] != $data['number']) {
                            //die(var_dump('aas'));
                            unlink(WWW_ROOT.$ras_lotes_numeros['RasLotesNumero']['img']);        
                        }
                    }
                    

                    $save_data['RasLotesNumero']['img'] = $img['img'];
                    $save_data['RasLotesNumero']['number'] = $data['number'];
                    $save_data['RasLotesNumero']['ras_lote_id'] = $id;

                    //die(var_dump($save_data));

                    $this->RasLotesNumero->create(true);
                    $this->RasLotesNumero->save($save_data);
                } else {

                    $save_data['RasLotesNumero']['number'] = $data['number'];
                    $save_data['RasLotesNumero']['ras_lote_id'] = $id;

                    $this->RasLotesNumero->create(false);
                    $this->RasLotesNumero->save($save_data);
                }
            }
            
            $this->Session->setFlash($msg, 'alert', array('plugin' => 'BoostCake', 'class' => $class));
            $this->render(false);

        } else {
            $numeros = $this->RasLotesNumero->find('all', array(
                'conditions' => array(
                    'RasLotesNumero.ras_lote_id' => $id
                )
            ));

            //die(var_dump($numeros));

            $this->set('numeros', $numeros);
        }
    }    

    public function moveArquivos($id, $dados) {

        $tempFile = $dados['img']['tmp_name'];

        if(!is_dir(WWW_ROOT.'/files/Raspadinha_Lotes/'. $id . '/')) {
            mkdir(WWW_ROOT.'/files/Raspadinha_Lotes/'. $id . '/', 0775, true);
        }
        
        $targetPath = 'files/Raspadinha_Lotes/' . $id . '/';

        $extensionFile = pathinfo($dados['img']['name'], PATHINFO_EXTENSION);
        $sizeFile = $dados['img']['size'];
        $newFileName = $dados['number'];

        $targetFile = $targetPath . $newFileName . '.' . $extensionFile;
        if (move_uploaded_file($tempFile, $targetFile)) {
            return array('status' => true, 'img' => $targetFile);
        }
        return array('status' => false, 'img' => $targetFile);
    }

    public function addRaspadinhasCapas($id = NULL) {
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
        
        } else {
            $dados = $this->RasLote->relRaspadinhas($id);
            $dadosSemPremio = $this->RasLote->relRaspadinhasSemPremio($id);
            $lote = $this->RasLote->find('first', array('conditions' => array('RasLote.id' => $id)));
//            fb::info($lote, "\$lote");
            $this->set(compact('id', 'dados', 'lote', 'dadosSemPremio'));
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

                    $msg = 'Registro salvo com sucesso.';
                    $error = 0;

                    $this->loadModel('RasLotesNumero');
                    
                    $this->RasLotesNumero->recursive = -1;
                    
                    $valor_premiado = [];


                    if(isset($this->request->data['RasLote']['valor_premiado'])) {
                        //Pegando o valor premiado
                        $valor_premiado = $this->RasLotesNumero->read(null, $this->request->data['RasLote']['valor_premiado']);
                    }       

                    if(count($valor_premiado) == 0) {
                        $msg = 'Não há valores para o lote.<br> Faça o cadastrado para continuar.';
                        $error = 1;
                    }else {
                        //Atribuindo ao lote o valor premiado encontrado
                        $this->request->data['RasLote']['valor_premiado'] = $valor_premiado['RasLotesNumero']['number'];    
                    }

                    $this->request->data['RasLote']['qtd_geradas'] = $this->request->data['RasLote']['qtd_premiadas'];
//                    $this->request->data['RasLote']['tema_id'] = $this->request->data['RasLote']['tema_id'];

                    if ($this->request->data['RasLote']['qtd_premiadas'] <= $this->request->data['RasLote']['qtd_geradas']) {
                        $this->loadModel('RasLote');
                        $status = $this->RasLote->criarRaspadinhaPremiada($this->request->data);

                        if($status['status'] === FALSE) {
                            $msg = $status['msg'];
                            $error = 1;
                        }

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
                $status = $this->RasLote->criarRaspadinhaNaoPremiada($this->request->data);

                if($status['status'] === FALSE) {
                    $msg = $status['msg'];
                    $error = 1;
                }
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
            $this->RasLote->recursive = -1;
            $this->loadModel('RasLotesNumero');
            $this->RasLotesNumero->recursive = -1;
            $lote = $this->RasLote->find('first', array('conditions' => array('RasLote.id' => $id)));
            //Busca os valores cadastrados para o lote
            $numeros_possiveis = $this->RasLotesNumero->find('list', [
                'conditions' => [
                    'ras_lote_id' => $id
                ]
            ]);
//            fb::info($lote, "\$lote");
            $this->set(compact('id', 'dados', 'lote', 'dadosSemPremio', 'numeros_possiveis'));
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel('TemasRaspadinha');
        $optionsTemas = $this->TemasRaspadinha->find('list');
        $this->set(compact('optionsTemas'));
        $this->RasLote->recursive = -1;
        $this->RasLote->id = $id;
        if (!$this->RasLote->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }



        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['RasLote']['id'] = $id;
            $value = $this->request->data['RasLote']['value'];
            $this->request->data['RasLote']['value'] = $this->App->formataValorDouble($value);

            if($this->request->data['RasLote']['qtd_raspadinhas'] <= $this->request->data['RasLote']['valor_premio']) {
                $this->Session->setFlash('Qtd. de premiados deve ser menor ou igual que a Qtd. total.', 'alert', [
                    'plugin' => 'BoostCake', 
                    'class' => 'alert-danger'
                ]);
            }else {

                if ($this->RasLote->save($this->request->data)) {
                    $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                } else {
                    $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                }
            }
        }

        $this->request->data = $this->RasLote->read(null, $id);

    }

    public function delete($id = null) {

        $this->loadModel('RasLotesNumero');
        $this->RasLotesNumero->recursive = -1;
        $ras_lotes_numeros = $this->RasLotesNumero->find('all', [
            'conditions' => [
                'ras_lote_id' => $id
            ]
        ]);

        foreach ($ras_lotes_numeros as $key => $value) {
            if(is_dir(WWW_ROOT. $value['RasLotesNumero']['img']) && file_exists(WWW_ROOT. $value['RasLotesNumero']['img'])) {

                unlink(WWW_ROOT. $value['RasLotesNumero']['img']);   
            }
            //$this->RasLotesNumero->delete($value['RasLotesNumero']['id']);          
        }

        parent::_delete($id, true);
    }

}
