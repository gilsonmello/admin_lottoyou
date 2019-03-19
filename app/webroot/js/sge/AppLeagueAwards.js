(function (namespace, $) {
    "use strict";

    var AppLeagueAwards = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLeagueAwards.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLeagueAwards.objectId = '#AppLeagueAwards';
    AppLeagueAwards.modalFormId = '#nivel2';
    AppLeagueAwards.controller = 'leagueAwards';
    AppLeagueAwards.model = 'LeagueAward';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLeagueAwards.objectId));
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
        var grid = $('#gridLeagueAwards');
        $(AppLeagueAwards.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppLeagueAwards.objectId+' .pagination a').off('click');
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

        $(AppLeagueAwards.objectId + ' #cadastrarLeagueAwards').click(function () {
            p._loadFormLeagueAwards();
        });

        $(AppLeagueAwards.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLeagueAwards.objectId + ' #pesquisarLeagueAwards').submit(function () {
            p._loadConsLeagueAwards();
            return false;
        });

    };

    p._habilitaBotoesConsulta = function () {
        $(AppLeagueAwards.objectId + ' .btnEditar').click(function () {
            p._loadFormLeagueAwards($(this).attr('id'));
        });
        $(AppLeagueAwards.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'leagueAwards/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLeagueAwards();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLeagueAwards = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLeagueAwards.objectId + ' #pesquisarLeagueAwards');
        var table = $(AppLeagueAwards.objectId + ' #gridLeagueAwards');
        var url = baseUrl + 'leagueAwards/index';

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

    p._loadFormLeagueAwards = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLeagueAwards.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'leagueAwards/add' : 'leagueAwards/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLeagueAwards();
                }
            });
        }, undefined, true);
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLeagueAwards = new AppLeagueAwards();
}(this.materialadmin, window.jQuery)); // pass in (namespace, jQuery):
