<?php echo $this->Form->create('SocBolao', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> EDITAR Gênero')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">                
                <?php echo $this->Form->input('nome', array('label' => 'Nome', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">                
                <?php echo $this->Form->input('soc_categoria_id', array('label' => 'Categoria', 'class' => 'form-control chosen', 'options' => $optionsSocCategorias, 'empty' => 'Selecione', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'), 'value' => '1')); ?>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>