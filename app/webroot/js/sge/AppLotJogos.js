(function (namespace, $) {
    "use strict";

    var AppLotJogos = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLotJogos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLotJogos.objectId = '#AppLotJogos';
    AppLotJogos.modalFormId = '#nivel3';
    AppLotJogos.controller = 'lotJogos';
    AppLotJogos.model = 'LotJogo';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLotJogos.objectId));
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
        $(AppLotJogos.objectId + ' #cadastrarLotJogo').click(function () {
            p._loadFormLotJogo();
        });

        $(AppLotJogos.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLotJogos.objectId + ' #pesquisarLotJogo').submit(function () {
            p._loadConsLotJogo();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppLotJogos.objectId + ' .btnResultado').click(function () {
            p._cadastrarResultado($(this).attr('id'), $(this).attr('ret'));
        });

        $(AppLotJogos.objectId + ' .btnGanhadores').click(function () {
            p._showGanhadores($(this).attr('id'));
        });

        $(AppLotJogos.objectId + ' .btnPremiar').click(function () {
            p._showPremiar($(this));
        });

        $(AppLotJogos.objectId + ' .btnEditar').click(function () {
            p._loadFormLotJogo($(this).attr('id'));
        });

        $(AppLotJogos.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'lotJogos/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLotJogo();
            });
        });
    };

    p._showPremiar = function (btn) {
        var id = btn.attr('id');
        var modalObject = $(AppLotJogos.modalFormId);
        var url = 'lotJogos/premiar/' + id;

        if(confirm('Você realmente deseja gerar as premiações?')) {
            $.ajax({
                method: 'post',
                url: url,
                beforeSend: function () {
                    btn.button('loading');
                },
                success: function (data) {
                    if (p._checkErros(data) === 0) {
                        p._loadConsLotJogo();
                    }
                    btn.button('reset');
                },
                error: function (error) {
                    btn.button('reset');
                }
            });
        }
    };

    p._checkErros = function (html) {
        // INICIA VARIÁVEIS
        var o = $(html).find('.alert');
        var error = 1;
        o.find('a').hide();

        // VERIFICA TIPO DA MENSAGEM E EXIBE MENSAGEM
        if (o.hasClass('alert-success')) {
            toastr.options.timeOut = 2000;
            toastr.success(o.html());
            error = 0;
        } else {
            toastr.options.timeOut = 7000;
            toastr.error(o.html());
        }

        return error;
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLotJogo = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLotJogos.objectId + ' #pesquisarLotJogo');
        var table = $(AppLotJogos.objectId + ' #gridLotJogos');
        var url = baseUrl + 'lotJogos/index';

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

    p._loadFormLotJogo = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLotJogos.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'lotJogos/add' : 'lotJogos/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '50%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLotJogo();
                }
            });

        });
    };

    p._showGanhadores = function (id) {
        var modalObject = $(AppLotJogos.modalFormId);
        var url = 'lotJogos/vencedores/' + id;
        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            $('.btnDetalhar').click(function () {
                var acertos = $(this).attr('acertos');
                var modalObject = $('#nivel4');
                var url = 'lotJogos/detalhar/' + id + '/' + acertos;
                window.materialadmin.AppForm.loadModal(modalObject, url, '85%', function () {
                    modalObject.off('hide.bs.modal');
                    modalObject.on('hide.bs.modal', function () {
                        
                    });

                });
            });


            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {

                }
            });

        });
    };


    //editar removido
    p._cadastrarResultado = function (id) {
        var modalObject = $(AppLotJogos.modalFormId);
        var url = (typeof i === 'undefined') ? 'lotJogosResultados/add/' + id : 'lotJogosResultados/edit/' + i;
        window.materialadmin.AppForm.loadModal(modalObject, url, '720px', function () {
            window.materialadmin.App.load('AppLotJogosResultados');

            $('.btnLotJogosPedras1').click(function () {
                window.materialadmin.AppLotJogosResultados._acaoDezenaLotJogos('qtdNumeros1', $(this).attr('id'), $(this).attr('pass'), 'D', true);
            });
            $('.btnLotJogosPedrasd1').click(function () {
                window.materialadmin.AppLotJogosResultados._acaoDezenaLotJogo2('qtdNumerosd1', $(this).attr('id'), $(this).attr('pass'), 'd', true);
            });

            $('.btnSalvarLotJogosResultados').click(function () {
                if (typeof ($('#qtdNumerosd1').val()) === 'undefined') {
                    if (($('#qtdNumeros1').val() === '0')) {
                        if (confirm('Os números informados estão corretos?')) {
                            $('.btnSalvarLotJogosResultados').button('loading');
                            $('#LotJogosResultadoAddForm').submit();
                        }
                    } else {
                        alert('Por favor, selecione ' + $('#qtdNumeros1').attr('qtdnumeros1') + ' dezenas.');
                    }
                } else {
                    if (($('#qtdNumeros1').val() === '0' && $('#qtdNumerosd1').val() === '0')) {
                        if (confirm('Os números informados estão corretos?')) {
                            $('.btnSalvarLotJogosResultados').button('loading');
                            $('#LotJogosResultadoAddForm').submit();
                        }
                    } else {
                        alert('Por favor, selecione ' + $('#qtdNumeros1').attr('qtdnumeros1') + ' dezenas e ' + $('#qtdNumerosd1').attr('qtdnumerosd1') + ' extras.');
                    }
                }
            });

            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLotJogo();
                }
            });

        }, function() {
            $('.btnSalvarLotJogosResultados').button('reset');
        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLotJogos = new AppLotJogos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
