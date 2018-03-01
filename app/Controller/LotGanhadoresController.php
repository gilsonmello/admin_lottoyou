<?php

class LotGanhadoresController extends AppController {

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->LotGanhador->recursive = 0;
        $this->LotGanhador->validate = array();

        // TRATA CONDIÇÕES
        foreach($options['conditions'] as $field => $value){
            if ($field == 'LotGanhador.nome'){
                $options['conditions'][$field.' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }
        
        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->LotGanhador->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados','modal'));
    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->LotGanhador->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LotGanhador->id = $id;
        if (!$this->LotGanhador->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['LotGanhador']['id'] = $id;
            if ($this->LotGanhador->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->LotGanhador->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }
    
    public function add_img($user_id) {
//        if (!empty($_FILES)) {
//            $parts = pathinfo($_FILES['file']['name']);
//            $tempFile = $_FILES['file']['tmp_name'];
//            $targetPath = 'img/loterias/';
//            
//            $newFileName = $user_id . '.' . strtolower($parts['extension']);
//            $targetFile = $targetPath . $newFileName;
//            $error = 0;
//
//            if (move_uploaded_file($tempFile, $targetFile)) {
//                // SALVA NO BANCO NO NOME DA IMAGEM
//                $data['LotGanhador']['id'] = $user_id;
//                $data['LotGanhador']['premio'] = strtolower($newFileName);
//                $this->LotGanhador->id = $user_id;
//                $this->LotGanhador->save($data, false);
//                $error = 0;
//            } else {
//                $error = 1;
//            }
//
//            echo json_encode(compact('error'));
//            exit;
//        }
    }
}