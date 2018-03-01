$(function() {
    // INICIA VARIÁVEIS
    var controller = 'EstMovimentacoes';
    
    $.ajax({
        type: "GET",
        url: baseUrl + controller + "/index/1",        
        success: function(data) {
            $('#resEstoque').html(data);
        },
        complete: function() {
            $.getScript(baseUrl + 'js/forms/estoques.js');
        }
    });

    // AÇÃO: ADD PRODUTO ESTOQUE
    $('#addNovoProduto').click(function() {
        $('#formulario .modal-content').load(baseUrl + 'estProdutos' + '/add', function() {
            $('#formulario').modal({show: false, keyboard: false});
            $('#formulario').modal('show');
            $.getScript(baseUrl + 'js/bootstrap-validation.js');
            $.getScript(baseUrl + 'js/form-components.js');
            $.getScript(baseUrl + 'js/forms/financeiros.js');
        });
        return false;
    });
    // AÇÃO: ADD
    $('#addNovo').click(function() {
        $('#formulario .modal-content').load(baseUrl + controller + '/add', function() {
            $('#formulario').modal({show: false, keyboard: false});
            $('#formulario').modal('show');
            $.getScript(baseUrl + 'js/bootstrap-validation.js');
            $.getScript(baseUrl + 'js/form-components.js');
            $.getScript(baseUrl + 'js/forms/financeiros.js');
        });
        return false;
    });


});