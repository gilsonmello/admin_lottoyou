(function (namespace, $) {
    "use strict";

    var AppRelatorioRaspadinhas = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRelatorioRaspadinhas.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRelatorioRaspadinhas.objectId = '#AppRelatorioRaspadinhas';
    AppRelatorioRaspadinhas.modalFormId = '#nivel3';
    AppRelatorioRaspadinhas.controller = 'relatorioRaspadinhas';
    AppRelatorioRaspadinhas.model = 'RasTabelasDesconto';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppRelatorioRaspadinhas.objectId));
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
        $(AppRelatorioRaspadinhas.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppRelatorioRaspadinhas.objectId+' .pagination a').off('click');
                    window.materialadmin.AppNavigation.carregando($('#gridRelatorioRaspadinhas'));
                },
                success: function (data) {
                    $('#gridRelatorioRaspadinhas').html(data);
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

        $(AppRelatorioRaspadinhas.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRelatorioRaspadinhas.objectId + ' #pesquisarRelatorioRaspadinhas').submit(function () {
            p._loadConsRelatorioRaspadinhas();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppRelatorioRaspadinhas.objectId + ' .btnEditar').click(function () {
            p._loadFormRasTabelasDesconto($(this).attr('id'));
        });

        $(AppRelatorioRaspadinhas.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'relatorioRaspadinhas/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsRasTabelasDesconto();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsRelatorioRaspadinhas = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppRelatorioRaspadinhas.objectId + ' #pesquisarRelatorioRaspadinhas');
        var table = $(AppRelatorioRaspadinhas.objectId + ' #gridRelatorioRaspadinhas');
        var url = baseUrl + 'relatorioRaspadinhas/index';

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

    p._loadFormRasTabelasDesconto = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppRelatorioRaspadinhas.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'relatorioRaspadinhas/add' : 'relatorioRaspadinhas/' + action + '/' + id;
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

    window.materialadmin.AppRelatorioRaspadinhas = new AppRelatorioRaspadinhas;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
