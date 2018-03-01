(function (namespace, $) {
    "use strict";

    var AppSocJogos = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppSocJogos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppSocJogos.objectId = '#AppSocJogos';
    AppSocJogos.modalFormId = '#nivel2';
    AppSocJogos.controller = 'socJogos';
    AppSocJogos.model = 'SocJogo';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppSocJogos.objectId));
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

    p._habilitaEventos = function () {
        $('#cadastrarSocJogo').click(function () {
            p._loadFormSocJogo();
        });

        $(AppSocJogos.objectId + ' .jogarCategoria').click(function () {
            p._loadListSocJogos($(this).attr('id'));
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppSocJogos.objectId + ' .btnApostar').click(function () {
            p._loadLista($(this).attr('id'));
        });

        $(AppSocJogos.objectId + ' .btnEdit').click(function () {
            p._loadFormSocJogo($(this).attr('id'));
        });

        $(AppSocJogos.objectId + ' .btnMeuJogo').click(function () {
            p._loadListaMeuJogo($(this).attr('id'), $(this).attr('user_id'));
        });

        $(AppSocJogos.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'socJogos/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsSocJogo();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsSocJogo = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppSocJogos.objectId + ' #pesquisarSocJogo');
        var table = $(AppSocJogos.objectId + ' #gridSocJogos');
        var url = baseUrl + 'socJogos/index';

        window.materialadmin.AppNavigation.carregando(table);

        $.post(url, form.serialize(), function (html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                table.html($(html).find('#' + table.attr('id') + ' >'));

                // HABILITA BOTÕES DA CONSULTA
                p._habilitaBotoesConsulta();
            }
        }, 'html');
    };

    p._loadListSocJogos = function (id) {
        // INSTANCIA VARIÁREIS
//        var form = $(AppSocJogos.objectId + ' #pesquisarSocJogo');
        var table = $(AppSocJogos.objectId + ' #gridSocJogos');
        var url = baseUrl + 'socJogos/index';
        table.css({'display': 'block'});
        $('#divCategoria').css({'display': 'none'});
        window.materialadmin.AppNavigation.carregando(table);

        $.post(url, {id: id}, function (html, textStatus, jqXHR) {
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

    p._loadFormSocJogo = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocJogos.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'socJogos/add' : 'socJogos/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '60%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsSocJogo();
                }
            });

            $('#btnClonar').click(function () {
                var divClone = $('#divClone').clone();
                var qtd = $('.card-lista').length;
                var qtdTotal = (qtd + 1);

                divClone.attr('id', 'card-' + qtdTotal);
                divClone.css('display', 'block');
                divClone.find('input#SocJogoData').attr('name', 'data[SocJogo][' + qtdTotal + '][data]').setMask({mask: '99/99/9999', autoTab: false});
//                divClone.find('input#SocJogoData').datepicker();
//                divClone.find('input#SocJogoData').datepicker({
//                    dateFormat: 'dd/mm/yy',
//                });
                divClone.find('input#SocJogoHora').attr('name', 'data[SocJogo][' + qtdTotal + '][hora]').setMask({mask: '99:99', autoTab: false});
                divClone.find('input#SocJogoLocal').attr('name', 'data[SocJogo][' + qtdTotal + '][local]');

                divClone.find('select#SocJogoGelClubeCasaId').attr('name', 'data[SocJogo][' + qtdTotal + '][gel_clube_casa_id]');
                divClone.find('select#SocJogoGelClubeForaId').attr('name', 'data[SocJogo][' + qtdTotal + '][gel_clube_fora_id]');
                $('#card-1').append(divClone);
                divClone.find('select').addClass('chosen');
                divClone.find('select.chosen').chosen();
            });
        });
    };

    p._loadLista = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocJogos.modalFormId);
        var url = 'socJogos/lista/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '50%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
//                    p._loadConsSocJogo();
                }
            });

        });
    };

    p._loadListaMeuJogo = function (id, user_id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocJogos.modalFormId);
        var url = 'socJogos/lista/' + id + '/' + user_id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '50%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
//                    p._loadConsSocJogo();
                }
            });

        });
    };

    p._loadApostarSocJogo = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocJogos.modalFormId);
        var url = 'socJogos/apostar';

        window.materialadmin.AppForm.loadModal(modalObject, url, '50%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsSocJogo();
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppSocJogos = new AppSocJogos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
