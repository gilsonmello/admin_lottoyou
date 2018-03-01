<?php echo $this->Form->create('User', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->Form->hidden('id'); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i>&nbsp;&nbsp;EDITAR USUÁRIO')); ?>
<div class="card-body">
    <?php if($this->data['User']['active'] == 0 && $this->data['User']['passwordchangecode'] != ''){ ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-warning text-justify" style="margin-bottom: 15px;">
                <h4>Atenção!</h4>
                Este usuário ainda não não confirmou seu cadastro via e-mail. Caso precise 
                permitir o acesso do mesmo sem esta validação, ative o usuário.
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">                
                <?php echo $this->Form->input('name', array('label' => 'Nome do Usuário', 'class' => 'form-control', 'placeholder' => 'Nome completo', 'required' => 'required')); ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo ', 'options' => array(1 => 'Sim', 0 => 'Não'))); ?>
        </div>
        <div class="col-sm-12">
            <div class="form-group">                
                <?php echo $this->Form->input('username', array('label' => 'Usuário (E-mail)', 'class' => 'form-control', 'placeholder' => 'E-mail')); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">                
                <?php echo $this->Form->input('password2', array('type' => 'password', 'value' => '', 'label' => 'Nova Senha', 'readonly' => true, 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">                
                <?php echo $this->Form->input('alterar', array('label' => 'Alterar Senha?', 'options' => array(0 => 'Não', 1 => 'Sim'), 'required' => 'required', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-sm-4" <?php echo ($grupo_tipo == 'E') ? 'style="display: none;"' : ''; ?>>
            <div class="form-group">                
                <?php echo $this->Form->input('group_id', array('label' => 'Perfil', 'required' => 'required', 'class' => 'form-control')); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('forms/buttons') ?>
<?php echo $this->Form->end(); ?>