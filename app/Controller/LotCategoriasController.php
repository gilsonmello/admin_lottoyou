<?php

class LotCategoriasController extends AppController {

    public $components = array('App');

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->LotCategoria->recursive = 0;
        $this->LotCategoria->validate = array();

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'LotCategoria.nome') {
                $options['conditions'][$field . ' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->LotCategoria->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {            
            $value = $this->request->data['LotCategoria']['value'];
            $this->request->data['LotCategoria']['value'] = $this->App->formataValorDouble($value);
            if ($this->LotCategoria->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LotCategoria->id = $id;
        if (!$this->LotCategoria->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['LotCategoria']['id'] = $id;
            $value = $this->request->data['LotCategoria']['value'];
            $this->request->data['LotCategoria']['value'] = $this->App->formataValorDouble($value);
            if ($this->LotCategoria->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }

        $this->request->data = $this->LotCategoria->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

    public function addImg($id) {
        $this->layout = 'ajax';

        if (!empty($_FILES)) {
            $parts = pathinfo($_FILES['file']['name']);
            $tempFile = $_FILES['file']['tmp_name'];
            $targetPath = 'img/loterias/categorias/';
            //$newFileName = $user_id.'-'.date('ymdHis').'.'.$parts['extension'];
            $newFileName = $id . '.' . strtolower($parts['extension']);
            $targetFile = $targetPath . $newFileName;
            $error = 0;

            if (move_uploaded_file($tempFile, $targetFile)) {
                // SALVA NO BANCO NO NOME DA IMAGEM
                $data['LotCategoria']['img_loteria'] = strtolower($newFileName);
                $data['LotCategoria']['modified'] = date('d/m/Y H:i:s');

                $this->loadModel('LotCategoria');
                $this->LotCategoria->id = $id;
                $this->LotCategoria->save($data, false);
//                $this->Session->write('Auth.User.photo', $data['User']['photo']);
                $error = 0;
            } else {
                $error = 1;
            }

            echo json_encode(compact('error'));
            exit;
        } else {
            
            $dados = $this->LotCategoria->find('first', array('conditions' => array('LotCategoria.id' => $id)));
            $this->set(compact('dados'));
        }
    }

}
