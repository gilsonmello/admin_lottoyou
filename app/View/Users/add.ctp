<?php echo $this->Form->create('User', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i>&nbsp;&nbsp;CADASTRAR NOVO USUÁRIO')); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">                
                <?php echo $this->Form->input('name', array('label' => 'Nome do Usuário', 'class' => 'form-control', 'placeholder' => 'Nome completo', 'required' => 'required')); ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo ', 'options' => array(1 => 'Sim', 0 => 'Não'), 'value' => '1')); ?>
        </div>
        <div class="col-sm-12">
            <div class="form-group">                
                <?php echo $this->Form->input('username', array('label' => 'Usuário (E-mail)', 'class' => 'form-control', 'placeholder' => 'E-mail')); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">                
                <?php echo $this->Form->input('password', array('type' => 'text', 'value' => '102030', 'class' => 'form-control', 'label' => 'Senha Inicial', 'required' => 'required')); ?>
            </div>
        </div>
        <div class="col-sm-6" <?php echo (isset($grupo_tipo) && $grupo_tipo == 'E') ? 'style="display: none;"' : ''; ?>>
            <div class="form-group">                
                <?php echo $this->Form->input('group_id', array('label' => 'Perfil', 'required' => 'required', 'class' => 'form-control')); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('forms/buttons') ?>
<?php echo $this->Form->end(); ?>