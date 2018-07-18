(function (namespace, $) {
    "use strict";

    var AppBalanceInserts = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppBalanceInserts.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppBalanceInserts.objectId = '#AppBalanceInserts';
    AppBalanceInserts.modalFormId = '#nivel3';
    AppBalanceInserts.controller = 'balanceInserts';
    AppBalanceInserts.model = 'RasTabelasDesconto';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppBalanceInserts.objectId));
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
        $(document).on('click', AppBalanceInserts.objectId+' .pagination a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    window.materialadmin.AppNavigation.carregando($('#gridBalanceInserts'));
                },
                success: function (data) {
                    $('#gridBalanceInserts').html(data);
                    p._habilitaBotoesConsulta();
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        $(AppBalanceInserts.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppBalanceInserts.objectId + ' #pesquisarBalanceInserts').submit(function () {
            p._loadBalanceInserts();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppBalanceInserts.objectId + ' .btnEditar').click(function () {
            p._loadFormRasTabelasDesconto($(this).attr('id'));
        });

        $(AppBalanceInserts.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'balanceInserts/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsRasTabelasDesconto();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadBalanceInserts = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppBalanceInserts.objectId + ' #pesquisarBalanceInserts');
        var table = $(AppBalanceInserts.objectId + ' #gridBalanceInserts');
        var url = baseUrl + 'balanceInserts/index';

        window.materialadmin.AppNavigation.carregando(table);

        $.get(url, form.serialize(), function (html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                table.html($(html));
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
        var modalObject = $(AppBalanceInserts.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'balanceInserts/add' : 'balanceInserts/' + action + '/' + id;
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

    window.materialadmin.AppBalanceInserts = new AppBalanceInserts;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
