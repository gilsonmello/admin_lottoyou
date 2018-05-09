<?php

class SocRodadasController extends AppController {

    public $components = array('App');

    public function beforeRender()
    {
        parent::beforeRender();
        $this->SocRodada->recursive = -1;

        $targetPath = 'files/Soccer_Expert_Rodadas_Imagem_Modal';
        if(!is_dir($targetPath)) {
            mkdir($targetPath, 0777);
        }
    }

    public function atualizarPontuacao($id) 
    {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';
        $this->SocRodada->recursive = -1;

        $this->render = false;

        if($this->request->is('post')) {
            $this->loadModel('SocJogo');
            $this->SocJogo->recursive = -1;
            $this->loadModel('SocAposta');
            $this->loadModel('SocConfRodada');
            $this->SocAposta->recursive = -1;
            $this->SocConfRodada->recursive = -1;

            

            $config_rodada = $this->SocConfRodada->find('first', [
                'conditions' => [
                    'soc_rodada_id' => $id,
                    'active' => 1
                ]
            ]);

            if(!$config_rodada) {
                $this->response->body(json_encode([
                    'msg' => 'Não existe configuração cadastrada para a cartela', 
                    'status' => 'error'
                ]));
                $this->response->statusCode(400);
                $this->response->send();
                $this->_stop();
            }

            $apostas = $this->SocAposta->find('all', [
                'conditions' => [
                    'soc_rodada_id' => $id
                ]
            ]);

            foreach ($apostas as $a => $aposta) {

                $jogo = $this->SocJogo->find('first', [
                    'conditions' => [
                        'id' => $aposta['SocAposta']['soc_jogo_id']
                    ]
                ]);
               
                $aposta['SocAposta']['pontuacao'] = 0;
                
                if($this->acertouVencedor($jogo, $aposta)) {
                    $aposta['SocAposta']['pontuacao'] += $config_rodada['SocConfRodada']['acertar_vencedor_jogo'];
                } 

                if(!$this->acertouVencedor($jogo, $aposta)) {
                    $aposta['SocAposta']['pontuacao'] += $config_rodada['SocConfRodada']['nao_acertar_vencedor_jogo'];
                }    
                                  
                if($this->acertouPlacar($jogo, $aposta)) {
                    $aposta['SocAposta']['pontuacao'] += $config_rodada['SocConfRodada']['acertar_placar'];
                } 


                if($this->empateComVendedor($jogo, $aposta)) {
                    $aposta['SocAposta']['pontuacao'] += $config_rodada['SocConfRodada']['empate_com_vencedor'];
                }

                if($this->empateSemExatidao($jogo, $aposta)) {
                    $aposta['SocAposta']['pontuacao'] += $config_rodada['SocConfRodada']['acertar_empate_sem_exatidao'];
                }

                if($this->acertouDiferenca($jogo, $aposta) && $this->acertouVencedor($jogo, $aposta)) {
                    $aposta['SocAposta']['pontuacao'] += $config_rodada['SocConfRodada']['acertar_jogo_e_diferenca_gols'];
                }

                $this->SocAposta->save($aposta);

            }

            $this->response->body(json_encode([
                'msg' => 'Pontuação atualizada com sucesso', 
                'status' => 'ok'
            ]));

            $this->response->send();
            $this->_stop();
            
        }

    }

    private function acertouDiferenca($jogo, $aposta) 
    {
        $jogo_resultado_clube_casa = $jogo['SocJogo']['resultado_clube_casa'];
        $jogo_resultado_clube_fora = $jogo['SocJogo']['resultado_clube_fora'];
        $aposta_resultado_clube_casa = $aposta['SocAposta']['resultado_clube_casa'];
        $aposta_resultado_clube_fora = $aposta['SocAposta']['resultado_clube_fora'];

        $diferenca_jogo = $jogo_resultado_clube_casa - $jogo_resultado_clube_fora;
        $diferenca_jogo = $diferenca_jogo < 0 ? $diferenca_jogo * -1 : $diferenca_jogo;

        $diferenca_aposta = $aposta_resultado_clube_casa - $aposta_resultado_clube_fora;
        $diferenca_aposta = $diferenca_aposta < 0 ? $diferenca_aposta * -1 : $diferenca_aposta;
        
        if(!$this->empate($jogo_resultado_clube_casa, $jogo_resultado_clube_fora) && $diferenca_jogo == $diferenca_aposta) {
            return true;
        }
        return false;
    }

