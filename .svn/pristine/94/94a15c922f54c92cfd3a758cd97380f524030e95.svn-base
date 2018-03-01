(function(namespace, $) {
    "use strict";

    var AppRestrito = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppRestrito.prototype;    

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRestrito.objectId = '#AppRestrito';
    AppRestrito.modalFormId = '#nivel1';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        p._habilitaEventos();
        p._habilitaEventosModal();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaEventos = function() {
        // CARREGA FUNCIONALIDADE
        $(AppRestrito.objectId+' #cadastrarFuncionalidade').off();
        $(AppRestrito.objectId+' #cadastrarFuncionalidade').on('click',function() {
            // FECHA MODALS
            $('.modal').modal('hide');

            // CARREGA FUNCIONILIDADE
            p._loadConsRestrito();
        });

        $(AppRestrito.objectId + ' #voltar').click(function() {
            window.materialadmin.AppSisConfiguracoes.carregarCadastros();
        });
    };

    p._habilitaEventosModal = function() {
        // ATUALIZA PERMISSÕES
        $(AppRestrito.objectId+' #addPermissoes').on('click',function() {
            p._loadConsPermissoes();
        });

        // CARREGA ADD FUNCIONALIDADES
        $(AppRestrito.objectId+' #addFuncionalidades').on('click',function() {
            p._loadFormFuncionalidade();
        });

        // CARREGA EDIT FUNCIONALIDADES
        $(AppRestrito.objectId+' .editFuncionalidades').on('click',function() {
            p._loadFormFuncionalidade($(this).attr('id'));
        });

        // CARREGA DELETE FUNCIONALIDADES
        $(AppRestrito.objectId+' .delFuncionalidades').click(function() {
            var url = baseUrl+'funcionalidades/delete/'+$(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function(){
                p._loadConsRestrito();
            });
        });

        // CARREGA EDIT MÓDULOS
        $(AppRestrito.objectId+' .editModulos').on('click',function() {
            p._loadFormModulo($(this).attr('id'));
        });

        // CARREGA LISTA MÓDULOS
        $(AppRestrito.objectId+' #listModulos').on('click',function() {
            p._loadConsModulos();
        });

        // EXIBE O LOGIN
        $(AppRestrito.objectId+' #lock').on('click',function() {
            p._loadLogin();
        });
    };

    // =========================================================================
    // CARREGA CONSULTAS
    // =========================================================================

    p._loadConsRestrito = function() {
        // INSTANCIA VARIÁREIS
        var targetUrl = 'users/restrict/1';
        var modalObject = $('#nivel1');

        if (typeof $('body #content #AppRestrito') != 'undefined'){
            window.materialadmin.AppForm.loadModal(modalObject, targetUrl, '840px', function() {
                /* SCRIPTS QUE SERÃO EXECUTADOS QUANDO PÁGINA FOR CARREGADA */
                window.materialadmin.AppRestrito.initialize();
            });  
        } else {
            var gridObject = $(AppRestrito.objectId+' #gridFuncionalidades');

            window.materialadmin.AppForm.loadGrid(gridObject, targetUrl, function(){
                /* SCRIPTS QUE SERÃO EXECUTADOS QUANDO PÁGINA FOR CARREGADA */
                window.materialadmin.AppRestrito.initialize();
            });
        }
    };

    p._loadConsPermissoes = function() {
        // INSTANCIA VARIÁREIS
        var targetUrl = 'permissions/add';
        var modalObject = $('#nivel2');

        window.materialadmin.AppForm.loadModal(modalObject, targetUrl, '600px', function() {
            /* SCRIPTS QUE SERÃO EXECUTADOS QUANDO PÁGINA FOR CARREGADA */
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                p._loadConsRestrito();
            });
        });
    };

    p._loadConsModulos = function() {
        // INSTANCIA VARIÁREIS
        var targetUrl = 'modulos/index/1';
        var modalObject = $('#nivel2');

        window.materialadmin.AppForm.loadModal(modalObject, targetUrl, '600px', function() {
           window.materialadmin.App.load('AppModulos');
            /* SCRIPTS QUE SERÃO EXECUTADOS QUANDO PÁGINA FOR CARREGADA */
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                p._loadConsRestrito();
            });

//            //window.materialadmin.App.initialize();
//            window.materialadmin.AppVendor.initialize();
//            window.materialadmin.Demo.initialize();
//            window.materialadmin.AppModulos.initialize();
        });
    };

    p._loadConsGrupos = function() {
        // INSTANCIA VARIÁREIS
        var targetUrl = 'groups/index/1';
        var modalObject = $('#nivel2');

        window.materialadmin.AppForm.loadModal(modalObject, targetUrl, '600px', function() {
            /* SCRIPTS QUE SERÃO EXECUTADOS QUANDO PÁGINA FOR CARREGADA */
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                p._loadConsRestrito();
            });

            //window.materialadmin.App.initialize();
            window.materialadmin.AppVendor.initialize();
            window.materialadmin.Demo.initialize();
            window.materialadmin.AppGrupos.initialize();
        });
    };

    p._loadLogin = function() {
        // INSTANCIA VARIÁREIS
        var targetUrl = 'users/lock';
        var modalObject = $('#nivel2');

        window.materialadmin.AppForm.loadModal(modalObject, targetUrl, '400px', function() {
            /* SCRIPTS QUE SERÃO EXECUTADOS QUANDO PÁGINA FOR CARREGADA */
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                p._loadConsRestrito();
            });
        });
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormFuncionalidade = function(id, clonar) {
        // INSTANCIA VARIÁREIS
        var modalObject = $('#nivel2');
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var targetUrl = (typeof id === 'undefined') ? 'funcionalidades/add' : 'funcionalidades/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, targetUrl, '600px', function() {
            /* SCRIPTS QUE SERÃO EXECUTADOS QUANDO PÁGINA FOR CARREGADA */
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()){
                    p._loadConsRestrito();
                }
            });
        });
    };

    p._loadFormModulo = function(id, clonar) {
        // INSTANCIA VARIÁREIS
        var modalObject = $('#nivel2');
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var targetUrl = (typeof id === 'undefined') ? 'modulos/add' : 'modulos/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, targetUrl, '600px', function() {
            /* SCRIPTS QUE SERÃO EXECUTADOS QUANDO PÁGINA FOR CARREGADA */
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()){
                    p._loadConsRestrito();
                }
            });
        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppRestrito = new AppRestrito;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
