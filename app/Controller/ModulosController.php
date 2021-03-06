<?php
/**
 * CakePHP ModulosController
 * @author 
 */
class ModulosController extends AppController {
    
    public function index($modal = 0) {   
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();
        
        // CONFIGURA O MODEL
        $this->Modulo->recursive = 1;
        
        // PEGA MÓDULOS CADASTRADOS
        $dados = $this->Modulo->find('all', $options);

        // INICIALIZA VARIÁVEIS
        $semFuncionalidade = $ativo = $inativo = 0;

        // ESTILIZA LINHA DA GRID
        foreach($dados as $k => $v){
            if ($v['Modulo']['ativo'] != 'Sim') {
                $dados[$k]['Modulo']['style'] = 'background-color: #F2C9CA';
                $inativo++;
            } else {
                $ativo++;
            }

            if ($v['Modulo']['totalFuncionalidades'] == 0){
                $semFuncionalidade++;
            }
        }

        // CALCULA O TOTAL DE REGISTROS
        $total = count($dados);
        
        // ENVIA DADOS PARA A VIEW
        if($modal == 0){
            return compact('total','dados','ativo','inativo','semFuncionalidade');
        } else {
            $this->set(compact('total','dados','ativo','inativo','semFuncionalidade','modal'));
        }
    }
    
    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Modulo->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
        
        // PEGA LISTA DE FUNCIONALIDADES
        $this->set('optionsFuncionalidades', $this->Modulo->Funcionalidade->find('list', array('conditions'=>array('Funcionalidade.active'=>1))));
    }
    
    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->Modulo->id = $id;
        
        if (!$this->Modulo->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Modulo']['id'] = $id;

            if ($this->Modulo->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
        
        $this->request->data = $this->Modulo->read(null, $id);
        $aux = array('0');
        foreach($this->request->data['Funcionalidade'] as $v){
            $aux[] = $v['id'];
        }
        $this->set('selectedFuncionalidades', $aux);

        // PEGA LISTA DE FUNCIONALIDADES
        $this->set('optionsFuncionalidades', $this->Modulo->Funcionalidade->find('list', array('conditions'=>array('OR'=>array('Funcionalidade.active'=>1,'Funcionalidade.id IN ('.implode(',',$aux).')')))));
    }
    
    public function delete($id = null) {
        parent::_delete($id);
    }
}
