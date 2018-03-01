(function (namespace, $) {
	"use strict";

	var AppDashboard = function () {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function () {
			o.initialize();
		});

	};
	var p = AppDashboard.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppDashboard.objectId = '#AppDashboard';
    AppDashboard.modalFormId = '#nivel1';
    //AppDashboard.controller = 'estPosicoes';
    //AppDashboard.model = 'EstPosicao';

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        window.materialadmin.AppVendor.initialize();
        window.materialadmin.Demo.initialize();

        // CARREGA EVENTOS 
        p._habilitaEventos();
        p._habilitaBotoesConsulta();

	};

	// =========================================================================
	// EVENTS
	// =========================================================================

	p._habilitaEventos = function () {
		var selecionarEmpresas =  $('#header #listGelEmpresas');		

		selecionarEmpresas.off('click');
		selecionarEmpresas.on('click',function(){
			p._loadConsGelEmpresas();
		});
	}

	// =========================================================================
	// BOTOES
	// =========================================================================
	p._habilitaBotoesConsulta = function() {
        $(AppDashboard.objectId + ' .btnVisualizarRevisao').click(function() {        	
            p._loadViewVeiRevisao($(this).attr('id'));
        });        
    };
	// =========================================================================
	// CARREGA CONSULTA 
	// =========================================================================

	p._loadConsGelEmpresas = function () {
    	var modalObject = $(AppDashboard.modalFormId);
    	var url = 'gelEmpresas/select';
    	
        window.materialadmin.AppForm.loadModal(modalObject, url, '500px', function() {
        	modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()) {
                    $('a[href*=gelDashboard]').click();
                }
            });

            // CARREGA JS DO MÓDULO FINANCEIRO
            //window.materialadmin.App.load('AppGelEmpresas');
        });
        return false;
	}

	p._loadViewVeiRevisao = function(id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppDashboard.modalFormId);        
        var url = 'veiRevisoes/view/' + id;        

        window.materialadmin.AppForm.loadModal(modalObject, url, '700px', function() {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()) {
                    //p._loadConsGelCarroceria();
                }
            });

        });
    };
	// =========================================================================
	namespace.AppDashboard = new AppDashboard;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
