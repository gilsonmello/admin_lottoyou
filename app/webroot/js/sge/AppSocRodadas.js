(function (namespace, $) {
    "use strict";

    var AppSocRodadas = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppSocRodadas.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppSocRodadas.objectId = '#AppSocRodadas';
    AppSocRodadas.modalFormId = '#nivel2';
    AppSocRodadas.controller = 'socRodadas';
    AppSocRodadas.model = 'SocRodada';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppSocRodadas.objectId));
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
        $(AppSocRodadas.objectId + ' #cadastrarSocRodada').click(function () {
            p._loadFormSocRodada();
        });

        $(AppSocRodadas.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppSocRodadas.objectId + ' #pesquisarSocRodada').submit(function () {
            p._loadConsSocRodada();
            return false;
        });
    };



    p._habilitaBotoesConsulta = function () {
        $(AppSocRodadas.objectId + ' .btnEditar').click(function () {
            p._loadFormSocRodada($(this).attr('id'));
        });

        $(AppSocRodadas.objectId + ' .btnImagem').click(function () {
            p._carregarImagem($(this).attr('id'));
        });

        $(AppSocRodadas.objectId + ' .btnImagemModal').click(function () {
            p._carregarImagemModal($(this).attr('id'));
        });

        $(AppSocRodadas.objectId + ' .btnCadastrarResultados').click(function () {
            p._cadastrarResultados($(this).attr('id'));
        });

        $(AppSocRodadas.objectId + ' .btnCadastrarJogo').click(function () {
            p._loadAddJogo($(this).attr('id'));
        });

        $(AppSocRodadas.objectId + ' .btnConfiguracao').click(function () {
            p._loadConfiguracao($(this).attr('id'));
        });

        $(AppSocRodadas.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'socRodadas/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsSocRodada();
            });
        });
    };

    p._atualizarPontuacao = function(id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocRodadas.modalFormId);
        var url = 'socRodadas/atualizarPontuacao/' + id;
        var btn = $(AppSocRodadas.modalFormId + ' .btnAtualizarPontuacao');
        var btnPremiacao = $(AppSocRodadas.modalFormId + ' .btnGerarPremiacao');

        // INSTANCIA VARIÁREIS

        if(confirm('Você realmente deseja atualizar as pontuações?')) {
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    btn.button('loading');
                    btnPremiacao.addClass('hide');
                },
                success: function (data) {
                    if (data.status == "ok") {
                        toastr.success(data.msg);
                    } else {
                        toastr.error(data.msg);
                    }
                    btn.button('reset');
                    btnPremiacao.removeClass('hide');
                },
                error: function (error) {
                    toastr.error(error.responseJSON.msg);
                    btn.button('reset');
                    btnPremiacao.removeClass('hide');
                }
            });
        }
    };

    p._gerarPremiacao = function(id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocRodadas.modalFormId);
        var url = 'socRodadas/gerarPremiacao/' + id;
        var btn = $(AppSocRodadas.modalFormId + ' .btnGerarPremiacao');
        var btnPontuacao = $(AppSocRodadas.modalFormId + ' .btnAtualizarPontuacao');

        if(confirm('Você realmente deseja gerar as premiações?')) {
            // INSTANCIA VARIÁREIS
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'JSON',
                beforeSend: function() {
                    btn.button('loading');
                    btnPontuacao.addClass('hide');
                    modalObject.off('hide.bs.modal');
                    modalObject.on('hide.bs.modal', function () {
                        p._loadConsSocRodada();
                    });
                },
                success: function(data) {
                    if(data.status == "ok") {
                        toastr.success(data.msg);
                        modalObject.modal('hide');
                    } else {
                        toastr.error(data.msg);
                    }
                    btn.button('reset');
                    btnPontuacao.removeClass('hide');
                },
                error: function (error) {
                    toastr.error(error.responseJSON.msg);
                    btn.button('reset');
                    btnPontuacao.removeClass('hide');
                }
            });
        }


    };

    p._cadastrarResultados = function(id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocRodadas.modalFormId);
        var url = 'socRodadas/cadastrarResultados/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            $(AppSocRodadas.modalFormId + ' .btnAtualizarPontuacao').click(function () {
                p._atualizarPontuacao($(this).attr('id'));
            }); 

            $(AppSocRodadas.modalFormId + ' .btnGerarPremiacao').click(function () {
                p._gerarPremiacao($(this).attr('id'));
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsSocRodada = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppSocRodadas.objectId + ' #pesquisarSocRodada');
        var table = $(AppSocRodadas.objectId + ' #gridSocRodadas');
        var url = baseUrl + 'socRodadas/index';

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

    p._loadFormSocRodada = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocRodadas.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'socRodadas/add' : 'socRodadas/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '50%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsSocRodada();
                }
            });
            
        });
    };

    p._loadConfiguracao = function (socRodadaId) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocRodadas.modalFormId);
        var url = baseUrl + 'socConfRodadas/add/' + socRodadaId;

        window.materialadmin.AppForm.loadModal(modalObject, url, '95%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
//                    p._loadConsSocRodada();
                }
            });
        });
    }


    p._loadAddJogo = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocRodadas.modalFormId);
        var url = baseUrl + 'socJogos/add/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '80%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
