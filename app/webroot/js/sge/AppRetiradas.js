(function (namespace, $) {
    "use strict";

    var AppRetiradas = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRetiradas.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRetiradas.objectId = '#AppRetiradas';
    AppRetiradas.modalFormId = '#nivel2';
    AppRetiradas.controller = 'retiradas';
    AppRetiradas.model = 'Contato';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppRetiradas.objectId));
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
        $(document).on('click', AppRetiradas.objectId+' .pagination a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    window.materialadmin.AppNavigation.carregando($('#gridRetiradas'));
                },
                success: function (data) {
                    $('#gridRetiradas').html(data);
                    p._habilitaBotoesConsulta();
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        $(AppRetiradas.objectId + ' #cadastrarRetiradas').click(function () {
            //p._loadFormRetiradasContato();
        });

        $(AppRetiradas.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRetiradas.objectId + ' #pesquisarRetiradas').submit(function () {
            p._loadConsRetiradas();
            return false;
        });

    };

    p._habilitaBotoesConsulta = function () {
        $(AppRetiradas.objectId + ' .btnEdit').click(function () {
            p._loadFormRetiradas($(this).attr('id'));
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsRetiradas = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppRetiradas.objectId + ' #pesquisarRetiradas');
        var table = $(AppRetiradas.objectId + ' #gridRetiradas');
        var url = baseUrl + 'retiradas/index';

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

    p._loadFormRetiradas = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppRetiradas.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'retiradas/add' : 'retiradas/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                p._loadConsRetiradas();
            });
        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppRetiradas = new AppRetiradas;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
