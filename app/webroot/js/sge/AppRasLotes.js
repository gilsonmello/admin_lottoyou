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

    p._loadGerarDemos = function(id, clonar) {
        // CHAMA A FUNÇÃO MODALa
        var modalObject = $(AppRasLotes.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'addDemos';
        var url = (typeof id === 'undefined') ? 'rasLotes/addDemos' : 'rasLotes/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                //p._loadGerarDemos(id);
            });
        }, function() {
            p._loadGerarDemos(id);
        }, false, false);
    };

    function remover_numero(element) {
        $(element).on('click', function() {
            var btn = $(this);
            var linha = btn.attr('data-line');

            if($('.linha').length > 5) {
                $.ajax({
                    method: 'POST',
                    url: baseUrl+'/rasLotes/removerNumeros/'+btn.attr('data-id'),
                    success: function(data) {
                        if(data.status == true) {
                            toastr.options.timeOut = 2000;
                            toastr.success(data.msg);
                            $(btn.attr('data-line')).fadeOut('toggle', function() {
                                $(this).remove();

                                if($('.linha').length == 0) {
                                    modalObject.modal('hide');
                                    setTimeout(function() {
                                        p._loadGerarNumeros(id, clonar);
                                    }, 500); 
                                }

                            });
                        } else {
                            toastr.options.timeOut = 2000;
                            toastr.error(data.msg);
                        }
                    },
                    error: function() {
                        btn.button('reset');
                        $(btn.attr('data-line')).fadeOut('toggle', function() {

                        });
                    }
                });
            } else {
                alert('É necessário ao menos 5 números para a raspadinha');
            }
        });
    }

    p._loadGerarNumeros = function(id, clonar) {
        // CHAMA A FUNÇÃO MODALa
        var modalObject = $(AppRasLotes.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'addNumeros';
        var url = (typeof id === 'undefined') ? 'rasLotes/add' : 'rasLotes/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {

            //Evento executado nos inputs file
            $('input[type="file"]')
                .on('change', function() {
                    //Pegando o nome do arquivo
                    var file_name = $(this)[0].files[0].name;
                    //Linha do elemento clicado
                    var line = $(this).attr('data-line');
                    //Atribuindo o nome do arquivo ao elemento img-name
                    $('.linha-'+line).find('.img-name').text(file_name);

                    var file = $(this)[0].files[0];
                    
                    if(window.FileReader){
                        if(file.type.indexOf('image') >= 0){
                            var reader = new FileReader();
                            reader.onprogress = function(evt){
                            };
                            reader.onloadend = function(e){
                                $('.linha-'+line).find('.img-target').attr('src', e.target.result);
                            };
                            reader.readAsDataURL(file);
                        }
                    } 
                });

            $('.adicionar-numero').on('click', function() {
                var linha = $('.linha');
                var length = linha.length;

                var clone = modalObject.find('.linha-'+(length - 1)).clone();

                clone.removeClass('linha-'+(length - 1));
                clone.addClass('linha-'+(length));

                clone.find('.numbers')
                    .val('')
                    .removeAttr('name')
                    .attr('name', 'data[RasLotesNumero]['+length+'][number]')
                    .priceFormat({prefix: '$ ', centsSeparator: ',', thousandsSeparator: '.'});

                clone.find('.img-name').text('');
                
                clone.find('.img')
                    .val('')
                    .attr('src', '')
                    .attr('data-line', (length - 1))
                    .removeAttr('name')
                    .attr('name', 'data[RasLotesNumero]['+length+'][img]')
                    .on('change', function() {
                        var file_name = $(this)[0].files[0].name;
                        clone.find('.img-name').text(file_name);

                        var file = $(this)[0].files[0];
                        
                        if(window.FileReader){
                            if(file.type.indexOf('image') >= 0){
                                var reader = new FileReader();
                                reader.onprogress = function(evt){
                                };
                                reader.onloadend = function(e){
                                    clone.find('.img-target').attr('src', e.target.result);
                                };
                                reader.readAsDataURL(file);
                            }
                        }       
                    });

                clone.find('.remover-numero')
                    .attr('data-line', '.linha-'+(length))
                    .attr('data-id', 'null');

                clone.find('img')
                    .attr('src', '');

                $('.linha-'+(length - 1)).after(clone);

                $('.remover-numero').off('click');
                remover_numero($('.remover-numero'));
            });

            $('.remover-numero').off('click');
            remover_numero($('.remover-numero'));
            

            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsRasLote();
                }
            });

        }, undefined, true, false, function() {
            modalObject.find('form').submit(function() {
                if($('.linha').length < 5) {
                    return false;
                }
            })
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppRasLotes.objectId + ' .btnEditar').click(function () {
            p._loadFormRasLote($(this).attr('id'));
        });

        $(AppRasLotes.objectId + ' .btnGerarRaspadinha').click(function () {
            p._loadGerarLoteRaspadinha($(this).attr('id'));
        });

        $(AppRasLotes.objectId + ' .btnGerarNumeros').click(function () {
            p._loadGerarNumeros($(this).attr('id'));
        });

        $(AppRasLotes.objectId + ' .btnGerarDemos').click(function () {
            p._loadGerarDemos($(this).attr('id'));
        });

        $(AppRasLotes.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'rasLotes/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsRasLote();
            });
        });
    };

    p._loadUploadCovers = function() {
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
                var submit = $(this);
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: $('#RasLoteAddRaspadinhasForm').serialize(),
                    beforeSend: function () {
                        submit.button('loading');
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
                        submit.button('reset');
                        if (data.error == 0) {
                            toastr.success(data.msg);
                            p._loadGerarLoteRaspadinha(idAux);
                        } else {
                            toastr.error(data.msg);
                        }
                    },
                    error: function(){
                        submit.button('reset');
                    }
                });
            });

            $("#btnGerarRaspadinhas").click(function () {
                var url2 = baseURL + 'rasLotes/addRaspadinhas'
                var raspadinhas_restantes = $(this).attr('raspadinhas_restantes');
                var lote_id = $('#RasLoteLoteId').val();
                var user_id = $('#RasLoteUserId').val();
                var tema_id = $('#RasLoteTemaId').val();
                var auto = 1;
                var submit = $(this);
                if (raspadinhas_restantes > 0) {
                    if (confirm("Confirma a Criação das raspadinhas restantes SEM PRÊMIO?")) {
                        $.ajax({
                            url: url2,
                            type: "POST",
                            dataType: "json",
                            data: {
                                raspadinhas_restantes: raspadinhas_restantes, 
                                lote_id: lote_id, 
                                user_id: user_id, 
                                tema_id: tema_id, 
                                auto: auto
                            },
                            beforeSend: function() {
                                submit.button('loading');
                            },
                            success: function (data) {
                                submit.button('reset');
                                if (data.error == 0) {
                                    toastr.success(data.msg);
                                    p._loadGerarLoteRaspadinha(idAux);
                                } else {
                                    toastr.error(data.msg);
                                }
                            },
                            error: function() {
                                submit.button('reset');
                            }
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
