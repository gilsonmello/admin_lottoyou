<?php

class SocCategoriasController extends AppController {

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->SocCategoria->recursive = 0;
        $this->SocCategoria->validate = array();

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'SocCategoria.nome') {
                $options['conditions'][$field . ' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->SocCategoria->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->SocCategoria->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->SocCategoria->id = $id;
        if (!$this->SocCategoria->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SocCategoria']['id'] = $id;
            if ($this->SocCategoria->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->SocCategoria->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

    public function adicionarImagem($idCategoria) {

        $this->layout = 'ajax';

        if (!empty($_FILES)) {
            $parts = pathinfo($_FILES['file']['name']);
            $tempFile = $_FILES['file']['tmp_name'];
            $targetPath = 'img/soccer-expert/categoria/';
            //$newFileName = $user_id.'-'.date('ymdHis').'.'.$parts['extension'];
            $newFileName = $idCategoria . '.' . strtolower($parts['extension']);
            $targetFile = $targetPath . $newFileName;
            $error = 0;

            if (move_uploaded_file($tempFile, $targetFile)) {
                // SALVA NO BANCO NO NOME DA IMAGEM
                $data['SocCategoria']['id'] = $idCategoria;
                $data['SocCategoria']['imagem_capa'] = strtolower($newFileName);
                $data['SocCategoria']['modified'] = date('d/m/Y H:i:s');

                $this->loadModel('SocCategoria');
//                $this->SocCategoria->id = $this->SocCategoria->field('id', array('SocCategoria.gel_clube_id' => $idCategoria));
                $this->SocCategoria->save($data, false);
//                $this->Session->write('Auth.User.photo', $data['User']['photo']);
                $error = 0;
            } else {
                $error = 1;
            }

            echo json_encode(compact('error'));
            exit;
        } else {
            $this->loadModel('SocCategoria');
            $dados = $this->SocCategoria->find('first', array('conditions' => array('SocCategoria.id' => $idCategoria)));
            $this->set(compact('dados'));
        }
    }

}
