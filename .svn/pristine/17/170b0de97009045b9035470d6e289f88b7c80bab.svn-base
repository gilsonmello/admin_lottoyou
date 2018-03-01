(function(namespace, $) {
    "use strict";

    var AppSisEmailTemplates = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppSisEmailTemplates.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppSisEmailTemplates.objectId = '#AppSisEmailTemplates';
    AppSisEmailTemplates.modalFormId = '#nivel3';
    AppSisEmailTemplates.controller = 'sisEmailTemplates';
    AppSisEmailTemplates.model = 'SisEmailTemplates';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        // INICIALIZA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppSisEmailTemplates.objectId));
        window.materialadmin.AppGrid.initialize();
        window.materialadmin.AppVendor.initialize();
        window.materialadmin.Demo.initialize();

        // INIALIZA EVENTOS DA FUNCIONALIDADE
        p._habilitaEventos();
        p._habilitaBotoesConsulta();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaEventos = function() {
        $(AppSisEmailTemplates.objectId+' #cadastrar'+AppSisEmailTemplates.model).click(function() {
            p._loadFormSisEmailTemplate();
        });

        $(AppSisEmailTemplates.objectId + ' #voltar').click(function() {
            window.materialadmin.AppSisConfiguracoes.carregarCadastros();
        });

        $(AppSisEmailTemplates.objectId+' #pesquisar'+AppSisEmailTemplates.model).submit(function() {
            p._loadConsSisEmailTemplate();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function() {
        $(AppSisEmailTemplates.objectId+' .btnClonar').click(function() {
            p._loadFormSisEmailTemplate($(this).attr('id'), true);
        });

        $(AppSisEmailTemplates.objectId+' .btnEditar').click(function() {
            p._loadFormSisEmailTemplate($(this).attr('id'));
        });

        $(AppSisEmailTemplates.objectId+' .btnDeletar').click(function() {
            var url = baseUrl+AppSisEmailTemplates.controller+'/delete/'+$(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function(){
                p._loadConsSisEmailTemplate();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsSisEmailTemplate = function() {
        // INSTANCIA VARIÁREIS
        var form = $(AppSisEmailTemplates.objectId+' #pesquisar'+AppSisEmailTemplates.model);
        var table = $(AppSisEmailTemplates.objectId+' #grid'+AppSisEmailTemplates.model);
        var url = baseUrl + AppSisEmailTemplates.controller + '/index';

        window.materialadmin.AppNavigation.carregando(table);

        $.post(url, form.serialize(), function(html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                table.html($(html).find('#' + table.attr('id') + ' >'));

                // HABILITA BOTÕES DA CONSULTA
                p._habilitaBotoesConsulta();
            }
        }, 'html');
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormSisEmailTemplate = function(id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSisEmailTemplates.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? AppSisEmailTemplates.controller+'/add' : AppSisEmailTemplates.controller+'/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '850px', function() {
            // RECARREGA CONSULTA
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                // DESTRÓI O TINYCME AO FECHAR
                tinyMCE.editors[0].editorManager.remove();
                if (window.materialadmin.AppForm.getFormState()){
                    p._loadConsSisEmailTemplate();
                }
            });
        });
    };
    
    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppSisEmailTemplates = new AppSisEmailTemplates;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
