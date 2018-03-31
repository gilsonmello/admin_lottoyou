(function(namespace, $, d, s, id) {
    "use strict";

    var AppSocBoloes = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppSocBoloes.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppSocBoloes.objectId = '#AppSocBoloes';
    AppSocBoloes.modalFormId = '#nivel3';
    AppSocBoloes.controller = 'socBoloes';
    AppSocBoloes.model = 'SocBolao';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        // CARREGA DEPENDÊNCIAS
        window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppSocBoloes.objectId));
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
        $(AppSocBoloes.objectId + ' #cadastrarSocBolao').click(function() {
            p._loadFormSocBolao();
        });

        $(AppSocBoloes.objectId + ' #voltar').click(function() {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppSocBoloes.objectId + ' #pesquisarSocBolao').submit(function() {
            p._loadConsSocBolao();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function() {
        $(AppSocBoloes.objectId + ' .btnEditar').click(function() {
            p._loadFormSocBolao($(this).attr('id'));
        });

        $(AppSocBoloes.objectId + ' .btnDeletar').click(function() {
            var res;
            res = confirm("Deseja realmente excluir o item?");
            if (res) {
                var url = baseUrl + 'socBoloes/delete/' + $(this).attr('id');
                window.materialadmin.AppGrid.delete(url, function() {
                    p._loadConsSocBolao();
                });
            }
        });

        $(AppSocBoloes.objectId + ' .btnComprar').click(function() {
            p._loadViewSocBolao($(this).attr('id'));
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsSocBolao = function() {
        // INSTANCIA VARIÁREIS
        var form = $(AppSocBoloes.objectId + ' #pesquisarSocBolao');
        var table = $(AppSocBoloes.objectId + ' #gridSocBoloes');
        var url = baseUrl + 'socBoloes/index';

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

    p._loadFormSocBolao = function(id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocBoloes.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'socBoloes/add' : 'socBoloes/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function() {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsSocBolao();
                }
            });

        });
    };

    p._loadViewSocBolao = function(id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocBoloes.modalFormId);
        var url = 'socBoloes/view/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '700px', function() {

            modalObject.find('button[type=submit]').html('ENVIAR SOLICITAÇÃO');

            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsSocBolao();
                }
            });

        });
    };

//    var js, fjs = d.getElementsByTagName(s)[0];
//    if (d.getElementById(id))
//        return;
//    js = d.createElement(s);
//    js.id = id;
//    js.src = "//connect.facebok.net/pt_BR/sdk.js#xfbml=1&version=v2.8&appId=1194020284000011";
//    fjs.parentNode.insertBefore(js, fjs);

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppSocBoloes = new AppSocBoloes;
}(this.materialadmin, jQuery, document, 'script', 'facebok-jssdk')); // pass in (namespace, jQuery):