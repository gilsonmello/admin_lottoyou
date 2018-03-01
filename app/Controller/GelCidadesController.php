<?php
/**
 * GelCidades Controller
 *
 * @property GelCidade $GelCidade
 * @property PaginatorComponent $Paginator
 */
class GelCidadesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index($grid = 0) {
        // ESTADO INICIAL SEMPRE BAHIA
        if(!isset($this->request->data['search'])){
            $this->request->data['search'][0]['field'] = 'GelCidade.estado';
            $this->request->data['search'][0]['type'] = 'text';
            $this->request->data['search'][0]['operator'] = 'is';
            $this->request->data['search'][0]['value'] = 'BAHIA';
            $this->request->data['searchLogic'] = 'AND';
        }

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        $this->GelCidade->recursive = 0;

        // PEGA Estados CADASTRADOS
        $dados = $this->GelCidade->find('all', $options);

        // ESTILIZA LINHA DA GRID
        foreach ($dados as $k => $v) {
            if ($v['GelCidade']['ativo'] != 'Sim') {
                $dados[$k]['GelCidade']['style'] = 'background-color: #F2C9CA';
            }
        }

        // SE AJAX RENDERIZA COMO JSON
        if ($this->request->is('ajax') && $grid == 1) {
            // PREPARA DADOS
            foreach ($dados as $k => $v) {
                $data[] = array_values($v['GelCidade']);
            }

            // CALCULA O TOTAL DE REGISTROS
            $total = count($dados);
            
            // ENVIA DADOS PARA A VIEW
            echo json_encode(compact('data'));
            exit;
        }
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel("Estado");
        $estados = $this->Estado->find("list", array("fields" => array("id", "nome")));
        $this->set(compact("estados"));
        if ($this->request->is('post')) {
            $this->GelCidade->create();
            if ($this->GelCidade->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->loadModel("Estado");
        $estados = $this->Estado->find("list", array("fields" => array("id", "nome")));
        $this->set(compact("estados"));
        
        if (!$this->GelCidade->exists($id)) {
            throw new NotFoundException(__('Invalid GelCidade'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->GelCidade->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $options = array('conditions' => array('GelCidade.' . $this->GelCidade->primaryKey => $id));
            $this->request->data = $this->GelCidade->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        parent::_delete($id);
    }

}