    private function empateSemExatidao($jogo, $aposta) 
    {
        $jogo_resultado_clube_casa = $jogo['SocJogo']['resultado_clube_casa'];
        $jogo_resultado_clube_fora = $jogo['SocJogo']['resultado_clube_fora'];
        $aposta_resultado_clube_casa = $aposta['SocAposta']['resultado_clube_casa'];
        $aposta_resultado_clube_fora = $aposta['SocAposta']['resultado_clube_fora'];
        if(
            $this->empate($jogo_resultado_clube_casa, $jogo_resultado_clube_fora) 
            && $this->empate($aposta_resultado_clube_casa, $aposta_resultado_clube_fora)
            && !$this->acertouPlacar($jogo, $aposta)
        ) 
        {
            return true;
        }
        return false;
    }

    private function empate($resultado_clube_casa, $resultado_clube_fora) 
    {
        if($resultado_clube_casa == $resultado_clube_fora) {
            return true;
        }
        return false;
    }

    private function empateComVendedor($jogo, $aposta) 
    {
        $jogo_resultado_clube_casa = $jogo['SocJogo']['resultado_clube_casa'];
        $jogo_resultado_clube_fora = $jogo['SocJogo']['resultado_clube_fora'];
        $aposta_resultado_clube_casa = $aposta['SocAposta']['resultado_clube_casa'];
        $aposta_resultado_clube_fora = $aposta['SocAposta']['resultado_clube_fora'];
        //Verifico se o usuário marcou empate, mas houve um ganhador do jogo
        if(!$this->empate($jogo_resultado_clube_casa, $jogo_resultado_clube_fora) && 
            $this->empate($aposta_resultado_clube_casa, $aposta_resultado_clube_fora)) 
        {
            return true;
        }
        return false;
    }

   
    private function acertouPlacar($jogo, $aposta) 
    {        
        if($jogo['SocJogo']['resultado_clube_casa'] == $aposta['SocAposta']['resultado_clube_casa'] && $jogo['SocJogo']['resultado_clube_fora'] == $aposta['SocAposta']['resultado_clube_fora']) {
            return true;
        } 
        return false;
    }

    private function acertouVencedor($jogo, $aposta) {
        $vencedor = $jogo['SocJogo']['resultado_clube_casa'] > 
            $jogo['SocJogo']['resultado_clube_fora'] ? 'casa' : 'fora';


        $vencedorUsuario = $aposta['SocAposta']['resultado_clube_casa'] > 
            $aposta['SocAposta']['resultado_clube_fora'] ? 'casa' : 'fora';

        $jogo_resultado_clube_casa = $jogo['SocJogo']['resultado_clube_casa'];
        $jogo_resultado_clube_fora = $jogo['SocJogo']['resultado_clube_fora'];
        $aposta_resultado_clube_casa = $aposta['SocAposta']['resultado_clube_casa'];
        $aposta_resultado_clube_fora = $aposta['SocAposta']['resultado_clube_fora'];

        
        
        if($vencedor == $vencedorUsuario 
            && !$this->empate($jogo_resultado_clube_casa, $jogo_resultado_clube_fora)
            && !$this->empate($aposta_resultado_clube_casa, $aposta_resultado_clube_fora)
        ) {
            return true;
        }     
        return false;
    }

    public function cadastrarResultados($id) 
    {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';
        $this->SocRodada->recursive = -1;
        $this->loadModel('SocJogo');
        $this->SocJogo->recursive = -1;
        //$categoria = $this->SocJogo->read(null, $id);

        if($this->request->is('post')) {

            $error = 0;
            $msg = '';
            foreach ($this->request->data['SocJogo'] as $key => $value) {
                $save_data['SocJogo']['id'] = $key;
                $save_data['SocJogo']['soc_rodada_id'] = $value['soc_rodada_id'];
                $save_data['SocJogo']['gel_clube_casa_id'] = $value['gel_clube_casa_id'];
                $save_data['SocJogo']['resultado_clube_casa'] = $value['resultado_clube_casa'];
                $save_data['SocJogo']['gel_clube_fora_id'] = $value['gel_clube_fora_id'];
                $save_data['SocJogo']['resultado_clube_fora'] = $value['resultado_clube_fora'];
                
                $this->SocJogo->create(false);
                if(!$this->SocJogo->save($save_data)) {
                    $error = 1;
                    $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));                      
                }
            }

