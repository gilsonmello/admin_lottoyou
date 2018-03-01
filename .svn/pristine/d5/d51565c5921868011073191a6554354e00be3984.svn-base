<?php echo $this->Form->create('GelClube', array('class' => 'form form-validate', 'role'=>'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-edit"></i> EDITAR Clube ')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-md-8"> 
            <div class="form-group">           
                <?php echo $this->Form->input('nome', array('label' => 'Nome', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-md-2"> 
            <div class="form-group">           
                <?php echo $this->Form->input('abreviacao', array('label' => 'Abreviação', 'class' => 'form-control', 'maxlength' => 3)); ?>
            </div>
        </div>
        <div class="col-sm-2">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled', 'options' => array(1 => 'Sim', 0 => 'Não'))); ?>
        </div>
    </div>    
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>