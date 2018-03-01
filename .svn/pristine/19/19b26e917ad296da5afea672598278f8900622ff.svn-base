// CONTROLA OS ERROS DE TODOS OS AJAX E EXIBE OS ERROS NA TELA
$(document).ajaxError(function(event, jqXHR, settings) {
    // CASO ENCONTRE A CLASSE getCakeError EEXIBE O ERRO NA TELA
    var debug = $(jqXHR.responseText).find('.getCakeError').length;
    var requestedUrl = settings.url;
    var status = jqXHR.status;
    var textStatus = jqXHR.statusText;
    var html = '';

    // REMOVE O BLOQUEIO DE TELA
    w2popup.unlock();
    
    // EXIBE QUE O AJAX FOI CANCELADO 
    if(status == 304) { 
        var name = event.currentTarget.activeElement.text;
        toastr.options.timeOut = 5000;
        toastr.error('<b>Atenção!</b> A requisição foi cancela inexperadamente.');

        if (debug){
            html += '<p style="font-weight:bold; font-size:14px;">URL Requesitada: '+requestedUrl+'</p>';
            html += $(jqXHR.responseText).find('.getCakeError').html();

            w2popup.open({
                title: 'Ocorreu um erro interno.',
                body: html,
                width: '700px',
                height: '450px',
                modal: true,
                showMax: true
            });

            console.log(event);
            console.log(settings);
        }
    }

    // EXIBE QUE A SESSÃO CAIU E QUE SERÁ NECESSÁRIO RETORNAR PARA FAZER O LOGIN
    if(status == 403) { 
        toastr.options.timeOut = 5000;
        toastr.error('<b>Atenção!</b> :( Sua sessão encerrou. Será necessário fazer login novamente. Voçê será recirecionado automaticamente. ');
        setTimeout(function(){
            window.location = baseUrl+'users/login';
        }, 1000);
    }

    // EXIBE MENSAGEM INFORMANDO QUE A PÁGINA ESTÁ EM DESENVOLVIMENTO, POIS NÃO FOI ENCONTRADA
    if(status == 404 || textStatus == 'Not Found') { 
        var name = event.currentTarget.activeElement.text;
        toastr.options.timeOut = 5000;
        toastr.error('<b>Atenção!</b> A funcionalidade <b>'+name+'</b> encontra-se em manutenção');
        $('.page-title').html(name+' em manutenção.');

        if (debug){
            html += '<p style="font-weight:bold; font-size:14px;">URL Requesitada: '+requestedUrl+'</p>';
            html += $(jqXHR.responseText).find('.getCakeError').html();

            w2popup.open({
                title: 'Ocorreu um erro interno.',
                body: html,
                width: '700px',
                height: '450px',
                modal: true,
                showMax: true
            });

            console.log(event);
            console.log(settings);
        }
    }

    // EXIBE QUE OCORREU UM ERRO INTERNO
    if(status == 500) { 
        toastr.options.timeOut = 5000;
        toastr.error('<b>Atenção!</b> Ocorreu um erro interno. Favor tentar novamente, caso o problema persista abra um chamado.');

        if (debug){
            html += '<p style="font-weight:bold; font-size:14px;">URL Requesitada: '+requestedUrl+'</p>';
            html += $(jqXHR.responseText).find('.getCakeError').html();

            w2popup.open({
                title: 'Ocorreu um erro interno.',
                body: html,
                width: '700px',
                height: '450px',
                modal: true,
                showMax: true
            });

            console.log(event);
            console.log(settings);
        }
    }
});

$(document).ajaxComplete(function(event, jqXHR, settings) {
    
    // EXIBE MENSAGEM DE NÃO AUTORIZADO QUANDO AJAX É EXECUTADO
    if(jqXHR.status == 200) {
        // VERIFICA SE NA TELA EXISTE O OBJETO PARA FUNCIONALIDADE NÃO AUTORIZADA
        var naoAutorizado = $('section#naoAutorizado');
        if (naoAutorizado.length == 0) {
            // VERIFICA SE NA PÁGINA REQUISITADA EXISTE O OBJETO PARA 
            // FUNCIONALIDADE NÃO AUTORIZADA
            var resquestedPage = $.parseHTML(jqXHR.responseText);
            var naoAutorizado = $(resquestedPage).find('#naoAutorizado');
            if (naoAutorizado.length){
                var modalObject = $('#nivel3');
                modalObject.find('.modal-dialog').css('width', '600px');
                modalObject.find('.modal-content').html(jqXHR.responseText);
                modalObject.modal('show');
            }
        }

        // VERIFICA SE O O BLOQUEIO DE TELA FOI ATIVADO
        // SE SIM EXIGE A SENHA, CASO CONTRÁRIO VAI PRO LOGIN
        var lock = $('section#AppLock');
        if (lock.length) {
            var modalObject = lock.closest('.modal');
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function() {
                if (window.materialadmin.AppForm.getFormState() == 0){
                    if ($('section#AppLock').length){
                        toastr.options.timeOut = 5000;
                        toastr.error('<b>Atenção!</b> :( Sua sessão encerrou. Será necessário fazer login novamente. Voçê será recirecionado automaticamente. ');
                        setTimeout(function(){
                            window.location = baseUrl+'users/login';
                        }, 1000);
                    }
                } else {
                    modalObject.find('.modal-content').html('');
                }
            });
        }
    }
});