(function(namespace, $) {
    "use strict";

    var AppGrupos = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppGrupos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppGrupos.objectId = '#AppGrupos';
    AppGrupos.modalFormId = '#nivel3';

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
        $(AppGrupos.objectId+' #cadastrarGrupo').click(function() {
            p._loadFormGrupo();
        });

        $(AppGrupos.objectId+' #pesquisarGrupo').submit(function() {
            p._loadConsGrupo();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function() {
        $(AppGrupos.objectId+' .btnClonar').click(function() {
            p._loadFormGrupo($(this).attr('id'), true);
        });

        $(AppGrupos.objectId+' .btnEditar').click(function() {
            p._loadFormGrupo($(this).attr('id'));
        });

        $(AppGrupos.objectId+' .btnDeletar').click(function() {
            var url = baseUrl+'groups/delete/'+$(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function(){
                p._loadConsGrupo();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsGrupo = function() {
        // INSTANCIA VARIÁREIS
        var form = $(AppGrupos.objectId+' #pesquisarGrupo');
        var table = $(AppGrupos.objectId+' #gridGrupos');
        var url = baseUrl + 'groups/index/1';

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

    p._loadFormGrupo = function(id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppGrupos.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'groups/add' : 'groups/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(form, url, '500px', function() {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()){
                    p._loadConsGrupo();
                }
            });
        });
    };
    
    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppGrupos = new AppGrupos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
