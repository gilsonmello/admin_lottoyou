(function(namespace, $) {
    "use strict";

    var AppModulos = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppModulos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppModulos.objectId = '#AppModulos';
    AppModulos.modalFormId = '#nivel3';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        p._habilitaEventos();
        p._habilitaBotoesConsulta();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaEventos = function() {
        $(AppModulos.objectId+' #cadastrarModulo').click(function() {
            p._loadFormModulo();
        });

        $(AppModulos.objectId+' #pesquisarModulo').submit(function() {
            p._loadConsModulo();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function() {
        $(AppModulos.objectId+' .btnClonar').click(function() {
            p._loadFormModulo($(this).attr('id'), true);
        });

        $(AppModulos.objectId+' .btnEditar').click(function() {
            p._loadFormModulo($(this).attr('id'));
        });

        $(AppModulos.objectId+' .btnDeletar').click(function() {
            var url = baseUrl+'modulos/delete/'+$(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function(){
                p._loadConsModulo();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsModulo = function() {
        // INSTANCIA VARIÁREIS
        var form = $(AppModulos.objectId+' #pesquisarModulo');
        var table = $(AppModulos.objectId+' #gridModulos');
        var url = baseUrl + 'modulos/index/1';

        window.materialadmin.AppNavigation.carregando(table);

        $.post(url, form.serialize(), function(html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                table.html($(html).find('#' + table.attr('id') + ' >'));

                // HABILITA BOTÕES DA CONSULTA
                p._habilitaBotoesConsulta();
            }
        }, 'html');
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormModulo = function(id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppModulos.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'modulos/add' : 'modulos/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '500px', function() {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()){
                    p._loadConsModulo();
                }
            });
        });
    };
    
    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppModulos = new AppModulos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
