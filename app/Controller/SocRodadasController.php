<?php

class SocRodadasController extends AppController {

    public $components = array('App');
    
    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();               

        // PREPARA MODEL       
        $this->SocRodada->recursive = 1;
        $this->SocRodada->validate = array();

        // TRATA CONDIÇÕES
        foreach($options['conditions'] as $field => $value){
            if ($field == 'SocRodada.nome'){
                $options['conditions'][$field.' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }
        
        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->SocRodada->find('all', $options);

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados','modal'));
    }

    public function carregarImagem($id) {
        if($this->request->is('post')){
            $this->request->data['SocRodada']['id'] = $id;
            $this->request->data['SocRodada']['imagem_capa'] = $_FILES['imagem_capa']['name'];
            $this->loadModel("SocRodada");
            unset($this->SocRodada->validate);
            if($this->uploadFile($_FILES['imagem_capa'], $id) && $this->SocRodada->save($this->request->data['SocRodada'])){
                die(json_encode(true));
            }
            die(json_encode(false));
        }
    }

    private function uploadFile($parametros = null, $id){

        $path = str_replace('/index.php', "", $_SERVER['SCRIPT_FILENAME'] );

        if(!is_dir($path.'/img/rodadas')){
            mkdir($path.'/img/rodadas');
        }

        if(!is_dir($path.'/img/rodadas/'.$id)){
            mkdir($path.'/img/rodadas/'.$id);
        }

        $nome_imagem = $parametros['name'];

        if(@move_uploaded_file($parametros['tmp_name'], $path.'/img/rodadas/'.$id.'/'.$nome_imagem)){
            return true;
        }

        return false;

    }

    public function add() {

        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel('SocBolao');
        $optionsBoloes = $this->SocBolao->find('list');
        $this->loadModel('SocCategoria');
        $optionsCategorias = $this->SocCategoria->find('list');
        
        $this->set(compact('optionsBoloes', 'optionsCategorias'));
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SocRodada']['valor'] = $this->App->formataValorDouble($this->request->data['SocRodada']['valor']);
            if ($this->SocRodada->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel('SocBolao');
        $optionsBoloes = $this->SocBolao->find('list');
        
        $this->loadModel('SocCategoria');
        $optionsCategorias = $this->SocCategoria->find('list');
        
        $this->set(compact('optionsBoloes', 'optionsCategorias'));
        
        $this->SocRodada->id = $id;
        if (!$this->SocRodada->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SocRodada']['id'] = $id;
            $this->request->data['SocRodada']['valor'] = $this->App->formataValorDouble($this->request->data['SocRodada']['valor']);
            if ($this->SocRodada->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }else{

            $this->request->data = $this->SocRodada->read(null, $id);
            
        }
    }

    public function delete($id = null) {
        parent::_delete($id);
    }
}