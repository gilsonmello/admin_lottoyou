(function (namespace, $) {
    "use strict";

    var AppSocCiclos = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppSocCiclos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppSocCiclos.objectId = '#AppSocCiclos';
    AppSocCiclos.modalFormId = '#nivel3';
    AppSocCiclos.controller = 'socCiclos';
    AppSocCiclos.model = 'SocCiclo';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppSocCiclos.objectId));
        window.materialadmin.AppGrid.initialize();
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
        $(AppSocCiclos.objectId + ' #cadastrarSocCiclo').click(function () {
            p._loadFormSocCiclo();
        });

        $(AppSocCiclos.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppSocCiclos.objectId + ' #pesquisarSocCiclo').submit(function () {
            p._loadConsSocCiclo();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppSocCiclos.objectId + ' .btnEditar').click(function () {
            p._loadFormSocCiclo($(this).attr('id'));
        });

        $(AppSocCiclos.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'socCiclos/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsSocCiclo();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsSocCiclo = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppSocCiclos.objectId + ' #pesquisarSocCiclo');
        var table = $(AppSocCiclos.objectId + ' #gridSocCiclos');
        var url = baseUrl + 'socCiclos/index';

        window.materialadmin.AppNavigation.carregando(table);

        $.post(url, form.serialize(), function (html, textStatus, jqXHR) {
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

    p._loadFormSocCiclo = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocCiclos.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'socCiclos/add' : 'socCiclos/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsSocCiclo();
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppSocCiclos = new AppSocCiclos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
