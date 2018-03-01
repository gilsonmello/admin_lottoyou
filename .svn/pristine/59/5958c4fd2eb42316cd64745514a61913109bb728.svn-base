$(function () {
    // SCROLLBAR FIX 
    // USADO PARA RESOLVER O PROBLEMA DE MODALS ANINHADOS
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });
    $('.btnAvisos').click(function () {
        var id = $(this).attr('id');
        $(this).removeClass("alert-info");
        $.ajax({
            type: "GET",
            url: baseUrl + 'avisos/view/' + id,
            beforeSend: function () {
                w2popup.lock('Aguarde, processando... ', true);
            },
            success: function (data) {
                $(".modal-content").html(data);
            },
            complete: function () {
                if ($(this).hasClass("alert-info") == true) {
                    var vlr = $('span.badge-red').text() - 1;
                    if (vlr >= 0) {
                        $('span.badge-red').text(vlr);
                    }
                }
                w2popup.unlock();
            }
        });
    });
    $('.loginLink').click(function () {
        var modalObject = $("#nivel1");
        var url = baseUrl + 'users/login';
        window.materialadmin.AppForm.loadModal(modalObject, url, 'undefined', function () {
//            $.ajax({
//                type: "GET",

//                beforeSend: function () {
//                    $("#btnLink").html("<i class='fa fa-circle-o-notch fa-spin'></i> Processando...");
//                },
//                success: function (data) {
//                    $("#unidade").html(data);
//                },
//                complete: function () {
//                    $('select').chosen();
//                    $("#btnLink").attr('disabled', 'disabled');
//                    $("#btnLink").html('Acessar a Unidade');
//                }
//            });
        });
    });


    $('#btnLoteria').click(function () {
        $.ajax({
            url: baseUrl + 'lotJogos/jogos',
            type: "GET",
            beforeSend: function () {
                $("#stage").html("<i class='fa fa-circle-o-notch fa-spin'></i> Processando...");
            },
            success: function (data) {
                $("#stage").html(data);
            },
            complete: function () {
                $('.btnJogarLoteria').click(function () {
                    window.materialadmin.AppLotUserJogos._loadJogo($(this).attr('id'));
                });
            }
        });
    });

    // AJUSTA CASAS DECIMAIS
    $.fn.round = function () {
        var total = +(Math.round(this[0] + "e+2") + "e-2");
        return total.toFixed(2);
    }

    // BEGIN ERROR
    $.fn.error = function (msg) {
        var msg = msg || ''; // se msg não está definido, msg = ''

        this.css({'background-color': '#FFF4F4', 'border-color': '#FF9999'});

        if (msg.length) {
            this.after('<span class="help-block text-danger">' + msg + '</span>');
        }

        this.find('input[type!=button][type!=submit],select,textarea')
                .css('background-color', '#FFF4F4');
    }

    $.fn.removeError = function () {
        if (this.attr('type') != 'button' && this.attr('type') != 'submit') {
            this.parent().find('.help-block').remove();
            this.css({'background-color': '', 'border': ''});
        }
    }
    // END ERROR
});

function ucfirst(str) {
    //  discuss at: http://phpjs.org/functions/ucfirst/
    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Onno Marsman
    // improved by: Brett Zamir (http://brett-zamir.me)
    //   example 1: ucfirst('kevin van zonneveld');
    //   returns 1: 'Kevin van zonneveld'

    str += '';
    var f = str.charAt(0).toUpperCase();
    return f + str.substr(1);
}

function getScrollBarWidth() {
    var inner = document.createElement('p');
    inner.style.width = "100%";
    inner.style.height = "200px";

    var outer = document.createElement('div');
    outer.style.position = "absolute";
    outer.style.top = "0px";
    outer.style.left = "0px";
    outer.style.visibility = "hidden";
    outer.style.width = "200px";
    outer.style.height = "150px";
    outer.style.overflow = "hidden";
    outer.appendChild(inner);

    document.body.appendChild(outer);
    var w1 = inner.offsetWidth;
    outer.style.overflow = 'scroll';
    var w2 = inner.offsetWidth;
    if (w1 == w2)
        w2 = outer.clientWidth;

    document.body.removeChild(outer);

    return (w1 - w2);
}
;

/**
 * moeda
 * 
 * @abstract Classe que formata de desformata valores monetários em float e formata valores 
 * de float em moeda.
 * 
 * @author anselmo
 * 
 * @example 
 *      moeda.formatar(1000) 
 *          >> retornar 1.000,00
 *      moeda.desformatar(1.000,00) 
 *          >> retornar 1000
 * 
 * @version 1.0
 **/
var moeda = {

    /**
     * retiraFormatacao
     * 
     * Remove a formatação de uma string de moeda e retorna um float
     * 
     * @param {Object} num
     */
    desformatar: function (num) {
        num = num.replace(".", "");

        num = num.replace(",", ".");

        return parseFloat(num);
    },

    /**
     * formatar
     * 
     * Deixar um valor float no formato monetário
     * 
     * @param {Object} num
     */
    formatar: function (num) {
        x = 0;

        if (num < 0) {
            num = Math.abs(num);
            x = 1;
        }

        if (isNaN(num))
            num = "0";
        cents = Math.floor((num * 100 + 0.5) % 100);

        num = Math.floor((num * 100 + 0.5) / 100).toString();

        if (cents < 10)
            cents = "0" + cents;
        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
            num = num.substring(0, num.length - (4 * i + 3)) + '.'
                    + num.substring(num.length - (4 * i + 3));

        ret = num + ',' + cents;

        if (x == 1)
            ret = ' - ' + ret;
        return ret;
    },

    /**
     * arredondar
     * 
     * @abstract Arredonda um valor quebrado para duas casas decimais.
     * 
     * @param {Object} num
     */
    arredondar: function (num) {
        return Math.round(num * Math.pow(10, 2)) / Math.pow(10, 2);
    }
}
