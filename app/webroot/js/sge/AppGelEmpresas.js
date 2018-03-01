(function(namespace, $) {
    "use strict";

    var AppGelEmpresas = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppGelEmpresas.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppGelEmpresas.objectId = '#AppGelEmpresas';
    AppGelEmpresas.modalFormId = '#nivel3';
    AppGelEmpresas.controller = 'gelEmpresas';
    AppGelEmpresas.model = 'GelEmpresa';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        // CARREGA DEPENDÊNCIAS
        window.materialadmin.AppForm.initialize($(AppGelEmpresas.objectId));
        window.materialadmin.AppGrid.initialize();
        window.materialadmin.AppVendor.initialize();
        window.materialadmin.Demo.initialize();

        // CARREGA EVENTOS 
        p._habilitaEventos();
        p._habilitaBotoesConsulta();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaEventos = function() {
        $(AppGelEmpresas.objectId+' #cadastrar'+AppGelEmpresas.model).click(function() {
            p._loadFormGelEmpresas();
        });

        $(AppGelEmpresas.objectId + ' #voltar').click(function() {
            window.materialadmin.App.load('AppGelCadastros');
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppGelEmpresas.objectId+' #pesquisar'+AppGelEmpresas.model).submit(function() {
            p._loadConsGelEmpresas();
            return false;
        });

        $(AppGelEmpresas.objectId+' .list button').click(function() {
            var id = $(this).attr('id');
            var url = baseUrl + AppGelEmpresas.controller + '/select';

            $.post(url, {id: id}, function(json) {
                if (json.error == 0){
                    toastr.success('Mudança de empresa realizada com sucesso');
                    $('#header #selectedEmpresa').html(json.empresa);
                    $('a[href*=gelDashboard]').click();
                    $('#AppGelEmpresas .modal-footer button[type=button]').click();
                } else {
                    toastr.error('Não possi possível entrar na empresa selecionada');
                }
            },'json');
        });
    };

    p._habilitaBotoesConsulta = function() {
        $(AppGelEmpresas.objectId+' .btnClonar').click(function() {
            p._loadFormGelEmpresas($(this).attr('id'), true);
        });

        $(AppGelEmpresas.objectId+' .btnEditar').click(function() {
            p._loadFormGelEmpresas($(this).attr('id'));
        });

        $(AppGelEmpresas.objectId+' .btnDeletar').click(function() {
            var url = baseUrl+AppGelEmpresas.controller+'/delete/'+$(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function(){
                p._loadConsGelEmpresas();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsGelEmpresas = function() {
        // INSTANCIA VARIÁREIS
        var form = $(AppGelEmpresas.objectId+' #pesquisar'+AppGelEmpresas.model);
        var table = $(AppGelEmpresas.objectId+' #grid'+AppGelEmpresas.model);
        var url = baseUrl + AppGelEmpresas.controller + '/index';

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

    p._loadFormGelEmpresas = function(id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppGelEmpresas.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? AppGelEmpresas.controller+'/add' : AppGelEmpresas.controller+'/' + action + '/' + id;
        
        window.materialadmin.AppForm.loadModal(modalObject, url, '600px', function() {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()){
                    p._loadConsGelEmpresas();
                }
            });

            if(modalObject.find('#GelEmpresaNome').length == 0){
                modalObject.find('button[type=submit]').attr('disabled', 'disabled');
            }
        });
    };
    
    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppGelEmpresas = new AppGelEmpresas;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
