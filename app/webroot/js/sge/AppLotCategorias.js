(function (namespace, $) {
    "use strict";

    var AppLotCategorias = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppLotCategorias.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppLotCategorias.objectId = '#AppLotCategorias';
    AppLotCategorias.modalFormId = '#nivel3';
    AppLotCategorias.controller = 'lotCategorias';
    AppLotCategorias.model = 'LotCategoria';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppLotCategorias.objectId));
        window.materialadmin.AppGrid.initialize();
        window.materialadmin.AppVendor.initialize();
        window.materialadmin.Demo.initialize();

        // CARREGA EVENTOS 
        p._habilitaEventos();
        p._habilitaBotoesConsulta();
    };

    // =========================================================================
    // EVENTS
    // =========================================================================

    p._habilitaEventos = function () {
        $(AppLotCategorias.objectId + ' #cadastrarLotCategoria').click(function () {
            p._loadFormLotCategoria();
        });

        $(AppLotCategorias.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppLotCategorias.objectId + ' #pesquisarLotCategoria').submit(function () {
            p._loadConsLotCategoria();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppLotCategorias.objectId + ' .btnEditar').click(function () {
            p._loadFormLotCategoria($(this).attr('id'));
        });

        $(AppLotCategorias.objectId + ' .btnPremio').click(function () {
            p._loadFormPremio($(this).attr('id'));
        });

        $(AppLotCategorias.objectId + ' .btnAddImagemLotCategoria').click(function () {
            p._loadCarregarImagem($(this).attr('id'))
        });

        $(AppLotCategorias.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'lotCategorias/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsLotCategoria();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsLotCategoria = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppLotCategorias.objectId + ' #pesquisarLotCategoria');
        var table = $(AppLotCategorias.objectId + ' #gridLotCategorias');
        var url = baseUrl + 'lotCategorias/index';

        window.materialadmin.AppNavigation.carregando(table);

        $.post(url, form.serialize(), function (html, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                // RECARREGA FORMULÁRIO
                table.html($(html).find('#' + table.attr('id') + ' >'));

                // HABILITA BOTÕES DA CONSULTA
                p._habilitaBotoesConsulta();
            }
        }, 'html');
    };

    // =========================================================================
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormPremio = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLotCategorias.modalFormId);
        var url = 'lotCategorias/premio/' +id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {

            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLotCategoria();
                }
            });

        });
    };

    p._loadFormLotCategoria = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLotCategorias.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'lotCategorias/add' : 'lotCategorias/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {

            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsLotCategoria();
                }
            });

        });
    };

    p._loadCarregarImagem = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppLotCategorias.modalFormId);
        var url = 'lotCategorias/addImg/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '75%', function () {

            if (typeof $("#LotCategoriaAddImgForm")[0].dropzone != 'undefined') {
                return false;
            }

            var myDropzone = new Dropzone("#LotCategoriaAddImgForm");

            myDropzone.options.acceptedFiles = 'image/*';
            myDropzone.options.maxFiles = 1;

            myDropzone.on("addedfile", function (file) {
                $('.dropzone .md-photo-camera').remove();

                // Create the remove button
                var removeButton = Dropzone.createElement("<button class='btn btn-danger' style='width: 100%;padding: 3px;margin-top: 5px;'>Fechar</button>");

                // Capture the Dropzone instance as closure.
                var _this = this;

                // Listen to the click event
                removeButton.addEventListener("click", function (e) {
                    // Make sure the button click doesn't submit the form:
                    e.preventDefault();
                    e.stopPropagation();

//                    $(AppProfile.objectId + ' #btnAlterarFoto label').click();
                });

                // Add the button to the file preview element.
                file.previewElement.appendChild(removeButton);
            });

            myDropzone.on("success", function (file) {
                // Altera imagem atual do perfil
                var newPhoto = $('.dz-details img').attr('src');
                $('.header-nav-profile img').attr('src', newPhoto);
//                $('#gridUser .img-circle').attr('src', newPhoto);
                toastr.success('Foto adicionada com sucesso');
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppLotCategorias = new AppLotCategorias;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
