<?php
/**
 * CakePHP Configurations
 * @author 
 */
class ConfigurationsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        // TODO: REMOVER ESTE ALLOW E CADASTRAR NO BANCO
        $this->Auth->allow('cadastros');
    }

    public function cadastros() {
    }
}