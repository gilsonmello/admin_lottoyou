(function (namespace, $) {
    "use strict";

    var AppBalanceWithdraw = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppBalanceWithdraw.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppBalanceWithdraw.objectId = '#AppBalanceWithdraw';
    AppBalanceWithdraw.modalFormId = '#nivel3';
    AppBalanceWithdraw.controller = 'balanceWithdraw';
    AppBalanceWithdraw.model = 'BalanceWithdraw';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppBalanceWithdraw.objectId));
        window.materialadmin.AppGrid.initialize();
        window.materialadmin.AppVendor.initialize();
        window.materialadmin.Demo.initialize();

        $(AppBalanceWithdraw.objectId+' .pagination a').off('click');

        // CARREGA EVENTOS 
        p._habilitaEventos();
        p._habilitaBotoesConsulta();
        p._habilitaBotoesPaginate();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaBotoesPaginate = function() {
        $(AppBalanceWithdraw.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppBalanceWithdraw.objectId+' .pagination a').off('click');
                    window.materialadmin.AppNavigation.carregando($('#gridBalanceWithdraw'));
                },
                success: function (data) {
                    $('#gridBalanceWithdraw').html(data);
                    p._habilitaBotoesConsulta();
                    p._habilitaBotoesPaginate();
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        $(AppBalanceWithdraw.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppBalanceWithdraw.objectId + ' #pesquisarBalanceWithdraw').submit(function () {
            p._loadConsBalanceWithdraw();
            return false;
        });
    };


    p._habilitaBotoesConsulta = function () {
        $(AppBalanceWithdraw.objectId + ' .btnEditar').click(function () {
            p._loadFormBalanceWithdraw($(this).attr('id'));
        });

        $(AppBalanceWithdraw.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'balanceWithdraw/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsBalanceWithdraw();
            });
        });
    };


    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsBalanceWithdraw = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppBalanceWithdraw.objectId + ' #pesquisarBalanceWithdraw');
        var table = $(AppBalanceWithdraw.objectId + ' #gridBalanceWithdraw');
        var url = baseUrl + 'balanceWithdraw/index';

        window.materialadmin.AppNavigation.carregando(table);

        $.get(url, form.serialize(), function (html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                table.html($(html));
                // HABILITA BOTÕES DA CONSULTA
                p._habilitaBotoesConsulta();
                p._habilitaBotoesPaginate();
            }
        }, 'html');
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormBalanceWithdraw = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppBalanceWithdraw.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'balanceWithdraw/add' : 'balanceWithdraw/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsBalanceWithdraw();
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppBalanceWithdraw = new AppBalanceWithdraw;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
