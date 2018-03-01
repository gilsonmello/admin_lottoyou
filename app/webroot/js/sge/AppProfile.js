(function(namespace, $) {
    "use strict";

    var AppProfile = function() {
        // Create reference to this instance
        var o = this;

        // Initialize app when document is ready
        $(document).ready(function() {
            o.initialize();
        });
    };

    var p = AppProfile.prototype;

    // =========================================================================
    // CONFIG
    // =========================================================================

    AppProfile.objectId = '#AppProfile';
    AppProfile.modalFormId = '#nivel1';
    AppProfile.controller = 'users';
    AppProfile.model = 'User';

    // =========================================================================
    // INIT
    // =========================================================================

    p.initialize = function() {
        // CARREGA DEPENDÊNCIAS
        window.materialadmin.AppForm.initialize($(AppProfile.objectId+':last form:first').parent());
        window.materialadmin.AppForm.initialize($(AppProfile.objectId+':last form:last').parent());
        
        // INICIAR POPOVER
        $(AppProfile.objectId+' #btnAlterarFoto label').popover({html:true});
        $(AppProfile.objectId+' #btnAlterarFoto label').click(function(){
            p._loadFormAlterarFoto();
        });

        p._loadFormSenhaAcesso();
    };

    // =========================================================================
    // FORMS
    // =========================================================================

    p._loadFormAlterarFoto = function() {
        if (typeof $("#UserProfileForm3")[0].dropzone != 'undefined'){
            return false;
        }

        var myDropzone = new Dropzone("#UserProfileForm3");
        
        myDropzone.options.acceptedFiles = 'image/*';
        myDropzone.options.maxFiles = 1;

        myDropzone.on("addedfile", function(file) {
            $('.dropzone .md-photo-camera').remove();

            // Create the remove button
            var removeButton = Dropzone.createElement("<button class='btn btn-danger' style='width: 100%;padding: 3px;margin-top: 5px;'>Fechar</button>");

            // Capture the Dropzone instance as closure.
            var _this = this;

            // Listen to the click event
            removeButton.addEventListener("click", function(e) {
                // Make sure the button click doesn't submit the form:
                e.preventDefault();
                e.stopPropagation();

                $(AppProfile.objectId+' #btnAlterarFoto label').click();
            });

            // Add the button to the file preview element.
            file.previewElement.appendChild(removeButton);
        });

        myDropzone.on("success", function(file){
            // Altera imagem atual do perfil
            var newPhoto = $('.dz-details img').attr('src');
            $('.header-nav-profile img').attr('src', newPhoto);
            $('#gridUser .img-circle').attr('src', newPhoto);
            toastr.success('Foto alterada com sucesso');
        });
    };

    p._loadFormSenhaAcesso = function() {
        setTimeout(function(){
            $(AppProfile.objectId+' #UserAtual').val('');    
        },5);
    };

    // =========================================================================
    // DEFINE NAMESPACE
    // =========================================================================

    window.materialadmin.AppProfile = new AppProfile;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
