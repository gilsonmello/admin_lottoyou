(function (namespace, $) {
    "use strict";

    var AppLeaCupAwards = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLeaCupAwards.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLeaCupAwards.objectId = '#AppLeaCupAwards';
    AppLeaCupAwards.modalFormId = '#nivel2';
    AppLeaCupAwards.controller = 'leaCupAwards';
    AppLeaCupAwards.model = 'LeaCupAward';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLeaCupAwards.objectId));
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
        var grid = $('#gridLeaCupAwards');
        $(AppLeaCupAwards.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppLeaCupAwards.objectId+' .pagination a').off('click');
                    window.materialadmin.AppNavigation.carregando(grid);
                },
                success: function (data) {
                    grid.html(data);
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

        $(AppLeaCupAwards.objectId + ' #cadastrarLeaCupAwards').click(function () {
            p._loadFormLeaCupAwards();
        });

        $(AppLeaCupAwards.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLeaCupAwards.objectId + ' #pesquisarLeaCupAwards').submit(function () {
            p._loadConsLeaCupAwards();
            return false;
        });

    };

    p._habilitaBotoesConsulta = function () {
        $(AppLeaCupAwards.objectId + ' .btnEditar').click(function () {
            p._loadFormLeaCupAwards($(this).attr('id'));
        });
        $(AppLeaCupAwards.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'leaCupAwards/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLeaCupAwards();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLeaCupAwards = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLeaCupAwards.objectId + ' #pesquisarLeaCupAwards');
        var table = $(AppLeaCupAwards.objectId + ' #gridLeaCupAwards');
        var url = baseUrl + 'leaCupAwards/index';

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

    p._loadFormLeaCupAwards = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLeaCupAwards.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'leaCupAwards/add' : 'leaCupAwards/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLeaCupAwards();
                }
            });
        }, undefined, true);
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLeaCupAwards = new AppLeaCupAwards();
}(this.materialadmin, window.jQuery)); // pass in (namespace, jQuery):
