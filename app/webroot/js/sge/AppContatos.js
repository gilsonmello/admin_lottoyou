(function (namespace, $) {
    "use strict";

    var AppContatos = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppContatos.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppContatos.objectId = '#AppContatos';
    AppContatos.modalFormId = '#nivel2';
    AppContatos.controller = 'contatos';
    AppContatos.model = 'Contato';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppContatos.objectId));
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

    p._habilitaBotoesPaginate = function() {
        $(document).on('click', AppContatos.objectId+' .pagination a', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    window.materialadmin.AppNavigation.carregando($('#gridContatos'));
                },
                success: function (data) {
                    $('#gridContatos').html(data);
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    p._habilitaEventos = function () {

        p._habilitaBotoesPaginate();

        $(AppContatos.objectId + ' #cadastrarContatos').click(function () {
            p._loadFormContato();
        });

        $(AppContatos.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppContatos.objectId + ' #pesquisarContatos').submit(function () {
            p._loadConsContatos();
            return false;
        });
    };



    p._habilitaBotoesConsulta = function () {
        $(AppContatos.objectId + ' .btnResponder').click(function () {
            p._loadFormContatos($(this).attr('id'));
        });
    };

    p._atualizarPontuacao = function(id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppContatos.modalFormId);
        var url = 'contatos/atualizarPontuacao/' + id;
        var btn = $(AppContatos.modalFormId + ' .btnAtualizarPontuacao');
        var btnPremiacao = $(AppContatos.modalFormId + ' .btnGerarPremiacao');

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
                complete: function() {
                    btn.button('reset');
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
        var modalObject = $(AppContatos.modalFormId);
        var url = 'contatos/gerarPremiacao/' + id;
        var btn = $(AppContatos.modalFormId + ' .btnGerarPremiacao');
        var btnPontuacao = $(AppContatos.modalFormId + ' .btnAtualizarPontuacao');

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
                        p._loadConsContatos();
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
        var modalObject = $(AppContatos.modalFormId);
        var url = 'contatos/cadastrarResultados/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            $(AppContatos.modalFormId + ' .btnAtualizarPontuacao').click(function () {
                p._atualizarPontuacao($(this).attr('id'));
            }); 

            $(AppContatos.modalFormId + ' .btnGerarPremiacao').click(function () {
                p._gerarPremiacao($(this).attr('id'));
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsContatos = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppContatos.objectId + ' #pesquisarContatos');
        var table = $(AppContatos.objectId + ' #gridContatos');
        var url = baseUrl + 'contatos/index';

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

    p._loadFormContatos = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppContatos.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'answer';
        var url = (typeof id === 'undefined') ? 'contatos/add' : 'contatos/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '50%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsContatos();
                }
            });
            
        });
    };

    p._loadAddJogo = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppContatos.modalFormId);
        var url = baseUrl + 'socJogos/add/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '80%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
//                    p._loadConsContatos();
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
        var modalObject = $(AppContatos.modalFormId);

        var url = 'contatos/carregarImagem/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '50%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {

            });

            modalObject.find('.carregar_imagem').off('click');

            modalObject.find('form').off('submit');

            modalObject.find('.carregar_imagem').on('click', function (event) {

                //Input imagem selecionado pelo usuário
                var imagem = $(document).find('#ContatoCarregarImagemForm').find('#ContatoImagemCapa');
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
                        url: $(document).find('#ContatoCarregarImagemForm').attr('action'),
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
        var modalObject = $(AppContatos.modalFormId);

        var url = 'contatos/carregarImagemModal/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '50%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {

            });

            modalObject.find('.carregar_imagem').off('click');

            modalObject.find('form').off('submit');

            modalObject.find('.carregar_imagem').on('click', function (event) {

                //Input imagem selecionado pelo usuário
                var imagem = modalObject.find('#ContatoCarregarImagemModalForm').find('#ContatoImagemModal');

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
                        url: $(document).find('#ContatoCarregarImagemModalForm').attr('action'),
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

    window.materialadmin.AppContatos = new AppContatos;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
