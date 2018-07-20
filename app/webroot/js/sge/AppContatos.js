(function (namespace, $) {
    "use strict";

    var AppContatos = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppContatos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppContatos.objectId = '#AppContatos';
    AppContatos.modalFormId = '#nivel3';
    AppContatos.controller = 'contatos';
    AppContatos.model = 'Contato';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppContatos.objectId));
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
        $(document).on('click', AppContatos.objectId+' .pagination a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    window.materialadmin.AppNavigation.carregando($('#gridContatos'));
                },
                success: function (data) {
                    $('#gridContatos').html(data);
                    p._habilitaBotoesConsulta();
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        $(AppContatos.objectId + ' #cadastrarContatos').click(function () {
            //p._loadFormContato();
        });

        $(AppContatos.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppContatos.objectId + ' #pesquisarContatos').submit(function () {
            p._loadConsContatos();
            return false;
        });

    };

    p._habilitaBotoesConsulta = function () {
        $(AppContatos.objectId + ' .btnResponder').click(function () {
            p._loadFormContatosResponder($(this).attr('id'));
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsContatos = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppContatos.objectId + ' #pesquisarContatos');
        var table = $(AppContatos.objectId + ' #gridContatos');
        var url = baseUrl + 'contatos/index';

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

    p._loadFormContatosResponder = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppContatos.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'answer';
        var url = (typeof id === 'undefined') ? 'contatos/add' : 'contatos/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                p._loadConsContatos();
            });
        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppContatos = new AppContatos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
