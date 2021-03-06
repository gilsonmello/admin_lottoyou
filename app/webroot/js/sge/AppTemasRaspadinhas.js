(function (namespace, $) {
    "use strict";

    var AppTemasRaspadinhas = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppTemasRaspadinhas.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppTemasRaspadinhas.objectId = '#AppTemasRaspadinhas';
    AppTemasRaspadinhas.modalFormId = '#nivel3';
    AppTemasRaspadinhas.controller = 'temasRaspadinhas';
    AppTemasRaspadinhas.model = 'TemasRaspadinha';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppTemasRaspadinhas.objectId));
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
        $(AppTemasRaspadinhas.objectId + ' #cadastrar').click(function () {
            p._loadFormTemasRaspadinhas();
        });

        $(AppTemasRaspadinhas.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppTemasRaspadinhas.objectId + ' #pesquisar' + AppTemasRaspadinhas.model).submit(function () {
            p._loadConsTemasRaspadinhas();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppTemasRaspadinhas.objectId + ' .demo').click(function () {
            p._previewRaspadinha($(this).attr('id'), true);
        });

        $(AppTemasRaspadinhas.objectId + ' .excluirTema').click(function () {
            var url = baseUrl + 'temasRaspadinhas/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsTemasRaspadinhas();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsTemasRaspadinhas = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppTemasRaspadinhas.objectId + ' #pesquisar' + AppTemasRaspadinhas.model);
        var table = $(AppTemasRaspadinhas.objectId + ' #grid' + AppTemasRaspadinhas.model);
        var url = baseUrl + AppTemasRaspadinhas.controller + '/index';

        window.materialadmin.AppNavigation.carregando(table);

        $.post(url, form.serialize(), function (html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                table.html($(html).find('#' + table.attr('id') + ' >'));

                // CARREGA DEPENDÊNCIAS
                window.materialadmin.AppVendor.initialize();

                // HABILITA BOTÕES DA CONSULTA
                p._habilitaBotoesConsulta();
            }
        }, 'html');
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormTemasRaspadinhas = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppTemasRaspadinhas.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? AppTemasRaspadinhas.controller + '/add' : AppTemasRaspadinhas.controller + '/' + action + '/' + id;

        var url = (typeof id !== 'function') ?
                (typeof id === 'undefined') ? AppTemasRaspadinhas.controller + '/add' : AppTemasRaspadinhas.controller + '/' + action + '/' + id :
                AppTemasRaspadinhas.controller + '/add';

        window.materialadmin.AppForm.loadModal(modalObject, url, '600px', function () {

            $("#teste2").hexColorPicker({
                "container": "dialog",
                "colorModel": "hsl",
                "pickerWidth": 300,
                "size": 15,
                "style": "box",
            });

//            ($(".dropzone").dropzone({
//                url: baseUrl + 'temasRaspadinhas/up/',
//                dictDefaultMessage: 'Arquivo',
//                uploadMultiple: false,
//                maxFilesize: 100,
//                addRemoveLinks: true
//            }));

            $('#fileupload').fileupload({
                url: baseUrl + 'temasRaspadinhas/up/1',
                sequentialUploads: false,
                add: function (e, data) {
                    var uploadErrors = [];
                    var acceptFileTypes = /^image\/(jpg|jpeg)$/i;
                    if (data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
                        uploadErrors.push('É permitido apenas imagem do tipo .JPG para o background!');
                    }
                    if (data.originalFiles[0]['size'].length && data.originalFiles[0]['size'] > 5000000) {
                        uploadErrors.push('O tamanho da imagem não é permitido!');
                    }
                    if (uploadErrors.length > 0) {
                        alert(uploadErrors.join("\n"));
                    } else {
                        data.submit();
                    }
                },
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
//                        $('<p style="color: green;">' + file.name + '<i class="elusive-ok" style="padding-left:10px;"/> - Type: ' + file.type + ' - Size: ' + file.size + ' byte</p>')
//                                .appendTo('#div_files');
                        alert('foi');
                    });
                },
//                fail: function (e, data) {
//                    $.each(data.messages, function (index, error) {
//                        $('<p style="color: red;">Upload file error: ' + error + '<i class="elusive-remove" style="padding-left:10px;"/></p>')
//                                .appendTo('#div_files');
//                    });
//                },
//                progressall: function (e, data) {
//                    var progress = parseInt(data.loaded / data.total * 100, 10);
//
//                    $('#progress .bar').css('width', progress + '%');
//                }
            });

            $('#fileupload2').fileupload({
                url: baseUrl + 'temasRaspadinhas/up/2',
                sequentialUploads: false,
                add: function (e, data) {
                    var uploadErrors = [];
                    var acceptFileTypes = /^image\/(png)$/i;
                    if (data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
                        uploadErrors.push('É permitido apenas imagem do tipo .PNG para a capa!');
                    }
                    if (data.originalFiles[0]['size'].length && data.originalFiles[0]['size'] > 5000000) {
                        uploadErrors.push('O tamanho da imagem não é permitido!');
                    }
                    if (uploadErrors.length > 0) {
                        alert(uploadErrors.join("\n"));
                    } else {
                        data.submit();
                    }
                },
            });

            $('#fileupload3').fileupload({
                url: baseUrl + 'temasRaspadinhas/up/3',
                sequentialUploads: false,
                add: function (e, data) {
                    var uploadErrors = [];
                    var acceptFileTypes = /^image\/(png)$/i;
                    if (data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
                        uploadErrors.push('É permitido apenas imagem do tipo .PNG para a imagem do Index!');
                    }
                    if (data.originalFiles[0]['size'].length && data.originalFiles[0]['size'] > 5000000) {
                        uploadErrors.push('O tamanho da imagem não é permitido!');
                    }
                    if (uploadErrors.length > 0) {
                        alert(uploadErrors.join("\n"));
                    } else {
                        data.submit();
                    }
                },
            });


            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsTemasRaspadinhas();

                    if ((typeof id === 'function')) {
                        id();
                    }
                }
            });

        });
    };

    p._previewRaspadinha = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $('#nivel2');
        var url = 'temasRaspadinhas/demo/' + id;
        var url2 = 'temasRaspadinhas/demo/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '900px', function () {

            var urlCapa;
            var contador = 10;
            window.materialadmin.App.load('AppWscratchPad');
            $('.scratchpad2').wScratchPad('destroy');

            $.ajax({
                url: url2,
                type: "POST",
                dataType: "json",
                async: false,
                beforeSend: function ()
                {

                    $('#14').html('<img id="loading" src="./img/raspadinha/ajax-loader.gif">');
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
                    $('.scratchpad').wScratchPad('enable', false);
                    $('.scratchpad2').each(function () {
                        $('#' + contador).wScratchPad({
                            fg: urlCapa,
                            'cursor': './img/raspadinha/coin.png") 5 5, coin',
                        });
                        contador++;
                    });
                    $('.scratchpad2').wScratchPad('enable', false);
                }
            });




            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsTemasRaspadinhas();

                    if ((typeof id === 'function')) {
                        id();
                    }
                }
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppTemasRaspadinhas = new AppTemasRaspadinhas;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
