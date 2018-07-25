(function (namespace, $) {
    "use strict";

    var AppRelTranPremiadas = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRelTranPremiadas.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRelTranPremiadas.objectId = '#AppRelTranPremiadas';
    AppRelTranPremiadas.modalFormId = '#nivel3';
    AppRelTranPremiadas.controller = 'relTranPremiadas';
    AppRelTranPremiadas.model = 'Transacoes';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppRelTranPremiadas.objectId));
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
        $(AppRelTranPremiadas.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppRelTranPremiadas.objectId+' .pagination a').off('click');
                    window.materialadmin.AppNavigation.carregando($('#gridRelTranPremiadas'));
                },
                success: function (data) {
                    $('#gridRelTranPremiadas').html(data);
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

        $(AppRelTranPremiadas.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRelTranPremiadas.objectId + ' #pesquisarRelTranPremiadas').submit(function () {
            p._loadConsTransacoes();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        /*$(AppRelTranPremiadas.objectId + ' .btnEditar').click(function () {
            p._loadFormTransacoes($(this).attr('id'));
        });

        $(AppRelTranPremiadas.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'relTranPremiadas/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadFormTransacoes();
            });
        });*/
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsTransacoes = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppRelTranPremiadas.objectId + ' #pesquisarRelTranPremiadas');
        var table = $(AppRelTranPremiadas.objectId + ' #gridRelTranPremiadas');
        var url = baseUrl + 'relTranPremiadas/index';

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

    window.materialadmin.AppRelTranPremiadas = new AppRelTranPremiadas;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
