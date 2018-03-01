(function(namespace, $) {
    "use strict";

    var AppSisConfiguracoes = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppSisConfiguracoes.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppSisConfiguracoes.objectId = '#AppSisConfiguracoes';
    AppSisConfiguracoes.modalFormId = '#nivel3';

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
        $(AppSisConfiguracoes.objectId + ' .hover').hover(function(){
            $(this).addClass('style-primary');
        }, function(){
            $(this).removeClass('style-primary');
        });

        $(AppSisConfiguracoes.objectId + ' .row div div.hover').click(function() {
            var app = $(this).attr('id');
            var url = baseUrl+app;
            var destino = $('#content');
            var history = location.href.split('#')[0];
            var requestJS = $(this).attr('requestJS');

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
                        case 'sisConfiguracoes/permissoes':
                            $.getScript(baseUrl+'js/sge/AppRestrito.js');
                        break;
                        default:
                            if (typeof requestJS !== 'undefined'){
                                $.getScript(baseUrl+'js/sge/'+requestJS+'.js');
                            }
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
        var grid = $('#content section div.section-body div.tab-content, #content section div.section-body div.card');
        var app = 'sisConfiguracoes';
        var url = baseUrl+app;
        var destino = $('#content');
        var history = location.href.split('#')[0];

        grid.css('padding',0);
        grid.html('<div style="padding:24px"></div>');
        window.materialadmin.AppNavigation.carregando(grid.find('div'), 1);
        
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

    window.materialadmin.AppSisConfiguracoes = new AppSisConfiguracoes;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
