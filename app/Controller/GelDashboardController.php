<?php

App::uses('AppController', 'Controller');

class GelDashboardController extends AppController {

    /**
     * Este controller não utilizada tabelas por padrão
     */
    var $uses = false;


    /**
     * Exbibe lista de cadastros do módulo financeiro 
     */
    public function index() {
    	// CARREGA MODELS     

        $userId = $this->Session->read('Auth.User.id');
        
        $valor_total_abastecimentos = 0;
                
        $valor_mes_abastecimentos = 0;
        
        $valor_rodado = 0;
                
        $last_km = 0;
                
        $revisoes = 0;
        // DADOS REVISÃO PREVENTIVA
        $vlrRevisaoPreventiva = 0;
        $vlrItensRevisaoPreventiva = 0;

        // DADOS REVISÃO CORRETIVA
        $vlrRevisaoCorretiva = 0;
        $vlrItensRevisaoCorretiva = 0;
        
        // ENVIA DADOS PARA SESSÃO
        $this->set(compact('revisoes', 'saldo_total_contas', 'valor_rodado', 'contas_totais', 'valor_mes_abastecimentos', 'valor_total_abastecimentos', 'last_km', 'vlrRevisaoPreventiva', 'vlrRevisaoCorretiva', 'vlrItensRevisaoCorretiva', 'vlrItensRevisaoPreventiva'));
    }
}

