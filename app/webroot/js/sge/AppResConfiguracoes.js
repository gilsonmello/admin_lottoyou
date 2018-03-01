(function(namespace, $) {
    "use strict";

    var AppResConfiguracoes = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppResConfiguracoes.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppResConfiguracoes.objectId = '#AppResConfiguracoes';
    AppResConfiguracoes.modalFormId = '#nivel3';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        // INIALIZA EVENTOS DA FUNCIONALIDADE
        p._habilitaEventos();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaEventos = function() {
        $(AppResConfiguracoes.objectId + ' .hover').hover(function(){
            $(this).addClass('style-primary');
        }, function(){
            $(this).removeClass('style-primary');
        });

        $(AppResConfiguracoes.objectId + ' .row div div.hover').click(function() {
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
                    switch(app) {
                        case 'users/restrict':
                            $.getScript(baseUrl+'js/sge/AppRestrito.js');
                        break;
                        default:
                            $.getScript(baseUrl+'js/sge/App'+ucfirst(app)+'.js');
                        break;
                    }

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
        var grid = $('#content section div.section-body div.tab-content');
        var app = 'resConfiguracoes';
        var url = baseUrl+app+'/index';
        var destino = $('#content');
        var history = location.href.split('#')[0];

        window.materialadmin.AppNavigation.carregando(grid, 1);
        
        // REMOVE TOOLTIPS ABERTOS
        $('.tooltip').hide();

        $.post(url, function(html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                destino.html(html);

                // CARREGA SCRIPT DA PÁGINA
                switch(app) {
                    case 'users/restrict':
                        $.getScript(baseUrl+'js/sge/AppRestrito.js');
                    break;
                    default:
                        $.getScript(baseUrl+'js/sge/App'+ucfirst(app)+'.js');
                    break;
                }

                // ALTERA O ENDEREÇO DA BARRA DE FERRAMENTAS 
                window.history.pushState({url: "" + history + ""}, '', baseUrl+app);
            }
        }, 'html');
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppResConfiguracoes = new AppResConfiguracoes;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
