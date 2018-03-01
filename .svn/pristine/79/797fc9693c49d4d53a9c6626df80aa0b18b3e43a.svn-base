<div class="img-backdrop" style="background-image: url('<?php echo $this->Html->url('/img/img16.jpg'); ?>')"></div>
<div class="spacer"></div>
<div class="card contain-sm style-transparent">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2"> <?php echo $this->Session->flash(); ?></div>
            <div class="col-sm-8 col-sm-offset-2">
                <br/>
                <span class="text-lg text-bold text-primary"><?php echo Configure::read('Sistema.nome'); ?> | RECUPERAR SENHA DE ACESSO - PASSO 2</span>
                <br/><br/>
                <?php echo $this->Form->create('User', array('id'=>'signup-form', 'class' => 'form floating-label')); ?>
                    <div class="form-group">
                        <?php echo $this->Form->input('codigo', array('label'=>'Informe o código de redefinição de senha','class'=>'form-control')); ?>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-8 text-left">
                            <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'login')); ?>" class="btn btn-warning">
                                <i class="fa fa-chevron-circle-left"></i>
                                &nbsp;Voltar
                            </a>
                        </div><!--end .col -->
                        <div class="col-xs-4 text-right">
                            <button class="btn btn-primary btn-raised" type="submit">
                                Recuperar&nbsp;<i class="fa fa-chevron-circle-right"></i>
                            </button>
                        </div><!--end .col -->
                    </div><!--end .row -->
                <?php echo $this->Form->end(); ?>
            </div><!--end .col -->
            <!--div class="col-sm-5 col-sm-offset-1 text-center" style="padding-top:35px;">
                <h3 class="text-light">
                    Ainda sem conta?
                </h3>
                <a class="btn btn-block btn-raised btn-primary" href="#">Registro-se agora</a>
                <h3 class="text-light" style="padding-bottom:11px;">
                    ou
                </h3>
                <p>
                    <a href="#" class="btn btn-block btn-raised btn-info">
                        <i class="fa fa-facebook pull-left" style="margin-top:3px;"></i>Entre com Facebook
                    </a>
                </p>
                <p>
                    <a href="#" class="btn btn-block btn-raised btn-danger">
                        <i class="fa fa-google pull-left" style="margin-top:3px;"></i>Entre com Google
                    </a>
                </p>
            </div><!--end .col -->
        </div><!--end .row -->
    </div><!--end .card-body -->
</div><!--end .card -->