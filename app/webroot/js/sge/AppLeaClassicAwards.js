(function (namespace, $) {
    "use strict";

    var AppLeaClassicAwards = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLeaClassicAwards.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLeaClassicAwards.objectId = '#AppLeaClassicAwards';
    AppLeaClassicAwards.modalFormId = '#nivel2';
    AppLeaClassicAwards.controller = 'leaClassicAwards';
    AppLeaClassicAwards.model = 'LeaClassicAward';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLeaClassicAwards.objectId));
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
        var grid = $('#gridLeaClassicAwards');
        $(AppLeaClassicAwards.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppLeaClassicAwards.objectId+' .pagination a').off('click');
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

        $(AppLeaClassicAwards.objectId + ' #cadastrarLeaClassicAwards').click(function () {
            p._loadFormLeaClassicAwards();
        });

        $(AppLeaClassicAwards.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLeaClassicAwards.objectId + ' #pesquisarLeaClassicAwards').submit(function () {
            p._loadConsLeaClassicAwards();
            return false;
        });

    };

    p._habilitaBotoesConsulta = function () {
        $(AppLeaClassicAwards.objectId + ' .btnEditar').click(function () {
            p._loadFormLeaClassicAwards($(this).attr('id'));
        });
        $(AppLeaClassicAwards.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'leaClassicAwards/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLeaClassicAwards();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLeaClassicAwards = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLeaClassicAwards.objectId + ' #pesquisarLeaClassicAwards');
        var table = $(AppLeaClassicAwards.objectId + ' #gridLeaClassicAwards');
        var url = baseUrl + 'leaClassicAwards/index';

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

    p._loadFormLeaClassicAwards = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLeaClassicAwards.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'leaClassicAwards/add' : 'leaClassicAwards/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLeaClassicAwards();
                }
            });
        }, undefined, true);
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLeaClassicAwards = new AppLeaClassicAwards();
}(this.materialadmin, window.jQuery)); // pass in (namespace, jQuery):
