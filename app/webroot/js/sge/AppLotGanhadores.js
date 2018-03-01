(function(namespace, $) {
    "use strict";

    var AppLotGanhadores = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppLotGanhadores.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLotGanhadores.objectId = '#AppLotGanhadores';
    AppLotGanhadores.modalFormId = '#nivel3';
    AppLotGanhadores.controller = 'lotGanhadores';
    AppLotGanhadores.model = 'LotGanhador';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLotGanhadores.objectId));
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

    p._habilitaEventos = function() {
        $(AppLotGanhadores.objectId + ' #cadastrarLotGanhador').click(function() {
            p._loadFormLotGanhador();
        });

        $(AppLotGanhadores.objectId + ' #voltar').click(function() {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLotGanhadores.objectId + ' #pesquisarLotGanhador').submit(function() {
            p._loadConsLotGanhador();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function() {
        $(AppLotGanhadores.objectId + ' .btnEditar').click(function() {
            p._loadFormLotGanhador($(this).attr('id'));
        });

        $(AppLotGanhadores.objectId + ' .btnDeletar').click(function() {
            var url = baseUrl + 'lotGanhadores/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function() {
                p._loadConsLotGanhador();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLotGanhador = function() {
        // INSTANCIA VARIÁREIS
        var form = $(AppLotGanhadores.objectId + ' #pesquisarLotGanhador');
        var table = $(AppLotGanhadores.objectId + ' #gridLotGanhadores');
        var url = baseUrl + 'lotGanhadores/index';

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

    p._loadFormLotGanhador = function(id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLotGanhadores.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'lotGanhadores/add' : 'lotGanhadores/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function() {
            $("div#myId").dropzone({ url: "/lotGanhadores/add_img" });
            
            
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLotGanhador();
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLotGanhadores = new AppLotGanhadores;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
