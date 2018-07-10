(function (namespace, $) {
    "use strict";

    var AppRelatorioItens = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRelatorioItens.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRelatorioItens.objectId = '#AppRelatorioItens';
    AppRelatorioItens.modalFormId = '#nivel3';
    AppRelatorioItens.controller = 'relatorioItens';
    AppRelatorioItens.model = 'RasTabelasDesconto';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppRelatorioItens.objectId));
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
        $(document).on('click', AppRelatorioItens.objectId+' .pagination a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    window.materialadmin.AppNavigation.carregando($('#gridRelatorioItens'));
                },
                success: function (data) {
                    $('#gridRelatorioItens').html(data);
                    p._habilitaBotoesConsulta();
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        $(AppRelatorioItens.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRelatorioItens.objectId + ' #pesquisarRelatorioItens').submit(function () {
            p._loadRelatorioItens();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppRelatorioItens.objectId + ' .btnEditar').click(function () {
            p._loadFormRasTabelasDesconto($(this).attr('id'));
        });

        $(AppRelatorioItens.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'relatorioItens/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsRasTabelasDesconto();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadRelatorioItens = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppRelatorioItens.objectId + ' #pesquisarRelatorioItens');
        var table = $(AppRelatorioItens.objectId + ' #gridRelatorioItens');
        var url = baseUrl + 'relatorioItens/index';

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
        var modalObject = $(AppRelatorioItens.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'relatorioItens/add' : 'relatorioItens/' + action + '/' + id;
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

    window.materialadmin.AppRelatorioItens = new AppRelatorioItens;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
