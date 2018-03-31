(function (namespace, $) {
    "use strict";

    var AppRasTabelasPremios = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRasTabelasPremios.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRasTabelasPremios.objectId = '#AppRasTabelasPremios';
    AppRasTabelasPremios.modalFormId = '#nivel3';
    AppRasTabelasPremios.controller = 'rasTabelasPremios';
    AppRasTabelasPremios.model = 'RasTabelasPremio';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppRasTabelasPremios.objectId));
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
        $(AppRasTabelasPremios.objectId + ' #cadastrarRasTabelasPremio').click(function () {
            p._loadFormRasTabelasPremio();
        });

        $(AppRasTabelasPremios.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRasTabelasPremios.objectId + ' #pesquisarRasTabelasPremio').submit(function () {
            p._loadConsRasTabelasPremio();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppRasTabelasPremios.objectId + ' .btnEditar').click(function () {
            p._loadFormRasTabelasPremio($(this).attr('id'));
        });

        $(AppRasTabelasPremios.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'rasTabelasPremios/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsRasTabelasPremio();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsRasTabelasPremio = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppRasTabelasPremios.objectId + ' #pesquisarRasTabelasPremio');
        var table = $(AppRasTabelasPremios.objectId + ' #gridRasTabelasPremios');
        var url = baseUrl + 'rasTabelasPremios/index';

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

    p._loadFormRasTabelasPremio = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppRasTabelasPremios.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'rasTabelasPremios/add' : 'rasTabelasPremios/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsRasTabelasPremio();
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppRasTabelasPremios = new AppRasTabelasPremios;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
