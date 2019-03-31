(function (namespace, $) {
    "use strict";

    var AppBalances = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppBalances.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppBalances.objectId = '#AppBalances';
    AppBalances.modalFormId = '#nivel3';
    AppBalances.controller = 'balances';
    AppBalances.model = 'Balance';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppBalances.objectId));
        window.materialadmin.AppGrid.initialize();
        window.materialadmin.AppVendor.initialize();
        window.materialadmin.Demo.initialize();

        // CARREGA EVENTOS 
        p._habilitaEventos();
        p._habilitaBotoesConsulta();
        p._habilitaBotoesPaginate();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaBotoesPaginate = function() {
        $(AppBalances.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppBalances.objectId+' .pagination a').off('click');
                    window.materialadmin.AppNavigation.carregando($('#gridBalances'));
                },
                success: function (data) {
                    $('#gridBalances').html(data);
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

        $(AppBalances.objectId + ' #cadastrarBalances').click(function () {
            //p._loadFormBalancesBalance();
        });

        $(AppBalances.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppBalances.objectId + ' #pesquisarBalances').submit(function () {
            p._loadConsBalances();
            return false;
        });

    };

    p._habilitaBotoesConsulta = function () {
        $(AppBalances.objectId + ' .btnInsert').click(function () {
            p._loadFormInsert($(this).attr('id'));
        });
        $(AppBalances.objectId + ' .btnWithdraw').click(function () {
            p._loadFormWithdraw($(this).attr('id'));
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsBalances = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppBalances.objectId + ' #pesquisarBalances');
        var table = $(AppBalances.objectId + ' #gridBalances');
        var url = '/balances/index';

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

    p._loadFormInsert = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppBalances.modalFormId);
        var url = '/balances/insert/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsBalances();
                }
            });
        });
    };

    p._loadFormWithdraw = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppBalances.modalFormId);
        var url = '/balances/withdraw/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsBalances();
                }
            });
        });
    };

    p._loadFormBalances = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppBalances.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? '/balances/add' : '/balances/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                //p._loadConsBalances();
            });
        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppBalances = new AppBalances;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
