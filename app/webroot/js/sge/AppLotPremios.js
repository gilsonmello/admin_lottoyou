(function (namespace, $) {
    "use strict";

    var AppLotPremios = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLotPremios.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLotPremios.objectId = '#AppLotPremios';
    AppLotPremios.modalFormId = '#nivel3';
    AppLotPremios.controller = 'lotPremios';
    AppLotPremios.model = 'LotPremio';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLotPremios.objectId));
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
        $(document).on('click', AppLotPremios.objectId+' .pagination a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    window.materialadmin.AppNavigation.carregando($('#gridLotPremios'));
                },
                success: function (data) {
                    $('#gridLotPremios').html(data);
                    p._habilitaBotoesConsulta();
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        $(AppLotPremios.objectId + ' #cadastrarLotPremios').click(function () {
            p._loadFormLotPremios();
        });

        $(AppLotPremios.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLotPremios.objectId + ' #pesquisarLotPremios').submit(function () {
            p._loadConsLotPremios();
            return false;
        });
    };

    
    p._habilitaBotoesConsulta = function () {
        $(AppLotPremios.objectId + ' .btnEditar').click(function () {
            p._loadFormLotPremios($(this).attr('id'));
        });

        $(AppLotPremios.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'lotPremios/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLotPremios();
            });
        });
    };

    
    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLotPremios = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLotPremios.objectId + ' #pesquisarLotPremios');
        var table = $(AppLotPremios.objectId + ' #gridLotPremios');
        var url = baseUrl + 'lotPremios/index';

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

    p._loadFormLotPremios = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLotPremios.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'lotPremios/add' : 'lotPremios/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLotPremios();
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLotPremios = new AppLotPremios;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
