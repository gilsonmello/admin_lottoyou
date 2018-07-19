(function (namespace, $) {
    "use strict";

    var AppTransacoes = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppTransacoes.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppTransacoes.objectId = '#AppTransacoes';
    AppTransacoes.modalFormId = '#nivel3';
    AppTransacoes.controller = 'transacoes';
    AppTransacoes.model = 'Transacoes';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppTransacoes.objectId));
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
        $(document).on('click', AppTransacoes.objectId+' .pagination a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    window.materialadmin.AppNavigation.carregando($('#gridTransacoes'));
                },
                success: function (data) {
                    $('#gridTransacoes').html(data);
                    p._habilitaBotoesConsulta();
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        $(AppTransacoes.objectId + ' #cadastrarTransacoes').click(function () {
            p._loadFormTransacoes();
        });

        $(AppTransacoes.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppTransacoes.objectId + ' #pesquisarTransacoes').submit(function () {
            p._loadConsTransacoes();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppTransacoes.objectId + ' .btnEditar').click(function () {
            p._loadFormTransacoes($(this).attr('id'));
        });

        $(AppTransacoes.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'transacoes/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadFormTransacoes();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsTransacoes = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppTransacoes.objectId + ' #pesquisarTransacoes');
        var table = $(AppTransacoes.objectId + ' #gridTransacoes');
        var url = baseUrl + 'transacoes/index';

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

    p._loadFormTransacoes = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppTransacoes.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'transacoes/add' : 'transacoes/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadFormTransacoes();
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppTransacoes = new AppTransacoes;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
