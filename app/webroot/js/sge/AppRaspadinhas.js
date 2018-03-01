(function (namespace, $) {
    "use strict";

    var AppRaspadinhas = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppRaspadinhas.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppRaspadinhas.objectId = '#AppRaspadinhas';
    AppRaspadinhas.modalFormId = '#nivel1';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        p._habilitaEventos();
        p._habilitaBotoesConsultaConsRaspadinha();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaEventos = function () {
        // CADASTRAR INTENÇÃO DE COMPRA
        $(AppRaspadinhas.objectId + ' .jogarRaspadinha').click(function () {
            p._loadFormRaspadinha($(this).attr('id'));
        });

    };

    p._habilitaBotoesConsultaConsRaspadinha = function () {

    };

    // =========================================================================
    // CARREGA CONSULTA DE INTENÇÕES DE COMPRA
    // =========================================================================

//    p._loadConsRaspadinha = function () {
//        // INSTANCIA VARIÁREIS
//        var form = $('#pesquisarRaspadinha');
//        var table = $('#gridRaspadinhas');
//        var url = baseUrl + 'raspadinhas/index';
//
//        window.materialadmin.AppNavigation.carregando(table);
//
//        $.post(url, form.serialize(), function (html, textStatus, jqXHR) {
//            if (jqXHR.status == 200) {
//                // RECARREGA FORMULÁRIO
//                table.html($(html).find('#' + table.attr('id') + ' >'));
//
//                // HABILITA BOTÕES DA CONSULTA
//                p._habilitaBotoesConsultaConsRaspadinha();
//            }
//        }, 'html');
//    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormRaspadinha = function (id, demo) {
        // CHAMA A FUNÇÃO MODAL
        var modalOject = $('#raspadinha100');
        var url = baseUrl + 'raspadinhas/jogar/' + id;
        var urlCapa;

        window.materialadmin.AppForm.loadModal(modalOject, url, '900', function () {

            $('#left-container').css({
                height: $('.right-container')[0].clientHeight
            });

            var contador = 20;
            $('#ticket-number2').css({"display": "none"});
            var quantidadeRaspadinha = parseInt($('#raspadinhasDisponiveis').text());
            $('#loading').hide();
            $('#comprarRaspadinhas').hide();
            $('#jogarNovamente').hide();
            if (quantidadeRaspadinha == 0) {
                $('#jogar').hide();
                $('#comprarRaspadinhas').show();
            }
            /* SCRIPTS QUE SERÃO EXECUTADOS QUANDO PÁGINA FOR CARREGADA */
            window.materialadmin.App.load('AppWscratchPad');
            $('.scratchpad').wScratchPad('destroy');
            $('#limpar').hide();
            $('#jogar').click(function () {
                $('#jogar').attr('disabled', true).hide();
                $('.scratchpad').wScratchPad('destroy');
                p._buscaRaspadinha(id);
            });

            $('.close').click(function () {
                if (confirm('Caso feche esta tela, sua raspadinha será utilizada!') == true) {
                    p._limpaRaspadinhas();
                }
            });

            $('#jogarNovamente').click(function () {
                $('.idBilhete').html('');
                $('#ticket-number2').css({"display": 'none'});
                $('#resultado')
                    .removeClass('won')
                    .removeClass('lost');
                $('.scratchpad').wScratchPad('destroy');
                //$('#limpar').show();
                $(this)
                    .hide()
                    .attr('disabled', true);
                $('#ajax-loader').fadeIn('slow').css({
                    display: 'block'
                });
                $('.msg')
                    .html('')
                    .hide();
                $('.sub')
                    .html('')
                    .hide();
                p._buscaRaspadinha(id);
            });

            $('#comprarRaspadinhas').click(function () {
                p._compraRaspadinhas();
            });

            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                async: false,
                beforeSend: function ()
                {
                    $('#4').html('<img id="loading" src="../img/raspadinha/ajax-loader.gif">');
                },
                success: function (data)
                {
                    urlCapa = data;

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Erro ao tentar gerar a raspadinha!");
                },
                complete: function (data) {
                    $('.scratchpad').each(function () {
                        $('#' + contador).wScratchPad({
                            fg: urlCapa,
                            'cursor': './img/raspadinha/coin.png") 5 5, coin',
                        });
                        contador++;
                    });

                    $('.scratchpad').wScratchPad('enable', false);
                }
            });



//            var url2 = baseUrl + 'raspadinhas/jogar/2';
//            $.ajax({
//                type: "GET",
//                url: url2,
//                complete: function () {
//            $('.scratchpad').each(function () {
//                $('#' + contador).wScratchPad({
//                    bg: '../img/raspadinha/' + contador + '.png',
//                    fg: $('#capaRaspadinha').val(),
//                    'cursor': '../img/raspadinha/coin.png") 5 5, coin',
//                });
//                contador++;
//            });
//            $('.scratchpad').wScratchPad('enable', false);
//                }
//            });


//             RECARREGA A CONSULTA SE NECESSÁRIO
            modalOject.off('hide.bs.modal');
            modalOject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsRaspadinha();
                }
            });
