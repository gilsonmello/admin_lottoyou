(function (namespace, $) {
    "use strict";

    var AppRelatorioPagSeguroDepositos = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRelatorioPagSeguroDepositos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRelatorioPagSeguroDepositos.objectId = '#AppRelatorioPagSeguroDepositos';
    AppRelatorioPagSeguroDepositos.modalFormId = '#nivel3';
    AppRelatorioPagSeguroDepositos.controller = 'relatorioPagSeguroDepositos';
    AppRelatorioPagSeguroDepositos.model = 'RasTabelasDesconto';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppRelatorioPagSeguroDepositos.objectId));
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
        $(AppRelatorioPagSeguroDepositos.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppRelatorioPagSeguroDepositos.objectId+' .pagination a').off('click');
                    window.materialadmin.AppNavigation.carregando($('#gridRelatorioPagSeguroDepositos'));
                },
                success: function (data) {
                    $('#gridRelatorioPagSeguroDepositos').html(data);
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

        $(AppRelatorioPagSeguroDepositos.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRelatorioPagSeguroDepositos.objectId + ' #pesquisarRelatorioPagSeguroDepositos').submit(function () {
            p._loadConsRelatorioPagSeguroDepositos();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {

    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsRelatorioPagSeguroDepositos = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppRelatorioPagSeguroDepositos.objectId + ' #pesquisarRelatorioPagSeguroDepositos');
        var table = $(AppRelatorioPagSeguroDepositos.objectId + ' #gridRelatorioPagSeguroDepositos');
        var url = baseUrl + 'relatorioPagSeguroDepositos/index';

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

    window.materialadmin.AppRelatorioPagSeguroDepositos = new AppRelatorioPagSeguroDepositos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
