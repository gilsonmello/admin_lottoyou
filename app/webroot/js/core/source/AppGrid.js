(function(namespace, $) {
	"use strict";

	var AppGrid = function() {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function() {
			o.initialize();
		});
	};
	
	var p = AppGrid.prototype;

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function() {
		this._initDataTables();
	};

	// =========================================================================
	// FUNCTIONS
	// =========================================================================

	p.delete = function(action, onSuccess, onError) {
		// FAZ EFEITO DE PROCESSO ATÉ DELETAR
		var image = $('.btn-group.open').find('i');
		if (image.length){
			image.removeClass('fa-gear');
			image.addClass('fa-spinner');
			image.addClass('fa-spin');
		}

		// VERIFICA SE A FUNÇÃO NÃO FOI PASSADA COMO PARÂMETRO
		if (typeof onSuccess === 'undefined'){
			onSuccess = function(){};
		}

		// VERIFICA SE A FUNÇÃO NÃO FOI PASSADA COMO PARÂMETRO
		if (typeof onError === 'undefined'){
			onError = function(){};
		}

		// DELATA O REGISTRO INFORMADO
        $.post(action, function(json, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                if(json.error == 0){
                	toastr.options.timeOut = 2000;
                    toastr.success(json.msg);
                    onSuccess();
                } else {
                	toastr.options.timeOut = 5000;
                    toastr.error(json.msg);
                    onError();
                }

				if (image.length){
					image.addClass('fa-gear');
					image.removeClass('fa-spinner');
					image.removeClass('fa-spin');
				}
            }
        }, 'json');
	};

	// =========================================================================
	// DATATABLES
	// =========================================================================

	p._initDataTables = function() {
		if (!$.isFunction($.fn.dataTable)) {
			return;
		}
		
		$(document).ready(function() {
		    $('.dataTable').DataTable({
		        ajax: baseUrl+'cidades/index/1',
		        lengthChange: false,
		        searching: false,
		        //paging: false,
		        language: {
		            "decimal": ",",
		            "thousands": ".",
		            "zeroRecords": "",
		            "info": "Página _PAGE_ de _PAGES_",
		            "loading": "Carregando",
			        paginate: {
			            first:      "Primeiro",
			            previous:   "<",
			            next:       ">",
			            last:       "Último"
			        },
		        }
		    });
		});
	};

	// =========================================================================
	namespace.AppGrid = new AppGrid;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
