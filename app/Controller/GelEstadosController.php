<?php

/**
 * GelEstados Controller
 *
 * @property GelEstado $GelEstado
 * @property PaginatorComponent $Paginator
 */
class GelEstadosController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('buscarCidades'); // Permitindo que os usuários se registrem        
    }

    /**
     * index method
     *
     * @return void
     */
    public function index($grid = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        $this->GelEstado->recursive = 0;

        // PEGA GelEstados CADASTRADOS
        $dados = $this->GelEstado->find('all', $options);

        // ESTILIZA LINHA DA GRID
        foreach ($dados as $k => $v) {
            if ($v['GelEstado']['ativo'] != 'Sim') {
                $dados[$k]['GelEstado']['style'] = 'background-color: #F2C9CA';
            }
        }

        // SE AJAX RENDERIZA COMO JSON
        if ($this->request->is('ajax') && $grid == 1) {
            // PREPARA DADOS
            foreach ($dados as $k => $v) {
                $records[] = $v['GelEstado'];
            }

            // CALCULA O TOTAL DE REGISTROS
            $total = count($dados);

            // ENVIA DADOS PARA A VIEW
            echo json_encode(compact('total', 'records'));
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

        if ($this->request->is('post')) {
            $this->GelEstado->create();
            if ($this->GelEstado->save($this->request->data)) {
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

        if (!$this->GelEstado->exists($id)) {
            throw new NotFoundException(__('Invalid GelEstado'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->GelEstado->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $options = array('conditions' => array('GelEstado.' . $this->GelEstado->primaryKey => $id));
            $this->request->data = $this->GelEstado->find('first', $options);
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