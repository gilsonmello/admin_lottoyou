(function(namespace, $) {
    "use strict";

    var AppGelCadastros = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppGelCadastros.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppGelCadastros.objectId = '#AppGelCadastros';
    AppGelCadastros.modalFormId = '#nivel3';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppVendor.initialize();

        // INIALIZA EVENTOS DA FUNCIONALIDADE
        p._habilitaEventos();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaEventos = function() {
        $(AppGelCadastros.objectId + ' .hover').hover(function(){
            $(this).addClass('style-primary');
        }, function(){
            $(this).removeClass('style-primary');
        });
        $(AppGelCadastros.objectId + ' .hover2').hover(function(){
            $(this).addClass('style-primary');
        }, function(){
            $(this).removeClass('style-primary');
        });

        $(AppGelCadastros.objectId + ' .row div div.hover').click(function() {
            var app = $(this).attr('id');
            var url = baseUrl+app+'/index';
            var destino = $('#content');
            var history = location.href.split('#')[0];

            window.materialadmin.AppNavigation.carregando($('.card-body'));
            
            // REMOVE TOOLTIPS ABERTOS
            $('.tooltip').hide();

            $.post(url, function(html, textStatus, jqXHR) {
                if (jqXHR.status == 200) {
                    // RECARREGA FORMULÁRIO
                    destino.html(html);

                    // CARREGA SCRIPT DA PÁGINA
                    $.getScript(baseUrl+'js/sge/App'+ucfirst(app)+'.js');

                    // ALTERA O ENDEREÇO DA BARRA DE FERRAMENTAS 
                    window.history.pushState({url: "" + history + ""}, '', baseUrl+app);
                }
            }, 'html');

            return false;
        });
        
        $(AppGelCadastros.objectId + ' .row div div.hover2').click(function() {
            var app = $(this).attr('id');
            var sec = $(this).attr('sec');
            var url = baseUrl+app+sec;
            var destino = $('#content');
            var history = location.href.split('#')[0];

            window.materialadmin.AppNavigation.carregando($('.card-body'));
            
            // REMOVE TOOLTIPS ABERTOS
            $('.tooltip').hide();

            $.post(url, function(html, textStatus, jqXHR) {
                if (jqXHR.status == 200) {
                    // RECARREGA FORMULÁRIO
                    destino.html(html);

                    // CARREGA SCRIPT DA PÁGINA
                    $.getScript(baseUrl+'js/sge/App'+ucfirst(app)+'.js');

                    // ALTERA O ENDEREÇO DA BARRA DE FERRAMENTAS 
                    window.history.pushState({url: "" + history + ""}, '', baseUrl+app);
                }
            }, 'html');

            return false;
        });
    };

    // =========================================================================
    // FUNÇÕES EXTERNAS
    // =========================================================================

    p.carregarCadastros = function() {
        var grid = $('#content section div.section-body div.card');
        var app = 'gelCadastros';
        var url = baseUrl+app+'/index';
        var destino = $('#content');
        var history = location.href.split('#')[0];

        grid.html('<div style="padding:24px"></div>');
        window.materialadmin.AppNavigation.carregando(grid.find('div'), 1);
        
        // REMOVE TOOLTIPS ABERTOS
        $('.tooltip').hide();

        $.post(url, function(html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                destino.html(html);

                // CARREGA SCRIPT DA PÁGINA
                $.getScript(baseUrl+'js/sge/App'+ucfirst(app)+'.js');

                // ALTERA O ENDEREÇO DA BARRA DE FERRAMENTAS 
                window.history.pushState({url: "" + history + ""}, '', baseUrl+app);
            }
        }, 'html');
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppGelCadastros = new AppGelCadastros;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
