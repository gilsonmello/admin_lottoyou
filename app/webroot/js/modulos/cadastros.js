$(function(){
    // INICIA TABS
    window.materialadmin.Demo.initialize();

    // CONTROLA REQUISIÇÃO DE LINKS DO MENU
    $('.link').click(function(){

    	// FAZ A REQUISIÇÃO AJAX
    	window.materialadmin.AppNavigation.ajaxLoad(this, $('#grid'));

    	return false;
    });

    // VERIFICA A URL E REQUISITA PÁGINA AO DAR REFRESH
    var url = location.href;
    var partes = url.split('#');

    if (partes.length > 1){
    	$('a[history=#'+partes[1]+']').click();
    }
});