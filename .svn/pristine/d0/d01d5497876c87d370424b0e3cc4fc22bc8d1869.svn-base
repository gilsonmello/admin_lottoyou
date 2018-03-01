(function (namespace, $) {
    "use strict";

    var AppGelClubes = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppGelClubes.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppGelClubes.objectId = '#AppGelClubes';
    AppGelClubes.modalFormId = '#nivel2';
    AppGelClubes.controller = 'gelClubes';
    AppGelClubes.model = 'GelClube';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        //window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppGelClubes.objectId));
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
        $(AppGelClubes.objectId + ' #cadastrarGelClube').click(function () {
            p._loadFormGelClube();
        });

        $(AppGelClubes.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppGelClubes.objectId + ' #pesquisarGelClube').submit(function () {
            p._loadConsGelClube();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppGelClubes.objectId + ' .btnEditar').click(function () {
            p._loadFormGelClube($(this).attr('id'));
        });

        $(AppGelClubes.objectId + ' .btnAddImagem').click(function () {
            p._adicionarImagemGelClube($(this).attr('id'));
        });

        $(AppGelClubes.objectId + ' .btnDeletar').click(function () {
            var url = baseUrl + 'gelClube/delete/' + $(this).attr('id');
            window.materialadmin.AppGrid.delete(url, function () {
                p._loadConsGelClube();
            });
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsGelClube = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppGelClubes.objectId + ' #pesquisarGelClube');
        var table = $(AppGelClubes.objectId + ' #gridGelClube');
        var url = baseUrl + 'gelClubes/index';

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

    p._loadFormGelClube = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppGelClubes.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'gelClubes/add' : 'gelClubes/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '60%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsGelClube();
                }
            });

        });
    };

    p._adicionarImagemGelClube = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppGelClubes.modalFormId);
        var url = baseURL + 'gelClubes/adicionarImagem/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '60%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {

                }
            });

            if (typeof $("#GelClubeAdicionarImagemForm")[0].dropzone != 'undefined') {
                return false;
            }

            var myDropzone = new Dropzone("#GelClubeAdicionarImagemForm");

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
                toastr.success('Foto alterada com sucesso');
            });

        });
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppGelClubes = new AppGelClubes;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
