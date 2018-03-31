(function (namespace, $) {
    "use strict";

    var AppForm = function () {
        // Create reference to this instance
        var o = this;
        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };
    var p = AppForm.prototype;

    // =========================================================================
    // VARIABLES
    // =========================================================================

    // Constants
    AppForm.HAS_CHANGES = 1;
    AppForm.NO_CHANGES = 0;

    // Initial form state
    AppForm.formState = AppForm.NO_CHANGES;

    // Last ID inserted
    AppForm.lastInsertID = null;

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function (divForm, onSuccess, files) {

        // Init events
        this._enableEvents();

        this._initInputMask();
        this._initDatePicker();
        this._initMultiSelect();
        this._initSelect2();
        this._initChosen();

        this._initButtonStates();
        this._initRadioAndCheckbox();
        this._initFloatingLabels();
        this._initRequired(divForm);

        this._initTinyMCE(divForm);

        p._initFormValidation(divForm, onSuccess, files);
    };

    // =========================================================================
    // LOAD MODAL
    // =========================================================================

    p.loadModal = function (divForm, url, width, scripts, files) {

        if (!$.isFunction($.fn.modal)) {
            return;
        }

        if (typeof url === 'undefined') {
            url = false;
        } else {
            if (baseSub !== '/') {
                url = url.replace(baseSub, '');
            }
            if (url[0] === '/') {
                url = url.replace('/', '');
            }
        }

        if (typeof width === 'undefined') {
            width = '500px';
        }

        divForm.find('.modal-dialog').css('width', width);
        if (window.materialadmin.App.isBreakpoint('xs') || window.materialadmin.App.isBreakpoint('sm')) {
            divForm.find('.modal-dialog').css('width', '92%');
        }

        // REMOVE TOOLTIPS ABERTO
        $('.tooltip').hide();

        // CONFIGURA O ESTADO DO FORMULÁRIO
        this.setFormState(AppForm.NO_CHANGES);

        // CONFIGURA  MODAL
        divForm.find('.modal-content').html('<section><div class="section-body alert alert-callout alert-warning" role="alert"><strong>Carregando...</strong> <i class="fa fa-spinner fa-spin"></i></div></section>');
        divForm.modal('show');
        //divForm.find('.modal-backdrop').css('z-index', $('.modal-backdrop').length-1);

        // CARREGA O FORMULÁRIO
        if (url !== false)
            divForm.find('.modal-content').load(baseUrl + url, function () {
                // CONFIGURA O MODAL
                divForm.modal({show: false, keyboard: true});

                // INICIALIZA DEPENDÊNCIAS
                window.materialadmin.AppForm.initialize(divForm, undefined, files);
                window.materialadmin.AppVendor.initialize();

                // VERIFICA SE HÁ SCRIPTS PARA SEREM RODADOS APÓS O CARREGAMENTO
                if (typeof scripts !== 'undefined') {
                    scripts();
                }

                // AJUSTA MODAL BACKDROP POR CONTA DO SCROLL
                divForm.find('.modal-backdrop').css('right', getScrollBarWidth());
            });

        // CASO A RESULÇÃO SEJA REDUZIDA O MODAL É AJUSTADO
        $(window).on('resize', function (e) {
            var isXS = window.materialadmin.App.isBreakpoint('xs');
            var isSM = window.materialadmin.App.isBreakpoint('sm');
            var tempWidth = (isXS || isSM) ? 'auto' : width;
            divForm.find('.modal-dialog').css('width', tempWidth);
            divForm.find('.modal-backdrop').css('right', getScrollBarWidth());
        });
    };

    // =========================================================================
    // LOAD GRID
    // =========================================================================

    p.loadGrid = function (gridObject, targetUrl, formObject, scripts) {
        // EXIBE CARREGANDO
        window.materialadmin.AppNavigation.carregando(gridObject);

        // TRAPA PASSAGEM DE PARAMETROS
        scripts = (typeof formObject === 'function') ? formObject : scripts;

        // VERIFICA SE FOI PASSANDO 
        var params = (typeof formObject !== 'undefined' && typeof formObject !== 'function') ? formObject.serialize() : {};

        // FAZ A CONSULTA
        $.post(baseUrl + targetUrl, params, function (html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                gridObject.html($(html).find('#' + gridObject.attr('id') + ' >'));

                // RODA SCRIPT
                scripts();
            }
        }, 'html');
    };

    // =========================================================================
    // FORM ATUALIZA SELECT
    // =========================================================================

    p.updateSelectField = function (controller, selectObject, params, selectLastId, groupPath) {
        // INICIALIZA VARIÁVEIS
        var url = (controller.split('/').length > 1) ? baseUrl + controller : baseUrl + controller + '/listSelectOptions';
        var val = selectObject.val();
        var novo_id = '';

        // VERIFICA SE FORAM PASSADOS PARÂMETROS
        if (typeof params === 'undefined') {
            params = {'active': 1};
        }

        // VERIFICA SE FORAM PASSADOS PARÂMETROS
        if (typeof groupPath !== 'undefined') {
            params.groupPath = groupPath;
        }

        // DESABILITA O CAMPO DE DESTINO E EXIBE MENSAGEM DE PROCESSANDO
        if (selectObject.hasClass('chosen')) {
            selectObject.chosen('destroy');
        }

        selectObject.empty();
        selectObject.append('<option>CARREGANDO...</option>');

        // FAZ A REQUISIÇÃO DOS DADOS
        $.post(url, params, function (json, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                selectObject.empty();
                selectObject.append('<option value="">Selecione</option>');

                if (json.dados.length > 0) {
                    $.each(json.dados, function (i, dado) {
                        if (typeof dado.nome === 'object') {
                            selectObject.append('<optgroup label="' + dado.id + '"></optgroup>');
                            var lastOptGroup = selectObject.find('optgroup:last');
                            $.each(dado.nome, function (i2, dado2) {
                                lastOptGroup.append('<option value="' + i2 + '">' + dado2 + '</option>');
                                if (dado2 > novo_id) {
                                    novo_id = dado2;
                                }
                            });
                        } else {
                            selectObject.append('<option value="' + dado.id + '">' + dado.nome + '</option>');
                            if (dado.id > novo_id) {
                                novo_id = dado.id;
                            }
                        }
                    });
                } else {
                    selectObject.empty();
                    selectObject.append('<option>Nenhum resultado encontrado</option>');
                }

                selectObject.css('width', '100%');

                if (val != '' && val != 'Selecione') {
                    selectObject.val(val);
                } else {
                    if (typeof selectLastId !== 'undefined') {
                        selectObject.val(novo_id);
                    }
                }

                if (selectObject.hasClass('chosen')) {
                    selectObject.chosen({search_contains: true});
                }
            } else {
                selectObject.empty();
                selectObject.append('<option>Nenhum resultado encontrado</option>');
            }
        }, 'json');
    };

    // =========================================================================
    // FORM STATE
    // =========================================================================

    p.getFormState = function () {
        return AppForm.formState;
    };

    p.setFormState = function (state) {
        AppForm.formState = state;
    };


    // =========================================================================
    // LAST ID
    // =========================================================================

    p.checkLastInsertID = function (result) {
        var html = $(result);
        var field = html.find('#AuxLastInsertID');

        if (typeof field !== 'undefined') {
            p.setLastInsertID(field.val());
        }
    };

    p.setLastInsertID = function (id) {
        AppForm.lastInsertID = id;
    };

    p.getLastInsertID = function () {
        return AppForm.lastInsertID;
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._enableEvents = function () {
        var o = this;

        // Link submit function
        $('[data-submit="form"]').on('click', function (e) {
            e.preventDefault();
            var formId = $(e.currentTarget).attr('href');
            $(formId).submit();
        });

        // Init textarea autosize
        $('textarea.autosize').on('focus', function () {
            $(this).autosize({append: ''});
        });
    };

    // =========================================================================
    // InputMask
    // =========================================================================

    p._initInputMask = function () {
        if (!$.isFunction($.fn.setMask) && !$.isFunction($.fn.priceFormat)) {
            return;
        }


        $('input.medida').priceFormat({prefix: '', centsSeparator: ',', limit: 3, centsLimit: 1});
        $('input.peso').setMask({mask: '9,999'});
        $('input.integer').inputmask({
            "mask": "9", 
            "repeat": 15, 
            "greedy": false
        });

        $('input.money-br').maskMoney({
            prefix:'R$ ', 
            allowNegative: false, 
            thousands:'.', 
            decimal:',', 
            affixesStay: false
        });

        $('input.decimal').setMask({mask: '99'});
        $('input.porcentagem').inputmask({mask: '9[9].99'});
        $('input.centena').setMask({mask: '999'});
        $('input.kg').priceFormat({prefix: '', centsSeparator: ',', thousandsSeparator: '', limit: 5, centsLimit: 2});
        $('input.altura').setMask({mask: '9,99'}).css('text-align', 'left');
        $('input.ramal').setMask({mask: '9999', autoTab: false});
        $('input.pis').setMask({mask: '999.9999.999-9', autoTab: false});
        $('input.rg').setMask({mask: '99-999.999.99', autoTab: false, type: 'reverse'}).css('text-align', 'left');
        $('input.cpf').setMask({mask: '999.999.999-99', autoTab: false});
        $('input.cnpj').setMask({mask: '99.999.999/9999-99', autoTab: false});
        $('input.date').setMask({mask: '99/99/9999', autoTab: false});
        $('input.fone').setMask({mask: '(99) 9999-99999', autoTab: false}).on('keyup', function (event) {
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unsetMask();
            if (phone.length > 10) {
                element.setMask({mask: '(99) 99999-9999', autoTab: false});
            } else {
                element.setMask({mask: '(99) 9999-99999', autoTab: false});
            }
        });
        
        $('input.hora').setMask({ mask: '99:99:99',autoTab: false});
        $('input.cep').setMask({mask: '99.999-999', autoTab: false});
        $('input.money').priceFormat({prefix: '$ ', centsSeparator: ',', thousandsSeparator: '.'});
        $('input.moneyWithouPrefix').priceFormat({prefix: '', centsSeparator: ',', thousandsSeparator: '.'});
        //$('input.money').setMask({mask:'99,999.999.999', autoTab:false, type:'reverse'}).css('text-align','left');
        $('input.money3').setMask({
            mask: '999,999.999.999', 
            autoTab: false, 
            type: 'reverse'
        }).css('text-align', 'left');

        $('input.money4').setMask({mask: '9999,999.999.999', autoTab: false, type: 'reverse'}).css('text-align', 'left');

        $('input.number').setMask({mask: '999.999', autoTab: false, type: 'reverse'}).css('text-align', 'left');
        $('input.double').setMask({mask: '9.99', }).css('text-align', 'left');
        $('input.quantidade').priceFormat({prefix: '', centsSeparator: ',', thousandsSeparator: '.'});
        $('input.hora').setMask({mask: '99:99:99', autoTab: false});
        var quantidade0 = $('input.quantidade0');
        if (quantidade0.length) {
            $.each(quantidade0, function (i, o) {
                $(o).val(parseInt($(o).val()));
                $(o).priceFormat({prefix: '', centsSeparator: '', thousandsSeparator: '.', centsLimit: 0});
            });
        }

        var quantidade1 = $('input.quantidade1');
        if (quantidade1.length) {
            $.each(quantidade1, function (i, o) {
                $(o).val($(o).val() * 10);
                $(o).priceFormat({prefix: '', centsSeparator: ',', thousandsSeparator: '.', centsLimit: 1});
            });
        }
    };

    // =========================================================================
    // Date Picker
    // =========================================================================

    p._initDatePicker = function () {
        if (!$.isFunction($.fn.datepicker)) {
            return;
        }

        $('.date').datepicker({autoclose: true, todayHighlight: true, format: "dd/mm/yyyy", todayBtn: "linked", language: "pt-BR"}).on('changeDate', function (e) {
            p._validateField($(this))
        });
        $('.date-endDate-today').datepicker({endDate: "0d", autoclose: true, todayHighlight: true, format: "dd/mm/yyyy", todayBtn: "linked", language: "pt-BR"}).on('changeDate', function (e) {
            p._validateField($(this))
        });
        $('.date-month').datepicker({autoclose: true, todayHighlight: true, format: "mm/yyyy", minViewMode: 1, todayBtn: "linked", language: "pt-BR"}).on('changeDate', function (e) {
            p._validateField($(this))
        });
        $('.date-years').datepicker({autoclose: true, todayHighlight: true, startView: 1, minViewMode: 2, todayBtn: "linked", language: "pt-BR"}).on('changeDate', function (e) {
            p._validateField($(this))
        });
        $('.date-format').datepicker({autoclose: true, todayHighlight: true, format: "dd/mm/yyyy", language: "pt-BR"}).on('changeDate', function (e) {
            p._validateField($(this))
        });
        $('.date-range').datepicker({todayHighlight: true, language: "pt-BR"}).on('changeDate', function (e) {
            p._validateField($(this))
        });
        $('.date-inline').datepicker({todayHighlight: true, format: "dd/mm/yyyy", startView: 2, minViewMode: 1, todayBtn: "linked", language: "pt-BR"});
        $('.date-month-inline').datepicker({todayHighlight: true, format: "mm/yyyy", minViewMode: 1, todayBtn: "linked", language: "pt-BR"}).on('changeDate', function (e) {
            p._validateField($(this))
        });
    };

    p._validateField = function (objectField) {
        var form = objectField.closest('form');
        if (typeof form.data('bootstrapValidator') !== 'undefined') {
            //form.bootstrapValidator('revalidateField', objectField.attr('name'));
            objectField.closest('div').find('.text-danger').remove();
        }
    }

    // =========================================================================
    // MultiSelect
    // =========================================================================

    p._initMultiSelect = function () {
        if (!$.isFunction($.fn.multiSelect)) {
            return;
        }

        $('select[multiple=multiple]:not(.chosen)').multiSelect({
            selectableHeader: "<input type='text' class='search-input form-control' style='margin-bottom:2px;' autocomplete='off' placeholder='Digite para filtrar'>",
            selectionHeader: "<input type='text' class='search-input form-control' style='margin-bottom:2px;' autocomplete='off' placeholder='Digite para filtrar'>",
            afterInit: function (ms) {
                var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function (e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function (e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
            },
            afterSelect: function () {
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function () {
                this.qs1.cache();
                this.qs2.cache();
            }
        });
    };

    // =========================================================================
    // SELECT2
    // =========================================================================

    p._initSelect2 = function () {
        if (!$.isFunction($.fn.select2)) {
            return;
        }
        //$(".select2").select2({allowClear: true});
    };

    // =========================================================================
    // CHOSEN
    // =========================================================================

    p._initChosen = function () {
        if (!$.isFunction($.fn.chosen)) {
            return;
        }

        $("select[multiple!=multiple].chosen").chosen({
            width: '100%',
            no_results_text: 'Nenhum resultado para:',
            placeholder_text_single: 'Selecione',
            noMatchesFound: 'Nenhum resultado para:',
            allow_single_deselect: true,
            search_contains: true
        });

        $("select[multiple=multiple].chosen").multipleSelect({
            placeholder: "Selecione um ou vários",
            selectAllText: 'Todos',
            allSelected: 'Todos',
            width: '100%',
            filter: true
        });
    };

    // =========================================================================
    // BUTTON STATES (LOADING)
    // =========================================================================

    p._initButtonStates = function () {
        /*$('.btn-loading-state').click(function () {
         var btn = $(this);
         btn.button('loading');
         setTimeout(function () {
         btn.button('reset');
         }, 3000);
         });*/
    };

    // =========================================================================
    // FORMATA CAMPOS REQUIRED
    // =========================================================================

    p._initRequired = function (divForm) {

        var formInputs = (typeof divForm !== 'undefined') ?
                divForm.find('input:required, select:required, textarea:required') :
                $('input:required, select:required, textarea:required');

        formInputs.each(function () {
            var o = $(this).parents('.form-group, .required').find('label:first');
            o.html(o.html() + '<span style="color:red;">*</span>');
        });

        var aux = 1;
        var formRadios = (typeof divForm !== 'undefined') ?
                divForm.find('fieldset input[type=radio]:required') :
                $('fieldset input[type=radio]:required');

        formRadios.each(function () {
            if (aux == 1) {
                var o = $(this).parents('fieldset').find('legend:first');
                if (o.find('em').length == 0) {
                    o.html(o.html() + '<em style="color:red;">*</em>');
                }
                aux = 0;
            } else {
                aux = 1;
            }
        });
    };

    // =========================================================================
    // CARREGA PLUGIN PARA CAMPOS TEXTOS COM FORMATAÇÃO
    // =========================================================================

    p._initTinyMCE = function (divForm) {
        if (!$.isFunction($.fn.tinymce)) {
            return;
        }

        $(document).on('focusin', function (e) {
            if ($(e.target).closest(".mce-window").length) {
                e.stopImmediatePropagation();
            }
        });

        $('.tinymce').tinymce({
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code '
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code preview fullscreen',
        });
    }

    // =========================================================================
    // RADIO AND CHECKBOX LISTENERS
    // =========================================================================

    p._initRadioAndCheckbox = function () {
        // Add a span class the styled checkboxes and radio buttons for correct styling
        $('.checkbox-styled input, .radio-styled input').each(function () {
            if ($(this).next('span').length === 0) {
                $(this).after('<span></span>');
            }

            $(this).click(function () {
                $(this).closest('div').find('.text-danger').remove();
                $(this).closest('div').removeClass('has-error');
            });
        });
    };

    // =========================================================================
    // FLOATING LABELS
    // =========================================================================

    p._initFloatingLabels = function () {
        var o = this;

        $('.floating-label .form-control').on('keyup change', function (e) {
            var input = $(e.currentTarget);

            if ($.trim(input.val()) !== '') {
                input.addClass('dirty').removeClass('static');
            } else {
                input.removeClass('dirty').removeClass('static');
            }
        });

        $('.floating-label .form-control').each(function () {
            var input = $(this);

            if ($.trim(input.val()) !== '') {
                input.addClass('static').addClass('dirty');
            }
        });

        $('.form-horizontal .form-control').each(function () {
            $(this).after('<div class="form-control-line"></div>');
        });
    };

    // =========================================================================
    // VALIDATION
    // =========================================================================

    p._initFormValidation = function (divForm, onSuccess, files) {
        // VERIFICA SE EXISTE O PLUGIN
        if (!$.isFunction($.fn.bootstrapValidator)) {
            return;
        }

        // VERIFICA SE FOI INFORMADO O ESCOPO DE TRABALHO
        if (typeof divForm === 'undefined') {
            return;
        }

        // INICIALIZA VARIÁVEIS
        var form = divForm.find('form.form-validate:not(.dropzone)');
        var submit = divForm.find('button[type="submit"]');

        form.bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                validating: 'glyphicon glyphicon-refresh'
            },
            onSuccess: function (e) {
                // PREVENT FORM SUBMISSION
                e.preventDefault();

                // GET THE FORM INSTANCE
                var $form = $(e.target);

                // GET THE BOOTSTRAPVALIDATOR INSTANCE
                var bv = $form.data('bootstrapValidator');

                // PREVINE QUE O USUÁRIO CLIQUE MAIS DE UMA VEZ NO BOTÃO
                submit.button('loading');
                //materialadmin.AppCard.addCardLoader(form);
                var contentType = files != undefined && files === true ? 
                    false : 
                    'application/x-www-form-urlencoded; charset=UTF-8';
                $.ajax({
                    method: 'post',
                    url: $form.attr('action'),
                    data: files != undefined && files === true ? new FormData($form[0]) : $form.serialize(),
                    cache: files != undefined && files === true ? false : true,
                    contentType: contentType,
                    processData: files != undefined && files === true ? false : true,
                    beforeSend: function() {

                    },
                    success: function(result) {

                        // VERIFICA SE O CAKE RETORNOU ERROS E EXÍBE-OS
                        // CASO CONTRÁRIO FECHA O MODAL
                        if (p._checkErros(result)) {
                            p._showErros(result, bv);
                            submit.button('reset');
                            //materialadmin.AppCard.removeCardLoader(form);
                        } else {
                            p.setFormState(AppForm.HAS_CHANGES);
                            p.checkLastInsertID(result);
                            submit.button('reset');
                            divForm.modal('hide');

                            // EXECUTA FUNÇÃO APÓS SUCESSO
                            if (typeof onSuccess !== 'undefined')
                                onSuccess();
                        }
                    },
                    error: function(data) {
                        submit.button('reset');
                    }
                });
                // Use Ajax to submit form data
                /*$.post($form.attr('action'), $form.serialize(), function (result, textStatus, jqXHR) {
                    if (jqXHR.status == 200) {
                        // VERIFICA SE O CAKE RETORNOU ERROS E EXÍBE-OS
                        // CASO CONTRÁRIO FECHA O MODAL
                        if (p._checkErros(result)) {
                            p._showErros(result, bv);
                            submit.button('reset');
                            //materialadmin.AppCard.removeCardLoader(form);
                        } else {
                            p.setFormState(AppForm.HAS_CHANGES);
                            p.checkLastInsertID(result);
                            submit.button('reset');
                            divForm.modal('hide');

                            // EXECUTA FUNÇÃO APÓS SUCESSO
                            if (typeof onSuccess !== 'undefined')
                                onSuccess();
                        }
                    }
                }, 'html');*/
            },
            onError: function (e) {
                submit.attr('disabled', 'disabled');
                //materialadmin.AppCard.removeCardLoader(form);
            }
        }).on('success.field.bv', function (e, data) {
            // REMOVE MENSAGEM DE ERRO GERADA PELO CAKE CASO EXISTA
            data.element.parent().find('span.help-block').remove();
            data.element.closest('.has-error').removeClass('has-error');

            // HABILITA O CAMPO
            if (data.bv.getInvalidFields().length > 0) {
                submit.attr('disabled', 'disabled');
            } else {
                submit.removeAttr('disabled');
            }
        }).on('error.field.bv', function (e, data) {
            // REMOVE MENSAGEM DE ERRO GERADA PELO CAKE CASO EXISTA
            data.element.parent().find('span.help-block').remove();
        });
    };

    p._checkErros = function (html) {
        // INICIA VARIÁVEIS
        var o = $(html).find('.alert');
        var error = 1;
        o.find('a').hide();

        // VERIFICA TIPO DA MENSAGEM E EXIBE MENSAGEM
        if (o.hasClass('alert-success')) {
            toastr.options.timeOut = 2000;
            toastr.success(o.html());
            error = 0;
        } else {
            toastr.options.timeOut = 7000;
            toastr.error(o.html());
        }

        return error;
    };

    p._showErros = function (result, bv) {
        $('.has-error').removeClass('has-error');
        // INICIA VARIÁVEIS
        var html = $(result);
        var htmlErros = html.find('.form-error');
        var listErros = {};
        var fieldErrors = $('.has-error');
        var messageErrors = $('span.text-danger');
        var form = $('#' + html.find('form').attr('id'));

        // REMOVE ERROS
        //fieldErrors.removeClass('has-error').addClass('has-success');
        messageErrors.remove();

        // VERIFICA SE HÁ ERROS
        if (htmlErros.length) {
            // IDENTIFICA OS ELEMENTOS QUE POSSUEM ERRO
            $(htmlErros).each(function (k, v) {
                var obj = $(v);

                switch (obj.prop("tagName")) {
                    case 'TEXTAREA':
                    case 'SELECT':
                    case 'INPUT':
                        listErros[obj.attr('id')] = obj.closest('div').find('span.text-danger').html();
                        break;
                    case 'LABEL':
                        listErros[obj.closest('fieldset').find('input:checked').attr('id')] = obj.closest('div').find('span.text-danger').html();
                        break;
                }
            });

            // EXIBE OS ERROS NOS ELEMENTOS CORRESPONDENTES
            $.each(listErros, function (id, msg) {
                var obj = $(form).find('[id=' + id + ']');
                var id = obj.attr('id');
                var div = obj.closest('div');
                var style = (div.find('fieldset').length) ? 'margin-left: 12px;' : '';

                div.removeClass('has-success').addClass('has-error');
                div.find('.text-danger').remove();
                div.append('<span class="help-block text-danger" style="' + style + '">' + msg + '</span>');
            });

            // COLOCA O FOCO NO PRIMEIRO CAMPO COM ERRO
            var x = window.scrollX;
            var y = window.scrollY;
            $('.has-error:first').find('input').focus();
            $('.modal:visible').animate({scrollTop: $('.has-error:first').find('input').offset().top}, 0);
            window.scrollTo(x, y);

            // TODO: TRATAR EXIBIÇÃO DE ERRO QUANDO CHOSEN
        }
    };

    p._dataAtual = function () {
        var currentTime = new Date()
        var day = currentTime.getDate();
        var mes = currentTime.getMonth() + 1;
        if (mes.toString().length == 1)
            mes = "0" + mes;
        var year = currentTime.getFullYear();

        return day + "/" + mes + "/" + year;
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppForm = new AppForm;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):