//            modalOject.css('width')
        });
    };

    p._limpaRaspadinhas = function () {
        $('.scratchpad').wScratchPad('clear');
    };

    p._buscaRaspadinha = function (id, demo) {

        var quantidadeRaspadinha = parseInt($('#raspadinhasDisponiveis').text());
        var contador = 20;
        var contador2 = 0;
        var valores = [];
        var valorTotalGanho = 0;
        var raspadinhasFeitas = 0;
        var raspadinhaId = null;
        var capaUrl;
        var jogar = 100;
//        var url2 = baseUrl + 'raspadinhas/jogar/' + id;
        var url = baseUrl + 'raspadinhas/jogar/' + id;

        if (quantidadeRaspadinha > 0) {
            $.ajax({
                url: url,
                type: "POST",
                data: {jogar: jogar},
                dataType: "json",
                async: true,
                beforeSend: function ()
                {
                    $('.scratchpad').wScratchPad('destroy');
                    //$('#24').html('<img id="loading" src="../img/raspadinha/ajax-loader.gif">');
                },
                success: function (data)
                {
                    for (var i = 0; i <= 10; i++) {
                        if (i > 0) {
                            valores[i] = data[i];
                        } else if (i == 0) {
                            raspadinhaId = data[i];
                        }


                    }
                    valorTotalGanho = data[10];
                    capaUrl = data[11];
                    $('#jogarNovamente').hide();
                    $('#loading').hide();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Erro ao tentar gerar a raspadinha!");
                },
                complete: function () {
                    $('.scratchpad').wScratchPad('enable', false);
                    quantidadeRaspadinha = quantidadeRaspadinha - 1;
                    $('#raspadinhasDisponiveis').html(quantidadeRaspadinha);
                    $('#ticket-number2').css({"display": 'block'});
                    $('.idBilhete').html('#' + raspadinhaId);
                    $('.scratchpad').each(function () {
                        var verifica = 0;
                        $('#' + contador).wScratchPad({
                            bg: '../img/raspadinha/' + valores[contador2 + 1] + '.png',
                            fg: capaUrl,
                            'cursor': '../img/raspadinha/coin.png") 5 5, coin',
                            scratchMove: function (e, percent) {
                                if (percent > 39) {
                                    this.clear();
                                    if (verifica == 0) {
                                        raspadinhasFeitas++;
                                        verifica++;
                                    }
                                    if (raspadinhasFeitas == 9) {
                                        $('#limpar').hide();
                                        if (valorTotalGanho == 0) {
                                            $('.msg').html('Boa sorte para a próxima');
                                            $('.msg').removeClass('won').addClass('lost');
                                            $('.result').removeClass('won').addClass('lost');
                                        } else {
                                            valorTotalGanho = valorTotalGanho.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
                                            $('.result').addClass('won');
                                            $('.msg').removeClass('lost').addClass('won');
                                            $('.msg').html('Parabéns, você ganhou:' + ' ' + valorTotalGanho);
                                            $('.sub').html('O seu prêmio foi adicionado a sua conta!');
                                        }
                                        $('.msg').show();

                                        if (quantidadeRaspadinha == 0) {
                                            $('#jogarNovamente').hide();
                                            $('#jogarNovamente').attr('disabled', true);
                                            $('#comprarRaspadinhas').show();
                                        } else if (quantidadeRaspadinha > 0) {
                                            $('#jogarNovamente').show();
                                            $('#jogarNovamente').attr('disabled', false);
                                        }
                                    }

                                }
                            }
                        });
                        $('.scratchpad').wScratchPad('enable', true);
                        contador2++;
                        contador++;
                    });
                    $('#ajax-loader').hide();
                    $('#limpar').fadeIn('toggle');
                }
            });

        } else {
            //$('#jogarNovamente').hide();
            $('#jogarNovamente').fadeOut();
            $('#limpar').hide();
            $('#jogarNovamente').attr('disabled', true);
        }


        $('#limpar').click(function () {
            p._limpaRaspadinhas();
            $('#limpar').hide();
            if (valorTotalGanho == 0) {
                $('.msg').html('Boa sorte para a próxima');
                $('.msg').removeClass('won').addClass('lost');
                $('.result').removeClass('won').addClass('lost');
            } else {
                valorTotalGanho = valorTotalGanho.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
                $('.result').addClass('won');
                $('.msg').removeClass('lost')
                    .addClass('won')
                    .html('Parabéns, você ganhou:' + ' ' + valorTotalGanho);
                $('.sub').html('O seu prêmio foi adicionado a sua conta!');
            }
            $('.msg').show();

            if (quantidadeRaspadinha > 0) {
                $('#jogarNovamente').show();
                $('#jogarNovamente').attr('disabled', false);
            } else if (quantidadeRaspadinha == 0) {
                $('#comprarRaspadinhas').show();
            }


        });
    }

    p._compraRaspadinhas = function () {
    }

    p.demoRaspadinha = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalOject = $('#nivel1');
        var url = baseUrl + 'raspadinhas/demo/' + id;
        var urlCapa;

        window.materialadmin.AppForm.loadModal(modalOject, url, '57%', function () {

            var contador = 20;

            $('#loading').hide();
            $('#comprarRaspadinhas').hide();
            $('#jogarNovamente').hide();
            /* SCRIPTS QUE SERÃO EXECUTADOS QUANDO PÁGINA FOR CARREGADA */
            window.materialadmin.App.load('AppWscratchPad');
            $('.scratchpad').wScratchPad('destroy');
            $('#limpar').hide();
            $('#jogar').click(function () {

                $('#jogar').attr('disabled', true);
                $('.scratchpad').wScratchPad('destroy');
                $('#jogar').hide();
                p._buscaRaspadinha(id);

            });

            $('.close').click(function () {
                if (confirm('Caso feche esta tela, sua raspadinha será utilizada!') == true) {
                    p._limpaRaspadinhas();
                }
            });

            $('#jogarNovamente').click(function () {
                $('#resultado').removeClass('won').removeClass('lost');
                $('.scratchpad').wScratchPad('destroy');
                //$('#limpar').show();
                $(this)
                    .fadeOut()
                    .attr('disabled', true);
                $('#ajax-loader').fadeIn('slow').css({
                    display: 'block'
                });
                $('.msg').html('').hide();
                $('.sub').html('').hide();
                p._buscaRaspadinha(id);
            });

            $('#comprarRaspadinhas').click(function () {
                p._compraRaspadinhas();
            });



            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                async: false,
                beforeSend: function ()
                {

                    $('#4').html('<img id="loading" src="../img/raspadinha/ajax-loader.gif">');
                },
                success: function (data)
                {
                    urlCapa = data;

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Erro ao tentar gerar a raspadinha!");
                },
                complete: function (data) {
                    $('.scratchpad').each(function () {
                        $('#' + contador).wScratchPad({
                            fg: urlCapa,
                            'cursor': './img/raspadinha/coin.png") 5 5, coin',
                        });
                        contador++;
                    });
                    $('.scratchpad').wScratchPad('enable', false);
                }
            });


//             RECARREGA A CONSULTA SE NECESSÁRIO
            modalOject.off('hide.bs.modal');
            modalOject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsRaspadinha();
                }
            });
        });
    }

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppRaspadinhas = new AppRaspadinhas;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
