(function (namespace, $) {
    "use strict";

    var AppLeaCups = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLeaCups.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLeaCups.objectId = '#AppLeaCups';
    AppLeaCups.modalFormId = '#nivel2';
    AppLeaCups.controller = 'leaCups';
    AppLeaCups.model = 'LeaCup';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLeaCups.objectId));
        window.materialadmin.AppGrid.initialize();
        window.materialadmin.AppVendor.initialize();
        window.materialadmin.Demo.initialize();

        // CARREGA EVENTOS 
        p._habilitaEventos();
        p._habilitaBotoesConsulta();
        p._habilitaBotoesPaginate();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaBotoesPaginate = function() {
        var grid = $('#gridLeaCups');
        $(AppLeaCups.objectId+' .pagination a').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.ajax({
                url: this.href,
                method: 'get',
                beforeSend: function() {
                    $(AppLeaCups.objectId+' .pagination a').off('click');
                    window.materialadmin.AppNavigation.carregando(grid);
                },
                success: function (data) {
                    grid.html(data);
                    p._habilitaBotoesConsulta();
                    p._habilitaBotoesPaginate();
                },
                error: function (error) {

                }
            });
            return false;
        });
    };

    /**
     *
     * @private
     */
    p._habilitaEventos = function () {

        $(AppLeaCups.objectId + ' #cadastrarLeaCups').click(function () {
            p._loadFormLeaCups();
        });

        $(AppLeaCups.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLeaCups.objectId + ' #pesquisarLeaCups').submit(function () {
            p._loadConsLeaCups();
            return false;
        });

    };

    /**
     *
     * @param id
     * @param btn
     * @private
     */
    p._sortearTimes = function (id, btn) {
        let url = baseUrl + 'leaCups/sortearTimes/' + id;
        $.ajax({
            method: 'post',
            url: url,
            beforeSend: function () {
                if(confirm('Deseja realmente sortear os times?')) {
                    btn.button('loading');
                    return true;
                }
                return false;
            },
            success: function (data) {
                toastr.options.timeOut = 5000;
                if(data.status === 'success') {
                    toastr.success(data.msg);
                    p._loadConsLeaCups();
                } else {
                    toastr.error(data.msg);
                    btn.button('reset');
                }
            },
            error: function (error) {
                btn.button('reset');
            }
        });
    };

    /**
     *
     * @param id
     * @param btn
     * @private
     */
    p._premiar = function (id, btn) {
        let url = baseUrl + 'leaCups/premiar/' + id;
        $.ajax({
            method: 'post',
            url: url,
            beforeSend: function () {
                if(confirm('Deseja realmente continuar?')) {
                    btn.button('loading');
                    return true;
                }
                return false;
            },
            success: function (data) {
                toastr.options.timeOut = 5000;
                if(data.status === 'success') {
                    toastr.success(data.msg);
                    p._loadConsLeaCups();
                } else {
                    toastr.error(data.msg);
                    btn.button('reset');
                }
            },
            error: function (error) {
                btn.button('reset');
            }
        });
    };

    /**
     *
     * @param id
     * @param btn
     * @private
     */
    p._atualizarPontuacao = function (id, btn) {
        let url = baseUrl + 'leaCups/atualizarPontuacao/' + id;
        $.ajax({
            method: 'post',
            url: url,
            beforeSend: function () {
                if(confirm('Deseja realmente atualizar a pontuação?')) {
                    btn.button('loading');
                    return true;
                }
                return false;
            },
            success: function (data) {
                toastr.options.timeOut = 5000;
                if(data.status === 'success') {
                    toastr.success(data.msg);
                    p._loadConsLeaCups();
                } else {
                    toastr.error(data.msg);
                    btn.button('reset');
                }
            },
            error: function (error) {
                btn.button('reset');
            }
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppLeaCups.objectId + ' .btnEditar').click(function () {
            p._loadFormLeaCups($(this).attr('id'));
        });
        $(AppLeaCups.objectId + ' .btnSortearTimes').click(function () {
            p._sortearTimes($(this).attr('id'), $(this));
        });
        $(AppLeaCups.objectId + ' .btnAtualizarPontuacao').click(function () {
            p._atualizarPontuacao($(this).attr('id'), $(this));
        });
        $(AppLeaCups.objectId + ' .btnPremiar').click(function () {
            p._premiar($(this).attr('id'), $(this));
        });
        $(AppLeaCups.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'leaCups/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLeaCups();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLeaCups = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLeaCups.objectId + ' #pesquisarLeaCups');
        var table = $(AppLeaCups.objectId + ' #gridLeaCups');
        var url = baseUrl + 'leaCups/index';

        window.materialadmin.AppNavigation.carregando(table);

        $.get(url, form.serialize(), function (html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                table.html($(html));

                // HABILITA BOTÕES DA CONSULTA
                p._habilitaBotoesConsulta();
                p._habilitaBotoesPaginate();
            }
        }, 'html');
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormLeaCups = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLeaCups.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'leaCups/add' : 'leaCups/' + action + '/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '70%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLeaCups();
                }
            });
        }, undefined, true);
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLeaCups = new AppLeaCups();
}(this.materialadmin, window.jQuery)); // pass in (namespace, jQuery):
