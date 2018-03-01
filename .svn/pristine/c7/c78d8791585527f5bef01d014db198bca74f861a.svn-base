<?php

App::uses('AppController', 'Controller');

/**
 * Configuracoes Controller
 *
 * @property Configuracao $Configuracao
 */
class ConfiguracoesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $title_for_layout = "Configurações";
        $this->Configuracao->recursive = 0;
        $this->set('configuracoes', $this->paginate());
        $this->set('title_for_layout', $title_for_layout);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Configuracao->exists($id)) {
            throw new NotFoundException(__('Invalid configuracao'));
        }
        $options = array('conditions' => array('Configuracao.' . $this->Configuracao->primaryKey => $id));
        $this->set('configuracao', $this->Configuracao->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $title_for_layout = "Editar Configuração";
        $ok = true;
        if (!empty($this->request->data)) {
            if ($this->request->is('post')) {
                $msg = "Salvo com Sucesso!";
                $class = "alert alert-success";
                $this->Configuracao->create(false);
                if (!$this->Configuracao->save($this->request->data)) {
                    $msg = "Erro ao salvar o programa. Contato o administrador do Sistema.";
                    $class = "alert alert-danger";
                    $ok = false;
                }
            }
            $this->Session->setFlash($msg, "default", array("class" => $class));
            if ($ok) {
                $this->redirect(array('action' => 'index'));
            }
        }
        $this->set(compact("title_for_layout"));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $title_for_layout = "Editar Configuração";
        if (!$this->Configuracao->exists($id)) {
            throw new NotFoundException(__('Invalid configuracao'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Configuracao->save($this->request->data)) {
                $this->Session->setFlash(__('The configuracao has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The configuracao could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Configuracao.' . $this->Configuracao->primaryKey => $id));
            $this->request->data = $this->Configuracao->find('first', $options);
        }
        $this->set(compact("title_for_layout"));
        $this->render('add');
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Configuracao->id = $id;
        if (!$this->Configuracao->exists()) {
            throw new NotFoundException(__('Invalid configuracao'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Configuracao->delete()) {
            $this->Session->setFlash(__('Configuracao deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Configuracao was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
