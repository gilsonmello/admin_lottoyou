<div class="img-backdr/op" style="background-image: url('<?php echo $this->Html->url('/img/img16.jpg'); ?>')"></div>
<div class="spacer"></div>
<div class="card contain-sm style-transparent">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-sm-offset-2"> <?php echo $this->Session->flash(); ?></div>
            <div class="col-sm-6">
                <br/>
                <span class="text-lg text-bold text-primary"><?php echo Configure::read('Sistema.nome'); ?> | LOGIN</span>
                <br/><br/>
                <?php echo $this->Form->create('User', array('class'=>'form flo/ating-label', 'accept-charset'=>'utf-8')); ?>
                    <div class="form-group">
                        <?php echo $this->Form->input('username', array('label'=>'E-mail','class'=>'form-control', 'tabindex'=>'1')); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('password', array('label'=>'Senha','class'=>'form-control', 'tabindex'=>'2')); ?>
                        <p class="help-block"><?php echo $this->Html->link('Esqueceu sua senha?', 'forgot_password'); ?></p>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-8 text-left">
                            <div class="checkbox checkbox-inline checkbox-styled">
                                <label>
                                    <input type="checkbox"> <span>Mantenha-me conectado</span>
                                </label>
                            </div>
                        </div><!--end .col -->
                        <div class="col-xs-4 text-right">
                            <button class="btn btn-primary btn-raised" type="submit" tabindex="3">Entrar</button>
                        </div><!--end .col -->
                    </div><!--end .row -->
                <?php echo $this->Form->end(); ?>
            </div><!--end .col -->
            <div class="col-sm-5 col-sm-offset-1 text-center" style="padding-top:35px;">
                <h3 class="text-light">
                    Ainda sem Acesso?
                </h3>
                <a class="btn btn-block btn-raised btn-primary" href="#">UTILIZE, É GRATUITO</a>
                <h3 class="text-light" style="padding-bottom:11px;">
                    ou
                </h3>
                    <?php if (!$this->Session->read('Auth.User.id')) { ?>
                        <?php echo $this->Html->link("<i class='fa fa-facebook pull-left' style='margin-top:3px;'></i>Entre com Facebook", array("action" => "auth_login", "facebook"), array('class' => 'btn btn-block btn-raised btn-info', 'escape' => false)) ?>
                    <?php } ?>
                </p>
                <p>
                    <?php if (!$this->Session->read('Auth.User.id')) { ?>       
                        <?php echo $this->Html->link("<i class='fa fa-google pull-left' style='margin-top:3px;'></i>Entre com Google", array("action" => "auth_login", "google"), array('class' => 'btn btn-block btn-raised btn-danger', 'escape' => false)) ?>
                    <?php } ?>
                </p>
            </div>
        </div>
    </div>
</div>