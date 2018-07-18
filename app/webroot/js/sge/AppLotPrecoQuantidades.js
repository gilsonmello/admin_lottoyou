(function (namespace, $) {
    "use strict";

    var AppLotPrecoQuantidades = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLotPrecoQuantidades.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLotPrecoQuantidades.objectId = '#AppLotPrecoQuantidades';
    AppLotPrecoQuantidades.modalFormId = '#nivel3';
    AppLotPrecoQuantidades.controller = 'lotPrecoQuantidades';
    AppLotPrecoQuantidades.model = 'LotPrecoQuantidade';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLotPrecoQuantidades.objectId));
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
        $(document).on('click', AppLotPrecoQuantidades.objectId+' .pagination a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    window.materialadmin.AppNavigation.carregando($('#gridLotPrecoQuantidades'));
                },
                success: function (data) {
                    $('#gridLotPrecoQuantidades').html(data);
                    p._habilitaBotoesConsulta();
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        $(AppLotPrecoQuantidades.objectId + ' #cadastrarLotPrecoQuantidades').click(function () {
            p._loadFormLotPrecoQuantidades();
        });

        $(AppLotPrecoQuantidades.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLotPrecoQuantidades.objectId + ' #pesquisarLotPrecoQuantidades').submit(function () {
            p._loadConsLotPrecoQuantidades();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppLotPrecoQuantidades.objectId + ' .btnEditar').click(function () {
            p._loadFormLotPrecoQuantidades($(this).attr('id'));
        });

        $(AppLotPrecoQuantidades.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'lotPrecoQuantidades/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLotPrecoQuantidades();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLotPrecoQuantidades = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLotPrecoQuantidades.objectId + ' #pesquisarPrecoQuantidades');
        var table = $(AppLotPrecoQuantidades.objectId + ' #gridLotPrecoQuantidades');
        var url = baseUrl + 'lotPrecoQuantidades/index';

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

    p._loadFormLotPrecoQuantidades = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLotPrecoQuantidades.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'lotPrecoQuantidades/add' : 'lotPrecoQuantidades/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLotPrecoQuantidades();
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLotPrecoQuantidades = new AppLotPrecoQuantidades;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
