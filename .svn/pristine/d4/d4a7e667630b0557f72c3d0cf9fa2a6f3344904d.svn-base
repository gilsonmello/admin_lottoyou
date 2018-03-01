(function (namespace, $) {
    "use strict";

    var AppRasLotes = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRasLotes.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRasLotes.objectId = '#AppRasLotes';
    AppRasLotes.modalFormId = '#nivel3';
    AppRasLotes.controller = 'rasLotes';
    AppRasLotes.model = 'RasLote';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppRasLotes.objectId));
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
        $(AppRasLotes.objectId + ' #cadastrarRasLote').click(function () {
            p._loadFormRasLote();
        });

        $(AppRasLotes.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppRasLotes.objectId + ' #pesquisarRasLote').submit(function () {
            p._loadConsRasLote();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppRasLotes.objectId + ' .btnEditar').click(function () {
            p._loadFormRasLote($(this).attr('id'));
        });

        $(AppRasLotes.objectId + ' .btnGerarRaspadinha').click(function () {
            p._loadGerarLoteRaspadinha($(this).attr('id'));
        });

        $(AppRasLotes.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'rasLotes/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsRasLote();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsRasLote = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppRasLotes.objectId + ' #pesquisarRasLote');
        var table = $(AppRasLotes.objectId + ' #gridRasLotes');
        var url = baseUrl + 'rasLotes/index';

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

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormRasLote = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppRasLotes.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'rasLotes/add' : 'rasLotes/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsRasLote();
                }
            });

        });
    };

    p._loadGerarLoteRaspadinha = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var idAux = id;
        var modalObject = $(AppRasLotes.modalFormId);
        var url = 'rasLotes/addRaspadinhas/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '60%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsRasLote();
                }
            });
            $("#btnSalvar").click(function () {
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: $('#RasLoteAddRaspadinhasForm').serialize(),
                    beforeSend: function () {
                        if ($('#RasLoteQtdPremiadas').val() == '') {
                            alert('Campos Obrigatórios');
                            $('#RasLoteQtdPremiadas').focus();
                            return false;
                        }

                        if ($('#RasLoteValorPremiado').val() == '') {
                            alert('campos Obrigatórios');
                            $('#RasLoteValorPremiado').focus();
                            return false;
                        }
                    },
                    success: function (data) {
                        if (data.error == 0) {
                            toastr.success(data.msg);
                            p._loadGerarLoteRaspadinha(idAux);
                        } else {
                            toastr.error(data.msg);
                        }
                    },
                });
            });

            $("#btnGerarRaspadinhas").click(function () {
                var url2 = baseURL + 'rasLotes/addRaspadinhas'
                var raspadinhas_restantes = $(this).attr('raspadinhas_restantes');
                var lote_id = $('#RasLoteLoteId').val();
                var user_id = $('#RasLoteUserId').val();
                var tema_id = $('#RasLoteTemaId').val();
                var auto = 1;
                if (raspadinhas_restantes > 0) {
                    if (confirm("Confirma a Criação das raspadinhas restantes SEM PRÊMIO?")) {
                        $.ajax({
                            url: url2,
                            type: "POST",
                            dataType: "json",
                            data: {raspadinhas_restantes: raspadinhas_restantes, lote_id: lote_id, user_id: user_id, tema_id: tema_id, auto: auto},
                            success: function (data) {
                                if (data.error == 0) {
                                    toastr.success(data.msg);
                                    p._loadGerarLoteRaspadinha(idAux);
                                } else {
                                    toastr.error(data.msg);
                                }
                            },
                        });
                    }
                } else {
                    toastr.error('Não é possivel gerar mais raspadinhas. Limite de raspadinhas alcançado!');
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppRasLotes = new AppRasLotes;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
