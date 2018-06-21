(function (namespace, $) {
    "use strict";

    var AppRasTabelasDescontos = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRasTabelasDescontos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRasTabelasDescontos.objectId = '#AppRasTabelasDescontos';
    AppRasTabelasDescontos.modalFormId = '#nivel3';
    AppRasTabelasDescontos.controller = 'rasTabelasDescontos';
    AppRasTabelasDescontos.model = 'RasTabelasDesconto';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppRasTabelasDescontos.objectId));
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
        $(AppRasTabelasDescontos.objectId + ' #cadastrarRasTabelasDesconto').click(function () {
            p._loadFormRasTabelasDesconto();
        });

        $(AppRasTabelasDescontos.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRasTabelasDescontos.objectId + ' #pesquisarRasTabelasDesconto').submit(function () {
            p._loadConsRasTabelasDesconto();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppRasTabelasDescontos.objectId + ' .btnEditar').click(function () {
            p._loadFormRasTabelasDesconto($(this).attr('id'));
        });

        $(AppRasTabelasDescontos.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'rasTabelasDescontos/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsRasTabelasDesconto();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsRasTabelasDesconto = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppRasTabelasDescontos.objectId + ' #pesquisarRasTabelasDesconto');
        var table = $(AppRasTabelasDescontos.objectId + ' #gridRasTabelasDescontos');
        var url = baseUrl + 'rasTabelasDescontos/index';

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

    p._loadFormRasTabelasDesconto = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppRasTabelasDescontos.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'rasTabelasDescontos/add' : 'rasTabelasDescontos/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsRasTabelasDesconto();
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppRasTabelasDescontos = new AppRasTabelasDescontos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
