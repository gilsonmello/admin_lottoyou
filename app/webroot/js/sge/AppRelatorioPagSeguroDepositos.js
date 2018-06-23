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
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaBotoesPaginate = function() {
        $(document).on('click', AppRelatorioPagSeguroDepositos.objectId+' .pagination a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    window.materialadmin.AppNavigation.carregando($('#gridRelatorioPagSeguroDepositos'));
                },
                success: function (data) {
                    $('#gridRelatorioPagSeguroDepositos').html(data);
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        p._habilitaBotoesPaginate();

        $(AppRelatorioPagSeguroDepositos.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRelatorioPagSeguroDepositos.objectId + ' #pesquisarRelatorioPagSeguroDepositos').submit(function () {
            p._loadRelatorioPagSeguroDepositos();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppRelatorioPagSeguroDepositos.objectId + ' .btnEditar').click(function () {
            p._loadFormRasTabelasDesconto($(this).attr('id'));
        });

        $(AppRelatorioPagSeguroDepositos.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'relatorioPagSeguroDepositos/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsRasTabelasDesconto();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadRelatorioPagSeguroDepositos = function () {
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
            }
        }, 'html');
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormRasTabelasDesconto = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppRelatorioPagSeguroDepositos.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'relatorioPagSeguroDepositos/add' : 'relatorioPagSeguroDepositos/' + action + '/' + id;
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

    window.materialadmin.AppRelatorioPagSeguroDepositos = new AppRelatorioPagSeguroDepositos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
