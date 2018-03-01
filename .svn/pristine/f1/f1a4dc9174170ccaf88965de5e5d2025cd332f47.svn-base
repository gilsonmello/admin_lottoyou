<div class="img-backdrop" style="background-image: url('<?php echo $this->Html->url('/img/img16.jpg'); ?>')"></div>
<div class="spacer"></div>
<div class="card contain-sm style-transparent">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2"> <?php echo $this->Session->flash(); ?></div>
            <div class="col-sm-8 col-sm-offset-2">
                <br/>
                <span class="text-lg text-bold text-primary"><?php echo Configure::read('Sistema.nome'); ?> | RECUPERAR SENHA DE ACESSO - PASSO 3</span>
                <br/><br/>
                <?php echo $this->Form->create('User', array('id'=>'signup-form', 'class' => 'form  floating-label', 'autocomplete'=>false)); ?>
                <?php echo $this->Form->hidden('id', array( 'value'=>$user_id)); ?>
                    <div class="form-group">
                        <div class="input-icon right">
                            <i class="fa fa-lock" style="position: absolute;top:30px;right:5px;"></i>
                            <?php echo $this->Form->input('password', array('label'=>'Nova senha', 'type'=>'password', 'autocomplete'=>false,'class'=>'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">            
                        <div class="input-icon right">
                            <i class="fa fa-lock" style="position: absolute;top:30px;right:5px;"></i>
                            <?php echo $this->Form->input('confirmacao', array('label'=>'Confirme a senha', 'type'=>'password', 'autocomplete'=>false,'class'=>'form-control','required'=>true)); ?>
                        </div>
                    </div>
                    <div class="form-group mbn">
                        <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'login')); ?>" class="btn btn-warning">
                            <i class="fa fa-chevron-circle-left"></i>
                            &nbsp;Desistir
                        </a>
                        <button type="submit" class="btn btn-info pull-right">
                            Recuperar&nbsp;<i class="fa fa-chevron-circle-right"></i>
                        </button>
                    </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>