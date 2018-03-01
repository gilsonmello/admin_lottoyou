(function (namespace, $) {
    "use strict";

    var AppLotUserJogos = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLotUserJogos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLotUserJogos.objectId = '#AppLotUserJogos';
    AppLotUserJogos.modalFormId = '#nivel3';
    AppLotUserJogos.controller = 'lotUserJogo';
    AppLotUserJogos.model = 'LotUserJogo';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLotUserJogos.objectId));
//        window.materialadmin.AppGrid.initialize();
        window.materialadmin.AppVendor.initialize();
//        window.materialadmin.Demo.initialize();

        // CARREGA EVENTOS 
        p._habilitaEventos();
        p._habilitaBotoesConsulta();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaEventos = function () {
        $(AppLotUserJogos.objectId + ' #cadastrarLotUserJogo').click(function () {
            p._loadFormLotUserJogo();
        });

        $(AppLotUserJogos.objectId + ' .btnLotJogarLoteria').click(function () {
            p._loadJogo($(this).attr('id'));
        });


        $(AppLotUserJogos.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLotUserJogos.objectId + ' #pesquisarLotUserJogo').submit(function () {
            p._loadConsLotUserJogo();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppLotUserJogos.objectId + ' .btnAtualizarLotUserJogo').click(function () {
            p._loadFormLotUserJogo($(this).attr('id'));
        });


        $(AppLotUserJogos.objectId + ' .btnDeletarLotUserJogo').click(function () {
            var res;
            res = confirm("Deseja realmente excluir o item?");
            if (res) {
                var url = baseUrl + 'lotUserJogos/delete/' + $(this).attr('id');
                window.materialadmin.AppGrid.delete(url, function () {
                    p._loadConsLotUserJogo();
                });
            }
        });

        $(AppLotUserJogos.objectId + ' .btnDetalharLotUserJogo').click(function () {
            var modalObject = $(AppLotUserJogos.modalFormId);
            var url = 'lotUserJogos/detalhar/' + $(this).attr('id');
            window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
                modalObject.off('hide.bs.modal');
                modalObject.on('hide.bs.modal', function () {
                    if (window.materialadmin.AppForm.getFormState()) {

                    }
                });

            });

        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLotUserJogo = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLotUserJogos.objectId + ' #pesquisarLotUserJogo');
        var table = $(AppLotUserJogos.objectId + ' #gridLotUserJogos');
        var url = baseUrl + 'lotUserJogos/index';

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

    p._loadJogo = function (id) {
        // INSTANCIA VARIÁREIS
        var modalObject = $(AppLotUserJogos.modalFormId);
        var url = baseUrl + 'lotUserJogos/tabela/' + id + '/1';

        window.materialadmin.AppForm.loadModal(modalObject, url, '98%', function () {
            p._habilitaJogadas();
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
//                if (window.materialadmin.AppForm.getFormState()) {
//                    p._loadConsLotJogo();
//                }
            });

        });
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormLotUserJogo = function (id) {
        // INSTANCIA VARIÁREIS
        var modalObject = $(AppLotUserJogos.modalFormId);
        var url = baseUrl + 'lotUserJogos/tabela/' + id + '/1';

        window.materialadmin.AppForm.loadModal(modalObject, url, '98%', function () {
            p._habilitaJogadas();
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLotJogo();
                }
            });

        });
    };

    p._loadTabelaLotUserJogo = function (tipo) {
        var url = baseUrl + 'lotUserJogos/tabela/' + tipo;
        var table = $('#gridTabelaLotUserJogo');
        $.ajax({
            type: "GET",
            url: url,
            beforeSend: function () {
                window.materialadmin.AppNavigation.carregando(table);
            },
            success: function (data) {
                table.html(data);
            },
            complete: function () {
                p._habilitaJogadas();
            }
        });
    };

    p._acaoDezenaLotJogo = function (n, ids, pass, i, k) {
        var numeros = $('#' + n).val();
        var id = '#' + ids;
        if ($(id).hasClass('btn-default-darks') && numeros > 0 && k) {
            $(id).removeClass('btn-default-darks');
            $(id).addClass('btn-successu');
            $('#' + i + pass).val(pass);
            numeros--;
        } else if ($(id).hasClass('btn-successu')) {
            $(id).removeClass('btn-successu');
            $(id).addClass('btn-default-darks');
            numeros++;
            $('#' + i + pass).val('');
        } else if ($(id).hasClass('btn-default-darks') && numeros == 0 && k) {
            switch (i) {
                case 'D':
                    alert('Todos as dezenas do Primeiro volante selecionadas.');
                    break;
                case 'E':
                    alert('Todos as dezenas do Segundo volante selecionadas.');
                    break;
                case 'F':
                    alert('Todos as dezenas do Terceiro volante selecionadas.');
                    break;
                case 'G':
                    alert('Todos as dezenas do Quarto volante selecionadas.');
                    break;
                case 'H':
                    alert('Todos as dezenas do Quinto volante selecionadas.');
                    break;
                case 'I':
                    alert('Todos as dezenas do Sexto volante selecionadas.');
                    break;
            }
        }
        $('#' + n).val(numeros);
        if (numeros == 0) {
            $('.btnSalvarLotUserJogo').removeClass('disabled');
        }
//        else {
//            $('.btnSalvarLotUserJogo').addClass('disabled');
//        }
    };

    p._acaoDezenaLotJogo2 = function (n, ids, pass, i, k) {
        var numeros = $('#' + n).val();
        var id = '#' + ids;
        if ($(id).hasClass('btn-default-darking') && numeros > 0 && k) {
            $(id).removeClass('btn-default-darking');
            $(id).addClass('btn-successu');
            $('#' + i + pass).val(pass);
            numeros--;
        } else if ($(id).hasClass('btn-successu')) {
            $(id).removeClass('btn-successu');
            $(id).addClass('btn-default-darking');
            numeros++;
            $('#' + i + pass).val('');
        } else if ($(id).hasClass('btn-default-darking') && numeros == 0 && k) {

        }
        $('#' + n).val(numeros);

    };

    p._acaoLimparDezenaJogo = function (n) {
        var volante = n;
        var dezz = $('#qtdNumeros' + volante).attr('tns');
        switch (volante) {
            case '1':
                var letra = 'D';
                break;
            case '2':
                var letra = 'E';
                break;
            case '3':
                var letra = 'F';
                break;
            case '4':
                var letra = 'G';
                break;
            case '5':
                var letra = 'H';
                break;
            case '6':
                var letra = 'I';
                break;
        }
        dezz++;
        for (var i = 1, max = dezz; i < max; i++) {
            var id;
            if (i < 10) {
                id = volante + '00' + i;
            } else if (i > 9) {
                id = volante + '0' + i;
            } else if (i == 100) {
                id = volante + '000';
            }

            p._acaoDezenaLotJogo('qtdNumeros' + volante, id, i, letra, false);
        }
    };
    p._acaoLimparDezenaJogo2 = function (n) {
        var volante = n;
        switch (volante) {
            case '1':
                var letra = 'd';
                break;
            case '2':
                var letra = 'e';
                break;
            case '3':
                var letra = 'f';
                break;
            case '4':
                var letra = 'g';
                break;
            case '5':
                var letra = 'h';
                break;
            case '6':
                var letra = 'i';
                break;
        }
        var dezz = $('#qtdNumeros' + letra + volante).attr('tns');
        dezz++;
        for (var i = 1, max = dezz; i < max; i++) {
            var id;
            if (i < 10) {
                id = letra + volante + '00' + i;
            } else if (i > 9) {
                id = letra + volante + '0' + i;
            } else if (i == 100) {
                id = letra + volante + '000';
            }

            p._acaoDezenaLotJogo2('qtdNumeros' + letra + volante, id, i, letra, false);
        }
    };

    p._habilitaJogadas = function () {
        //----------------------------------------------------------------------------------------------------
        $('.btnLotJogosPedras1').click(function () {
            p._acaoDezenaLotJogo('qtdNumeros1', $(this).attr('id'), $(this).attr('pass'), 'D', true);
        });
        $('.btnLotJogosPedrasd1').click(function () {
            p._acaoDezenaLotJogo2('qtdNumerosd1', $(this).attr('id'), $(this).attr('pass'), 'd', true);
        });
        //----------------------------------------------------------------------------------------------------
        $('.btnLotJogosPedras2').click(function () {
            p._acaoDezenaLotJogo('qtdNumeros2', $(this).attr('id'), $(this).attr('pass'), 'E', true);
        });
        $('.btnLotJogosPedrase2').click(function () {
            p._acaoDezenaLotJogo2('qtdNumerose2', $(this).attr('id'), $(this).attr('pass'), 'e', true);
        });
        //----------------------------------------------------------------------------------------------------
        $('.btnLotJogosPedras3').click(function () {
            p._acaoDezenaLotJogo('qtdNumeros3', $(this).attr('id'), $(this).attr('pass'), 'F', true);
        });
        $('.btnLotJogosPedrasf3').click(function () {
            p._acaoDezenaLotJogo2('qtdNumerosf3', $(this).attr('id'), $(this).attr('pass'), 'f', true);
        });
        //----------------------------------------------------------------------------------------------------
        $('.btnLotJogosPedras4').click(function () {
            p._acaoDezenaLotJogo('qtdNumeros4', $(this).attr('id'), $(this).attr('pass'), 'G', true);
        });
        $('.btnLotJogosPedrasg4').click(function () {
            p._acaoDezenaLotJogo2('qtdNumerosg4', $(this).attr('id'), $(this).attr('pass'), 'g', true);
        });
        //----------------------------------------------------------------------------------------------------
        $('.btnLotJogosPedras5').click(function () {
            p._acaoDezenaLotJogo('qtdNumeros5', $(this).attr('id'), $(this).attr('pass'), 'H', true);
        });
        $('.btnLotJogosPedrash5').click(function () {
            p._acaoDezenaLotJogo2('qtdNumerosh5', $(this).attr('id'), $(this).attr('pass'), 'h', true);
        });
        //----------------------------------------------------------------------------------------------------
        $('.btnLotJogosPedras6').click(function () {
            p._acaoDezenaLotJogo('qtdNumeros6', $(this).attr('id'), $(this).attr('pass'), 'I', true);
        });
        $('.btnLotJogosPedrasi6').click(function () {
            p._acaoDezenaLotJogo2('qtdNumerosi6', $(this).attr('id'), $(this).attr('pass'), 'i', true);
        });
//----------------------------------------------------------------------------------------------------
        $('#btnSalvarLotUserJogo').click(function () {
            if (typeof ($('#qtdNumerosd1').val()) === 'undefined') {

                if (
                        ($('#qtdNumeros1').val() === '0' || $('#qtdNumeros1').val() == (sub($('#qtdNumeros1').attr('qtdNumeros1'), $('#qtdNumeros1').attr('qtdNumerosMin')))) ||
                        ($('#qtdNumeros2').val() === '0' || $('#qtdNumeros2').val() == (sub($('#qtdNumeros2').attr('qtdNumeros2'), $('#qtdNumeros2').attr('qtdNumerosMin')))) ||
                        ($('#qtdNumeros3').val() === '0' || $('#qtdNumeros3').val() == (sub($('#qtdNumeros3').attr('qtdNumeros3'), $('#qtdNumeros3').attr('qtdNumerosMin')))) ||
                        ($('#qtdNumeros4').val() === '0' || $('#qtdNumeros4').val() == (sub($('#qtdNumeros4').attr('qtdNumeros4'), $('#qtdNumeros4').attr('qtdNumerosMin')))) ||
                        ($('#qtdNumeros5').val() === '0' || $('#qtdNumeros5').val() == (sub($('#qtdNumeros5').attr('qtdNumeros5'), $('#qtdNumeros5').attr('qtdNumerosMin')))) ||
                        ($('#qtdNumeros6').val() === '0' || $('#qtdNumeros6').val() == (sub($('#qtdNumeros6').attr('qtdNumeros6'), $('#qtdNumeros6').attr('qtdNumerosMin'))))
                        ) {
                    $('#LotUserJogoTabelaForm').submit();
                } else {
                    alert('Por favor, selecione mais dezenas.');
                }
            } else {
                if (
                        ($('#qtdNumeros1').val() === '0' || $('#qtdNumeros1').val() == (sub($('#qtdNumeros1').attr('qtdNumeros1'), $('#qtdNumeros1').attr('qtdNumerosMin'))) && $('#qtdNumerosd1').val() === '0') ||
                        ($('#qtdNumeros2').val() === '0' || $('#qtdNumeros2').val() == (sub($('#qtdNumeros2').attr('qtdNumeros2'), $('#qtdNumeros2').attr('qtdNumerosMin'))) && $('#qtdNumerose2').val() === '0') ||
                        ($('#qtdNumeros3').val() === '0' || $('#qtdNumeros3').val() == (sub($('#qtdNumeros3').attr('qtdNumeros3'), $('#qtdNumeros3').attr('qtdNumerosMin'))) && $('#qtdNumerosf3').val() === '0') ||
                        ($('#qtdNumeros4').val() === '0' || $('#qtdNumeros4').val() == (sub($('#qtdNumeros4').attr('qtdNumeros4'), $('#qtdNumeros4').attr('qtdNumerosMin'))) && $('#qtdNumerosg4').val() === '0') ||
                        ($('#qtdNumeros5').val() === '0' || $('#qtdNumeros5').val() == (sub($('#qtdNumeros5').attr('qtdNumeros5'), $('#qtdNumeros5').attr('qtdNumerosMin'))) && $('#qtdNumerosh5').val() === '0') ||
                        ($('#qtdNumeros6').val() === '0' || $('#qtdNumeros6').val() == (sub($('#qtdNumeros6').attr('qtdNumeros6'), $('#qtdNumeros6').attr('qtdNumerosMin'))) && $('#qtdNumerosi6').val() === '0')
                        ) {
                    $('#LotUserJogoTabelaForm').submit();
                } else {
                    alert('Por favor, selecione ' + $('#qtdNumeros1').attr('qtdnumeros1') + ' dezenas e ' + $('#qtdNumerosd1').attr('qtdnumerosd1') + ' extras de um volante.');
                }
            }
        });

        $('.btnClearDezenas').click(function () {
            p._acaoLimparDezenaJogo2($(this).attr('volante'));
            p._acaoLimparDezenaJogo($(this).attr('volante'));
        });

        $('.btnRandomDezenas').click(function () {
            var volante = $(this).attr('volante');
            p._acaoLimparDezenaJogo2(volante);
            p._acaoLimparDezenaJogo(volante);
            var dezz = $('#qtdNumeros' + volante).attr('tns');
            switch (volante) {
                case '1':
                    var letra = 'D';
                    var letra2 = 'd';
                    break;
                case '2':
                    var letra = 'E';
                    var letra2 = 'e';
                    break;
                case '3':
                    var letra = 'F';
                    var letra2 = 'f';
                    break;
                case '4':
                    var letra = 'G';
                    var letra2 = 'g';
                    break;
                case '5':
                    var letra = 'H';
                    var letra2 = 'h';
                    break;
                case '6':
                    var letra = 'I';
                    var letra2 = 'i';
                    break;
            }
            while ($('#qtdNumeros' + volante).val() != 0) {
                var id;
                var i = Math.floor(Math.random() * $('#qtdNumeros' + volante).attr('tns'))
                if (i < 10) {
                    id = volante + '00' + i;
                } else if (i > 9) {
                    id = volante + '0' + i;
                } else if (i == 0) {
                    id = volante + '000';
                }
                p._acaoDezenaLotJogo('qtdNumeros' + volante, id, i, letra, true);
            }
            if (!(typeof ($('#qtdNumerosd1').val()) === 'undefined')) {
                while ($('#qtdNumeros' + letra2 + volante).val() != 0) {
                    var id;
                    var i = Math.floor(Math.random() * $('#qtdNumeros' + letra2 + volante).attr('tns'))
                    if (i < 10) {
                        id = letra2 + volante + '00' + i;
                    } else if (i > 9 && i < 100) {
                        id = letra2 + volante + '0' + i;
                    } else if (i == 100) {
                        id = letra2 + volante + '000';
                    }
                    p._acaoDezenaLotJogo2('qtdNumeros' + letra2 + volante, id, i, letra2, true);
                }
            }
        });
    };

    function sub(n1, n2) {
        var num = (parseInt(n1) - parseInt(n2));
        return num;
    }



    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLotUserJogos = new AppLotUserJogos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
