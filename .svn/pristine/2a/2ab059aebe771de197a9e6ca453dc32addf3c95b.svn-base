<section id="naoAutorizado">
    <div class="section-body contain-lg">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1><span class="text-xxxl text-light">401 <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
                <h2 class="text-light">Usuário não autorizado.</h2>
                <div class="card" style="width:180px;margin:0 auto;">
                    <div class="card-body">
                        <a data-dismiss="modal" class="btn btn-primary" style="width:100px;">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if ($this->Session->Read('Auth.User.group_id') == 1){ ?>
<hr/>
<section id="AppRestrito" style="padding-top:0;">
    <div class="section-body">
        <div class="row text-center">
            <div style="width:300px;margin:0 auto;">
                <h2 class="text-light text-center">Acesso Resitro<br/><small class="text-primary">Somente desenvolvedores</small></h2>
                <div class="card card-type-pricing text-center">
                    <div class="card-body">
                        <a id="cadastrarFuncionalidade" data-dismiss="modal" class="btn btn-primary">Cadastrar Funcionalidade</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php echo $this->Html->script('sge/AppRestrito.js', $pageJsBehavior); ?>
<?php } ?>