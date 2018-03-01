(function (namespace, $, d, s, id) {
    "use strict";

    var AppSocCategorias = function () {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function () {
            o.initialize();
        });
    };

    var p = AppSocCategorias.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppSocCategorias.objectId = '#AppSocCategorias';
    AppSocCategorias.modalFormId = '#nivel3';
    AppSocCategorias.controller = 'socCategorias';
    AppSocCategorias.model = 'SocCategoria';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function () {
        // CARREGA DEPENDÊNCIAS
        window.materialadmin.App.initialize();
        window.materialadmin.AppForm.initialize($(AppSocCategorias.objectId));
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
        $(AppSocCategorias.objectId + ' #cadastrarSocCategoria').click(function () {
            p._loadFormSocCategoria();
        });

        $(AppSocCategorias.objectId + ' #voltar').click(function () {
            window.materialadmin.AppGelCadastros.carregarCadastros();
        });

        $(AppSocCategorias.objectId + ' #pesquisarSocCategoria').submit(function () {
            p._loadConsSocCategoria();
            return false;
        });
    };

    p._habilitaBotoesConsulta = function () {
        $(AppSocCategorias.objectId + ' .btnEditar').click(function () {
            p._loadFormSocCategoria($(this).attr('id'));
        });

        $(AppSocCategorias.objectId + ' .btnDeletar').click(function () {
            var res;
            res = confirm("Deseja realmente excluir o item?");
            if (res) {
                var url = baseUrl + 'socCategorias/delete/' + $(this).attr('id');
                window.materialadmin.AppGrid.delete(url, function () {
                    p._loadConsSocCategoria();
                });
            }
        });

        $(AppSocCategorias.objectId + ' .btnAddImagem').click(function () {
            p._adicionarImagem($(this).attr('id'));
        });
    };

    // =========================================================================
    // CARREGA CONSULTA 
    // =========================================================================

    p._loadConsSocCategoria = function () {
        // INSTANCIA VARIÁREIS
        var form = $(AppSocCategorias.objectId + ' #pesquisarSocCategoria');
        var table = $(AppSocCategorias.objectId + ' #gridSocCategorias');
        var url = baseUrl + 'socCategorias/index';

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

    p._adicionarImagem = function (id) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocCategorias.modalFormId);
        var url = baseURL + 'socCategorias/adicionarImagem/' + id;

        window.materialadmin.AppForm.loadModal(modalObject, url, '60%', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {

                }
            });

            if (typeof $("#SocCategoriaAdicionarImagemForm")[0].dropzone != 'undefined') {
                return false;
            }

            var myDropzone = new Dropzone("#SocCategoriaAdicionarImagemForm");

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
    // CARREGA FORMULÁRIOS
    // =========================================================================

    p._loadFormSocCategoria = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocCategorias.modalFormId);
        var action = (typeof clonar !== 'undefined') ? 'add' : 'edit';
        var url = (typeof id === 'undefined') ? 'socCategorias/add' : 'socCategorias/' + action + '/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '500px', function () {
            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsSocCategoria();
                }
            });

        });
    };

    p._loadViewSocCategoria = function (id, clonar) {
        // CHAMA A FUNÇÃO MODAL
        var modalObject = $(AppSocCategorias.modalFormId);
        var url = 'socCategorias/view/' + id;
        var i = 0;

        window.materialadmin.AppForm.loadModal(modalObject, url, '700px', function () {

            modalObject.find('button[type=submit]').html('ENVIAR SOLICITAÇÃO');

            modalObject.off('hide.bs.modal');
            modalObject.on('hide.bs.modal', function () {
                if (window.materialadmin.AppForm.getFormState()) {
                    p._loadConsSocCategoria();
                }
            });

        });
    };

//    var js, fjs = d.getElementsByTagName(s)[0];
//    if (d.getElementById(id))
//        return;
//    js = d.createElement(s);
//    js.id = id;
//    js.src = "//connect.facebok.net/pt_BR/sdk.js#xfbml=1&version=v2.8&appId=1194020284000011";
//    fjs.parentNode.insertBefore(js, fjs);

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppSocCategorias = new AppSocCategorias;
}(this.materialadmin, jQuery, document, 'script', 'facebok-jssdk')); // pass in (namespace, jQuery):