(function (namespace, $) {
    "use strict";

    var AppLeaPackages = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLeaPackages.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLeaPackages.objectId = '#AppLeaPackages';
    AppLeaPackages.modalFormId = '#nivel2';
    AppLeaPackages.controller = 'leaPackages';
    AppLeaPackages.model = 'League';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLeaPackages.objectId));
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
        var grid = $('#gridLeaPackages');
        $(AppLeaPackages.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppLeaPackages.objectId+' .pagination a').off('click');
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

        $(AppLeaPackages.objectId + ' #cadastrarLeaPackages').click(function () {
            p._loadFormLeagues();
        });

        $(AppLeaPackages.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLeaPackages.objectId + ' #pesquisarLeaPackages').submit(function () {
            p._loadConsLeagues();
            return false;
        });

    };

    p._habilitaBotoesConsulta = function () {
        $(AppLeaPackages.objectId + ' .btnEditar').click(function () {
            p._loadFormLeagues($(this).attr('id'));
        });
        $(AppLeaPackages.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'leaPackages/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLeagues();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLeagues = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLeaPackages.objectId + ' #pesquisarLeaPackages');
        var table = $(AppLeaPackages.objectId + ' #gridLeaPackages');
        var url = baseUrl + 'leaPackages/index';

        window.materialadmin.AppNavigation.carregando(table);

        $.get(url, form.serialize(), function (html, textStatus, jqXHR) {
            if (jqXHR.status === 200) {
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

    p._loadFormLeagues = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLeaPackages.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'leaPackages/add' : 'leaPackages/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLeagues();
                }
            });
        }, undefined, true);
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLeaPackages = new AppLeaPackages();
}(this.materialadmin, window.jQuery)); // pass in (namespace, jQuery):