            if($error == 0) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            }

        } else {
            $jogos = $this->SocJogo->find('all', [
                'conditions' => [
                    'soc_rodada_id' => $id
                ]
            ]);

            $categoria = $this->SocRodada->read(null, $id);
            $this->set('jogos', $jogos);
            $this->set('soc_rodada_id', $id);
            $this->set('categoria', $categoria);
        }

    }
    
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
        if($this->request->is('post')) {

            $this->request->data['SocRodada']['id'] = $id;
            unset($this->SocRodada->validate);

            $this->SocRodada->create(false);

            //die(var_dump($this->request->data));
            if($this->uploadFile($_FILES['imagem_capa'], $id)) {
                $this->SocRodada->save($this->request->data);
                die(json_encode(true));
            }
            die(json_encode(false));
        } else {
            $dados = $this->SocRodada->read(null, $id);
            $this->set('dados', $dados);
        }
    }

    public function carregarImagemModal($id) {
        if($this->request->is('post')) {

            $this->request->data = $this->SocRodada->read(null, $id);
            unset($this->SocRodada->validate);

            //die(var_dump($this->request->data));
            if($this->uploadFileImagemModal($_FILES['imagem_modal'], $id)) {
                $this->SocRodada->save($this->request->data);
                die(json_encode(true));
            }
            die(json_encode(false));
        } else {
            $dados = $this->SocRodada->read(null, $id);
            $this->set('dados', $dados);
        }
    }

    private function uploadFileImagemModal($parametros = null, $id){

        $parts = pathinfo($parametros['name']);

        $newFileName = $id . '.' . strtolower($parts['extension']);

        
        $targetFile = 'files/Soccer_Expert_Rodadas_Imagem_Modal/'. $newFileName;

        if(!is_dir('files/Soccer_Expert_Rodadas_Imagem_Modal')){
            mkdir('files/Soccer_Expert_Rodadas_Imagem_Modal', 0777);
        }

        if(file_exists(WWW_ROOT.$this->request->data['SocRodada']['imagem_modal']) && $this->request->data['SocRodada']['imagem_modal'] != null) {
            unlink(WWW_ROOT.$this->request->data['SocRodada']['imagem_modal']);
        }

        if(@move_uploaded_file($parametros['tmp_name'], $targetFile)){
            $this->request->data['SocRodada']['imagem_modal'] = $targetFile;
            return true;
        }

        return false;
    }

    private function uploadFile($parametros = null, $id){

        $parts = pathinfo($parametros['name']);

        $newFileName = $id . '.' . strtolower($parts['extension']);
        
        $targetFile = 'files/Soccer_Expert_Rodadas/'. $newFileName;

        if(!is_dir('files/Soccer_Expert_Rodadas')){
            mkdir('files/Soccer_Expert_Rodadas', 0777);
        }

        if(@move_uploaded_file($parametros['tmp_name'], $targetFile)){
            $this->request->data['SocRodada']['imagem_capa'] = $targetFile;
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
        $this->SocCategoria->recursive = -1;
        $optionsCategorias = $this->SocCategoria->find('list');

        $this->loadModel('SocCiclo');
        $this->SocCiclo->recursive = -1;
        $optionsCiclos = $this->SocCiclo->find('list');
        
        $this->set(compact('optionsBoloes', 'optionsCategorias', 'optionsCiclos'));
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

        $this->loadModel('SocCiclo');
        $this->SocCiclo->recursive = -1;
        $optionsCiclos = $this->SocCiclo->find('list');

        $this->set(compact('optionsBoloes', 'optionsCategorias', 'optionsCiclos'));
        
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