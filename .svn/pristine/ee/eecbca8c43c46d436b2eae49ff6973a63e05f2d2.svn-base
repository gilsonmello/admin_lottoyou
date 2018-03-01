$(function() {
    var controller = 'contatos';

    // AÇÃO: ADD
    $('#btnCadContato').click(function() {
        $.ajaxSetup({async: false});
        w2popup.load({
            url: baseUrl + controller + '/add',
            width: '730px',
            height: '500px',
            modal: true,
            showMax: true
        });
        $.getScript(baseUrl + 'js/bootstrap-validation.js');
        $.getScript(baseUrl + 'js/form-components.js');
        $.getScript(baseUrl + 'js/forms/contatos.js');
        $.ajaxSetup({async: true});

        return false;
    });

    $(".detalheContato").click(function() {
        var idContato = $(this).attr("contato_id");
        $.ajaxSetup({async: false});
        w2popup.load({
            url: baseUrl + "contatos" + "/view/" + idContato,
            width: '730px',
            height: '525px',
            modal: true,
            showMax: true
        });
        $.getScript(baseUrl + 'js/bootstrap-validation.js');
        $.getScript(baseUrl + 'js/form-components.js');
        $.getScript(baseUrl + 'js/forms/contatos.js');
        $.ajaxSetup({async: true});

    });

});

function buscaContatosCategoria(nameCategoria) {    
    $.ajax({
        type: "GET",
        url: baseUrl + "contatos" + "/index/" + nameCategoria,
        beforeSend: function() {
            w2popup.lock('Processando...', true);
        },
        success: function(data) {
            $("#resFiltro").html(data);
            $.getScript(baseUrl + 'js/forms/contatos.js');
        },
        complete: function() {
            w2popup.unlock();
        }
    });
}