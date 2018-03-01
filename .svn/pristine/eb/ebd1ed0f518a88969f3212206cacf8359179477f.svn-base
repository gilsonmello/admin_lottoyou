(function (namespace, $) {
    "use strict";

    var AppLotJogosResultados = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLotJogosResultados.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLotJogosResultados.objectId = '#AppLotJogosResultados';
    AppLotJogosResultados.modalFormId = '#nivel3';
    AppLotJogosResultados.controller = 'lotJogosResultados';
    AppLotJogosResultados.model = 'LotJogosResultados';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLotJogosResultados.objectId));
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
        $(AppLotJogosResultados.objectId + ' #cadastrarLotJogosResultado').click(function () {
            p._loadFormLotJogosResultados();
        });

        $(AppLotJogosResultados.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLotJogosResultados.objectId + ' #pesquisarLotJogosResultado').submit(function () {
            p._loadConsLotJogosResultados();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppLotJogosResultados.objectId + ' .btnEditar').click(function () {
            p._loadFormLotJogosResultados($(this).attr('id'));
        });

        $(AppLotJogosResultados.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'lotJogosResultados/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLotJogosResultados();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLotJogosResultados = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLotJogosResultados.objectId + ' #pesquisarLotJogosResultados');
        var table = $(AppLotJogosResultados.objectId + ' #gridLotJogosResultados');
        var url = baseUrl + 'lotJogosResultados/index';

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

    p._loadFormLotJogosResultados = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLotJogosResultados.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'lotJogosResultados/add' : 'lotJogosResultados/' + action + '/' + id;
        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {

            $('.tipoJogoResult').change(function () {
                if ($('.tipoJogoResult').val() !== '') {
                    p._loadTabelaLotJogosResultados($('.tipoJogoResult').val());
                }
            });

            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLotJogosResultados();
                }
            });

        });
    };

    p._loadTabelaLotJogosResultados = function (tipo) {
        var url = baseUrl + 'lotJogosResultados/tabela/' + tipo;
        var table = $('#gridTabelaLotJogosResultados');
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
                var numeros = $('#qtdNumeros').attr('qtdNumeros');
                var num = 0;
                var id = 0;
                $('.btnLotJogosPedras').click(function () {
                    num = $(this).attr('pass');
                    id = '#' + $(this).attr('id');
                    if ($(id).hasClass('btn-default-light') && numeros > 0) {
                        $(id).removeClass('btn-default-light');
                        $(id).addClass('btn-success');
                        $('#D' + num).val(num);
                        numeros -= 1;

                    } else if ($(id).hasClass('btn-success')) {

                        $(id).removeClass('btn-success');
                        $(id).addClass('btn-default-light');
                        numeros += 1;
                        $('#D' + num).val('');
                    } else if ($(id).hasClass('btn-default-light') && numeros === 0) {
                        alert('Todos as dezenas selecionadas.');
                    }
                });

                $('.btnSalvarLotJogosResultados').click(function () {
                    if (numeros > 0) {
                        alert('Faltam dezenas.');
                    } else {
                        $('#LotJogosResultadoAddForm').submit();
                    }
                });


            }
        });
    };

    p._acaoDezenaLotJogos = function (n, ids, pass, i, k) {
        var numeros = $('#' + n).val();
        var id = '#' + ids;
        if ($(id).hasClass('btn-default-light') && numeros > 0 && k) {
            $(id).removeClass('btn-default-light');
            $(id).addClass('btn-success');
            $('#' + i + pass).val(pass);
            numeros--;
        } else if ($(id).hasClass('btn-success')) {
            $(id).removeClass('btn-success');
            $(id).addClass('btn-default-light');
            numeros++;
            $('#' + i + pass).val('');
        } else if ($(id).hasClass('btn-default-light') && numeros == 0 && k) {
            switch (i) {
                case 'D':
                    alert('Todos as dezenas selecionadas.');
                    break;
//                case 'E':
//                    alert('Todos as dezenas do Segundo volante selecionadas.');
//                    break;
//                case 'F':
//                    alert('Todos as dezenas do Terceiro volante selecionadas.');
//                    break;
//                case 'G':
//                    alert('Todos as dezenas do Quarto volante selecionadas.');
//                    break;
//                case 'H':
//                    alert('Todos as dezenas do Quinto volante selecionadas.');
//                    break;
//                case 'I':
//                    alert('Todos as dezenas do Sexto volante selecionadas.');
//                    break;
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
            $(id).addClass('btn-success');
            $('#' + i + pass).val(pass);
            numeros--;
        } else if ($(id).hasClass('btn-success')) {
            $(id).removeClass('btn-success');
            $(id).addClass('btn-default-darking');
            numeros++;
            $('#' + i + pass).val('');
        } else if ($(id).hasClass('btn-default-darking') && numeros == 0 && k) {

        }
        $('#' + n).val(numeros);

    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLotJogosResultados = new AppLotJogosResultados;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
