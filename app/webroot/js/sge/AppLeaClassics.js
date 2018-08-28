(function (namespace, $) {
    "use strict";

    var AppLeaClassics = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLeaClassics.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLeaClassics.objectId = '#AppLeaClassics';
    AppLeaClassics.modalFormId = '#nivel2';
    AppLeaClassics.controller = 'leaClassics';
    AppLeaClassics.model = 'LeaClassic';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLeaClassics.objectId));
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
        var grid = $('#gridLeaClassics');
        $(AppLeaClassics.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppLeaClassics.objectId+' .pagination a').off('click');
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

        $(AppLeaClassics.objectId + ' #cadastrarLeaClassics').click(function () {
            p._loadFormLeaClassics();
        });

        $(AppLeaClassics.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLeaClassics.objectId + ' #pesquisarLeaClassics').submit(function () {
            p._loadConsLeaClassics();
            return false;
        });

    };

    p._habilitaBotoesConsulta = function () {
        $(AppLeaClassics.objectId + ' .btnEditar').click(function () {
            p._loadFormLeaClassics($(this).attr('id'));
        });
        $(AppLeaClassics.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'leaClassics/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLeaClassics();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLeaClassics = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLeaClassics.objectId + ' #pesquisarLeaClassics');
        var table = $(AppLeaClassics.objectId + ' #gridLeaClassics');
        var url = baseUrl + 'leaClassics/index';

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

    p._loadFormLeaClassics = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLeaClassics.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'leaClassics/add' : 'leaClassics/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLeaClassics();
                }
            });
        }, undefined, true);
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLeaClassics = new AppLeaClassics();
}(this.materialadmin, window.jQuery)); // pass in (namespace, jQuery):
