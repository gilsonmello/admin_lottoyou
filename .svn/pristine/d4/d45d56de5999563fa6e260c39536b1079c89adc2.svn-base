(function(namespace, $) {
    "use strict";

    var AppUsers = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppUsers.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppUsers.objectId = '#AppUsers';
    AppUsers.modalFormId = '#nivel3';
    AppUsers.controller = 'users';
    AppUsers.model = 'user';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        // INICIALIZA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppUsers.objectId));
        window.materialadmin.AppGrid.initialize();
        window.materialadmin.AppVendor.initialize();
        window.materialadmin.Demo.initialize();
        
        // INIALIZA EVENTOS DA FUNCIONALIDADE
        p._habilitaEventos();
        p._habilitaBotoesConsulta();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaEventos = function() {
        $(AppUsers.objectId + ' #cadastrarUser').click(function() {
            p._loadFormUser();
        });

        $(AppUsers.objectId + ' #voltar').click(function() {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppUsers.objectId + ' #pesquisarUser').submit(function() {
            p._loadConsUser();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function() {

        $(AppUsers.objectId + ' .btnEditar').click(function() {
            p._loadFormUser($(this).attr('id'));
        });

        $(AppUsers.objectId + ' .btnDeletar').click(function() {
            var url = baseUrl + 'users/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function() {
                p._loadConsUser();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsUser = function() {
        // INSTANCIA VARIÁREIS
        var form = $(AppUsers.objectId + ' #pesquisarUser');
        var table = $(AppUsers.objectId + ' #gridUser');
        var url = baseUrl + 'users/index';

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

    p._loadFormUser = function(id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppUsers.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'users/add' : 'users/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '500px', function() {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsUser();
                }
            });

            $('#UserAlterar').change(function() {
                if ($(this).val() == 1) {
                    $('#UserPassword2').removeAttr('readonly');
                    $('label[for=UserPassword2]').html('Nova Senha<span style="color:red;">*</span>');
                } else {
                    $('#UserPassword2').attr('readonly', 'true');
                    $('label[for=UserPassword2]').html('Nova Senha');
                    $('#UserPassword2').val('');
                }
            });
        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppUsers = new AppUsers;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
