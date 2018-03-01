<?php

class GelEmpresasController extends AppController {

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();
        
        // PREPARA MODEL
        $this->GelEmpresa->recursive = 0;
        $this->GelEmpresa->validate = array();

        // TRATA CONDIÇÕES
        foreach($options['conditions'] as $field => $value){
            if ($field == 'GelEmpresa.nome'){
                $options['conditions'][$field.' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }
        
        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->GelEmpresa->find('all', $options);


        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados','modal'));
    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            // CONFIGURA DADOS ANTES DE SALVAR
            $this->request->data['GelEmpresa']['matriz'] = 0;

            if ($this->GelEmpresa->save($this->request->data)) {
                // SETA VARIÁVEIS
                $gel_empresa_id = $this->GelEmpresa->getLastInsertID();
                $user_id = $this->Session->read('Auth.User.id');

                // CRIA AS CATEGORIAS DA EMPRESA
                $this->loadModel('FinCategoria');
                $this->FinCategoria->setCategoriasPrincipais($gel_empresa_id, $user_id);

                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            // VERIFICA SE A MATRIZ POSSUI CNPJ
            $cnpj_matriz_informado = $this->GelEmpresa->find('count', array('conditions'=>array('matriz'=>1,'cnpj !='=>'')));

            // ENVIA DADOS PARA A VIEW
            $this->set(compact('cnpj_matriz_informado'));
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->GelEmpresa->id = $id;
        if (!$this->GelEmpresa->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['GelEmpresa']['id'] = $id;
            if ($this->GelEmpresa->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            // PEGA DADOS DA EMPRESA
            $this->request->data = $this->GelEmpresa->read(null, $id);

            // VERIFICA SE EXISTE FILIAIS
            $existe_filiais = $this->GelEmpresa->find('count', array('conditions'=>array('matriz'=>0)));

            // ENVIA DADOS PARA A VIEW
            $this->set(compact('existe_filiais'));
        }
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

    public function select($modal = 1) {
        if ($this->request->is(array('post','put'))) {
            // INICIALIZA VARIÁVEIS
            $error = 0;
            $empresa = '';

            // CONFIGURA MODEL
            $this->GelEmpresa->recursive = -1;

            // CONSULTA EMPRESAS
            $dados = $this->GelEmpresa->find('first', array(
                    'conditions'=>array(
                        'GelEmpresa.id'=>$this->data['id'],
                        'GelEmpresa.gel_empresa_id'=>$this->Session->read('Auth.Company.gel_empresa_id'),
                    )
                )
            );

            if (!empty($dados)){
                // CONFIGURA DADOS DA EMPRESA SELECIONADA NA SESSÃO
                $this->Session->write('Auth.Company', $dados['GelEmpresa']);

                // PEGA O NOME DA EMPRESA
                $empresa = $dados['GelEmpresa']['nome'];
            } else {
                // SETA ERRO
                $error = 1;
            }

            echo json_encode(compact('error','empresa')); exit;
        } else {
            // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
            $options = parent::_index();
            
            // PREPARA MODEL
            $this->GelEmpresa->recursive = -1;
            $this->GelEmpresa->validate = array();

            // TRATA CONDIÇÕES
            foreach($options['conditions'] as $field => $value){
                if ($field == 'GelEmpresa.nome'){
                    $options['conditions'][$field.' LIKE'] = "%$value%";
                    unset($options['conditions'][$field]);
                }
            }

            // PEGA EMPRESA PRINCIPAL DA CONTA
            $gel_empresa_id = $this->Session->read('Auth.Company.gel_empresa_id');
            $options['conditions']['gel_empresa_id'] = $gel_empresa_id;

            // PEGA REQUISIÇÕES CADASTRADOS
            $dados = $this->GelEmpresa->find('all', $options);

            // ENVIA DADOS PARA A SESSÃO
            $this->set(compact('dados','modal'));
        }
    }
}