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
        p._habilitaBotoesPaginate();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaBotoesPaginate = function() {
        $(AppRelatorioPaypalDepositos.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppRelatorioPaypalDepositos.objectId+' .pagination a').off('click');
                    window.materialadmin.AppNavigation.carregando($('#gridRelatorioPaypalDepositos'));
                },
                success: function (data) {
                    $('#gridRelatorioPaypalDepositos').html(data);
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

        p._habilitaBotoesPaginate();

        $(AppRelatorioPaypalDepositos.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRelatorioPaypalDepositos.objectId + ' #pesquisarRelatorioPaypalDepositos').submit(function () {
            p._loadConsRelatorioPaypalDepositos();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {

    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsRelatorioPaypalDepositos = function () {
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
                p._habilitaBotoesPaginate();
            }
        }, 'html');
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppRelatorioPaypalDepositos = new AppRelatorioPaypalDepositos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
