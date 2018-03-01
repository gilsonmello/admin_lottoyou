<?php

class GelClubesController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();

        #Permitindo que os usuários se registrem
        $this->Auth->allow('add');
    }

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL       
        $this->GelClube->recursive = 1;
        $this->GelClube->validate = array();

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'GelClube.nome') {
                $options['conditions'][$field . ' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->GelClube->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
    }

    public function add() {

        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->GelClube->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function adicionarImagem($idClube ) {

        $this->layout = 'ajax';

        if (!empty($_FILES)) {
            $parts = pathinfo($_FILES['file']['name']);
            $tempFile = $_FILES['file']['tmp_name'];
            $targetPath = 'img/escudos/';
            //$newFileName = $user_id.'-'.date('ymdHis').'.'.$parts['extension'];
            $newFileName = $idClube . '.' . strtolower($parts['extension']);
            $targetFile = $targetPath . $newFileName;
            $error = 0;

            if (move_uploaded_file($tempFile, $targetFile)) {
                // SALVA NO BANCO NO NOME DA IMAGEM
                $data['GelEscudo']['gel_clube_id'] = $idClube;
                $data['GelEscudo']['dimensao'] = strtolower($newFileName);
                $data['GelEscudo']['modified'] = date('d/m/Y H:i:s');
                
                $this->loadModel('GelEscudo');
                $this->GelEscudo->id = $this->GelEscudo->field('id', array('GelEscudo.gel_clube_id' => $idClube));
                $this->GelEscudo->gel_clube_id = $idClube;
                $this->GelEscudo->save($data, false);
//                $this->Session->write('Auth.User.photo', $data['User']['photo']);
                $error = 0;
            } else {
                $error = 1;
            }

            echo json_encode(compact('error'));
            exit;
        }else{
            $this->loadModel('GelEscudo');
            $dados = $this->GelEscudo->find('first', array('conditions' => array('GelEscudo.gel_clube_id' => $idClube)));
            $this->set(compact('dados'));
        }
    }

    public function addCartola() {

        // CONFIGURA LAYOUT
        $this->loadModel('GelEscudo');
        $ok = true;
        $msg = 'Salvo com Sucesso.';
        $class = 'alert-success';

        $filename = 'https://api.cartolafc.globo.com/clubes';
        $str = $this->curl_download($filename);
        $dadosDecode = json_decode($str);

        $this->StartTransaction();
        foreach ($dadosDecode as $value) {

            $dados['id'] = $value->id;
            $dados['nome'] = $value->nome;
            $dados['abreviacao'] = $value->abreviacao;
            $this->GelClube->create(false);
            # Salva o clube
            if ($this->GelClube->save($dados)) {
                #vincula os escudos ao Clube
                foreach ($value->escudos as $k => $v) {
                    $dadosEscudo['gel_clube_id'] = $dados['id'];
                    $dadosEscudo['dimensao'] = $v;

                    $this->GelEscudo->create();
                    if (!$this->GelEscudo->save($dadosEscudo)) {
                        $msg = 'Erro ao vincular o escudo ao Clube.';
                        $class = 'alert-danger';
                        $ok = false;
                    }
                }
            } else {
                $msg = 'Erro ao cadastrar o Clube.';
                $class = 'alert-danger';
                $ok = false;
            }
        }
        $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => $class));
        $this->validaTransacao($ok);
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->GelClube->id = $id;
        if (!$this->GelClube->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['GelClube']['id'] = $id;
            if ($this->GelClube->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {

            $this->request->data = $this->GelClube->read(null, $id);
        }
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

}
