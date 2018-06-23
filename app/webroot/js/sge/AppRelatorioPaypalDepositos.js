(function (namespace, $) {
    "use strict";

    var AppRelatorioPaypalDepositos = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRelatorioPaypalDepositos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRelatorioPaypalDepositos.objectId = '#AppRelatorioPaypalDepositos';
    AppRelatorioPaypalDepositos.modalFormId = '#nivel3';
    AppRelatorioPaypalDepositos.controller = 'relatorioPaypalDepositos';
    AppRelatorioPaypalDepositos.model = 'RasTabelasDesconto';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppRelatorioPaypalDepositos.objectId));
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

    p._habilitaBotoesPaginate = function() {
        $(document).on('click', AppRelatorioPaypalDepositos.objectId+' .pagination a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    window.materialadmin.AppNavigation.carregando($('#gridRelatorioPaypalDepositos'));
                },
                success: function (data) {
                    $('#gridRelatorioPaypalDepositos').html(data);
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        p._habilitaBotoesPaginate();

        $(AppRelatorioPaypalDepositos.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRelatorioPaypalDepositos.objectId + ' #pesquisarRelatorioPaypalDepositos').submit(function () {
            p._loadRelatorioPaypalDepositos();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppRelatorioPaypalDepositos.objectId + ' .btnEditar').click(function () {
            p._loadFormRasTabelasDesconto($(this).attr('id'));
        });

        $(AppRelatorioPaypalDepositos.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'relatorioPaypalDepositos/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsRasTabelasDesconto();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadRelatorioPaypalDepositos = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppRelatorioPaypalDepositos.objectId + ' #pesquisarRelatorioPaypalDepositos');
        var table = $(AppRelatorioPaypalDepositos.objectId + ' #gridRelatorioPaypalDepositos');
        var url = baseUrl + 'relatorioPaypalDepositos/index';

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
        var modalObject = $(AppRelatorioPaypalDepositos.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'relatorioPaypalDepositos/add' : 'relatorioPaypalDepositos/' + action + '/' + id;
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

    window.materialadmin.AppRelatorioPaypalDepositos = new AppRelatorioPaypalDepositos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
