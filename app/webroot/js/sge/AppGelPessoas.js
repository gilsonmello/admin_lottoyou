(function(namespace, $) {
    "use strict";

    var AppGelPessoas = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppGelPessoas.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppGelPessoas.objectId = '#AppGelPessoas';
    AppGelPessoas.modalFormId = '#nivel3';
    AppGelPessoas.controller = 'gelPessoas';
    AppGelPessoas.model = 'GelPessoa';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppGelPessoas.objectId));
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
        $(AppGelPessoas.objectId+' #cadastrar'+AppGelPessoas.model).click(function() {
            p._loadFormGelPessoas();
        });

        $(AppGelPessoas.objectId + ' #voltar').click(function() {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppGelPessoas.objectId+' #pesquisar'+AppGelPessoas.model).submit(function() {
            p._loadConsGelPessoas();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function() {
        $(AppGelPessoas.objectId+' .btnClonar').click(function() {
            p._loadFormGelPessoas($(this).attr('id'), true);
        });

        $(AppGelPessoas.objectId+' .btnEditar').click(function() {
            p._loadFormGelPessoas($(this).attr('id'));
        });

        $(AppGelPessoas.objectId+' .btnDeletar').click(function() {
            var url = baseUrl+AppGelPessoas.controller+'/delete/'+$(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function(){
                p._loadConsGelPessoas();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsGelPessoas = function() {
        // INSTANCIA VARIÁREIS
        var form = $(AppGelPessoas.objectId+' #pesquisar'+AppGelPessoas.model);
        var table = $(AppGelPessoas.objectId+' #grid'+AppGelPessoas.model);
        var url = baseUrl + AppGelPessoas.controller + '/index';

        window.materialadmin.AppNavigation.carregando(table);

        $.post(url, form.serialize(), function(html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                table.html($(html).find('#' + table.attr('id') + ' >'));

                // CARREGA DEPENDÊNCIAS
                window.materialadmin.AppVendor.initialize();

                // HABILITA BOTÕES DA CONSULTA
                p._habilitaBotoesConsulta();
            }
        }, 'html');
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormGelPessoas = function(id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppGelPessoas.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? AppGelPessoas.controller+'/add' : AppGelPessoas.controller+'/' + action + '/' + id;
        
        var url = (typeof id !== 'function') ? 
                  (typeof id === 'undefined') ? AppGelPessoas.controller+'/add' : AppGelPessoas.controller+'/' + action + '/' + id : 
                  AppGelPessoas.controller+'/add';

        window.materialadmin.AppForm.loadModal(modalObject, url, '600px', function() {

            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()){
                    p._loadConsGelPessoas();

                    if ((typeof id === 'function')){ id(); }
                }
            });

            $(AppGelPessoas.modalFormId+' .tipo_pessoa input').click(function(){
                var pj = $('.pj');
                var second = $('.second');
                var nome = $(AppGelPessoas.modalFormId+' label[for=GelPessoaNome]');
                var apelido = $(AppGelPessoas.modalFormId+' label[for=GelPessoaApelido]');
                var cpfCnpj = $(AppGelPessoas.modalFormId+' label[for=GelPessoaCpfCnpj]');
                var cpfCnpjField = $(AppGelPessoas.modalFormId+' #GelPessoaCpfCnpj');

                switch ($(this).val()) {
                    case 'PF':
                        pj.addClass('hide');
                        second.css('margin-top','20px');
                        nome.html('Nome<em style="color:red;">*</em>');
                        apelido.html('Apelido');
                        cpfCnpj.html('CPF');
                        cpfCnpjField.removeClass('cnpj').addClass('cpf');
                        cpfCnpjField.setMask({mask:'999.999.999-99', autoTab:false});
                        break;
                    case 'PJ':
                        pj.removeClass('hide');
                        second.css('margin-top','0');
                        nome.html('Razão Social<em style="color:red;">*</em>');
                        apelido.html('Nome Fantasia');
                        cpfCnpj.html('CNPJ');
                        cpfCnpjField.removeClass('cpf').addClass('cnpj');
                        cpfCnpjField.setMask({mask:'99.999.999/9999-99', autoTab:false});
                        break;
                }
            });

            $(AppGelPessoas.modalFormId+' .tipo_pessoa input:checked').click();

            $(AppGelPessoas.modalFormId+' #GelPessoaGelEstadoId').change(function(){
                var estado = $(this);
                var cidade = $(AppGelPessoas.modalFormId+' #GelPessoaGelCidadeId');

                var controller = 'gelCidades';
                var selectObject = cidade;
                var params = {'gel_estado_id':estado.val(),'active':1};

                window.materialadmin.AppForm.updateSelectField(controller, selectObject, params);
            });
        });
    };
    
    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppGelPessoas = new AppGelPessoas;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