//                    p._loadConsSocRodada();
                }
            });

             $('#btnClonar').click(function () {
                var divClone = $('#divClone').clone();
                var qtd = $('.card-lista').length;
                var qtdTotal = (qtd + 1);

                divClone.attr('id', 'card-' + qtdTotal);
                divClone.css('display', 'block');
                divClone.find('input#SocJogoData')
                .attr('name', 'data[SocJogo][' + qtdTotal + '][data]')
                .datepicker({
                    autoclose: true, 
                    todayHighlight: true, 
                    format: "dd/mm/yyyy", 
                    todayBtn: "linked", 
                    language: "pt-BR"
                }).on('changeDate', function (e) {
            
                });
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

    p._carregarImagem = function (id) {
        var modalObject = $(AppSocRodadas.modalFormId);

        var url = 'socRodadas/carregarImagem/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '50%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {

            });

            modalObject.find('.carregar_imagem').off('click');

            modalObject.find('form').off('submit');

            modalObject.find('.carregar_imagem').on('click', function (event) {

                //Input imagem selecionado pelo usuário
                var imagem = $(document).find('#SocRodadaCarregarImagemForm').find('#SocRodadaImagemCapa');
                //Botão clicado pelo usuário para salvar o formulário
                var btn = $(this);
                //Ícone loader ajax
                var loader = btn.attr('data-loading-text');
                //Texto do botão
                var text = btn.text();
                //Se não houver imagem selecionada
                if (imagem.val() != '') {
                    //Evitando propagação do evento
                    event.preventDefault();
                    event.stopPropagation();

                    //Adiciona a classe de erro ao seu parente
                    imagem.parent().removeClass('has-error');
                    //Ativa o componente que mostra o texto (Campo obrigatório)
                    imagem.parent().find('.help-block').css({
                        display: 'none'
                    });
                    //Instância do tipo dados de formulário
                    var formData = new FormData();
                    //Adicionando a imagem ao form data
                    formData.append('imagem_capa', imagem[0].files[0]);
                    //Enviando requisição para salvar a imagem
                    $.ajax({
                        method: 'post',
                        url: $(document).find('#SocRodadaCarregarImagemForm').attr('action'),
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        beforeSend: function () {
                            //Ativa o ajax loader
                            loader = btn.attr('data-loading-text');
                            btn.html(loader);
                            btn.attr('disabled', 'disabled');
                        },
                        success: function (data) {
                            if (data == "true") {
                                //Desativa o ajax loader
                                btn.html(text);
                                btn.removeAttr('disabled');
                                toastr.success("Imagem enviada com sucesso");
                                modalObject.modal('hide');
                            } else {
                                //Desativa o ajax loader
                                btn.html(text);
                                btn.removeAttr('disabled');
                                toastr.error("Erro ao enviar mensagem. Tente novamente.");
                            }
                        },

                    });
                } else {
                    //Caso aconteça tudo normal
                    //Remove as classes e texto de erro
                    imagem.parent().addClass('has-error');
                    imagem.parent().find('.help-block').css({
                        display: 'block'
                    });
                }
            });
        });
    };

    p._carregarImagemModal = function (id) {
        var modalObject = $(AppSocRodadas.modalFormId);

        var url = 'socRodadas/carregarImagemModal/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '50%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {

            });

            modalObject.find('.carregar_imagem').off('click');

            modalObject.find('form').off('submit');

            modalObject.find('.carregar_imagem').on('click', function (event) {

                //Input imagem selecionado pelo usuário
                var imagem = modalObject.find('#SocRodadaCarregarImagemModalForm').find('#SocRodadaImagemModal');

                //Botão clicado pelo usuário para salvar o formulário
                var btn = $(this);
                //Ícone loader ajax
                var loader = btn.attr('data-loading-text');
                //Texto do botão
                var text = btn.text();
                //Se não houver imagem selecionada
                if (imagem.val() != '') {
                    //Evitando propagação do evento
                    event.preventDefault();
                    event.stopPropagation();

                    //Adiciona a classe de erro ao seu parente
                    imagem.parent().removeClass('has-error');
                    //Ativa o componente que mostra o texto (Campo obrigatório)
                    imagem.parent().find('.help-block').css({
                        display: 'none'
                    });
                    //Instância do tipo dados de formulário
                    var formData = new FormData();
                    //Adicionando a imagem ao form data
                    formData.append('imagem_modal', imagem[0].files[0]);
                    //Enviando requisição para salvar a imagem
                    $.ajax({
                        method: 'post',
                        url: $(document).find('#SocRodadaCarregarImagemModalForm').attr('action'),
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        beforeSend: function () {
                            //Ativa o ajax loader
                            loader = btn.attr('data-loading-text');
                            btn.html(loader);
                            btn.attr('disabled', 'disabled');
                        },
                        success: function (data) {
                            if (data == "true") {
                                //Desativa o ajax loader
                                btn.html(text);
                                btn.removeAttr('disabled');
                                toastr.success("Imagem enviada com sucesso");
                                modalObject.modal('hide');
                            } else {
                                //Desativa o ajax loader
                                btn.html(text);
                                btn.removeAttr('disabled');
                                toastr.error("Erro ao enviar mensagem. Tente novamente.");
                            }
                        }
                    });
                } else {
                    //Caso aconteça tudo normal
                    //Remove as classes e texto de erro
                    imagem.parent().addClass('has-error');
                    imagem.parent().find('.help-block').css({
                        display: 'block'
                    });
                }
            });
        });

    };
    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppSocRodadas = new AppSocRodadas;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
