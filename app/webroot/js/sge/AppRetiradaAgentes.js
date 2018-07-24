(function (namespace, $) {
    "use strict";

    var AppRetiradaAgentes = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRetiradaAgentes.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRetiradaAgentes.objectId = '#AppRetiradaAgentes';
    AppRetiradaAgentes.modalFormId = '#nivel2';
    AppRetiradaAgentes.controller = 'retiradaAgentes';
    AppRetiradaAgentes.model = 'Contato';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppRetiradaAgentes.objectId));
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
        $(AppRetiradaAgentes.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppRetiradaAgentes.objectId+' .pagination a').off('click');
                    window.materialadmin.AppNavigation.carregando($('#gridRetiradaAgentes'));
                },
                success: function (data) {
                    $('#gridRetiradaAgentes').html(data);
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

        $(AppRetiradaAgentes.objectId + ' #cadastrarRetiradaAgentes').click(function () {
            //p._loadFormRetiradaAgentesContato();
        });

        $(AppRetiradaAgentes.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRetiradaAgentes.objectId + ' #pesquisarRetiradaAgentes').submit(function () {
            p._loadConsRetiradaAgentes();
            return false;
        });

    };

    p._habilitaBotoesConsulta = function () {
        $(AppRetiradaAgentes.objectId + ' .btnEdit').click(function () {
            p._loadFormRetiradaAgentes($(this).attr('id'));
        });
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormRetiradaAgentes = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppRetiradaAgentes.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'retiradaAgentes/add' : 'retiradaAgentes/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                //p._loadConsRetiradaAgentes();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsRetiradaAgentes = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppRetiradaAgentes.objectId + ' #pesquisarRetiradaAgentes');
        var table = $(AppRetiradaAgentes.objectId + ' #gridRetiradaAgentes');
        var url = baseUrl + 'retiradaAgentes/index';

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

    window.materialadmin.AppRetiradaAgentes = new AppRetiradaAgentes;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
