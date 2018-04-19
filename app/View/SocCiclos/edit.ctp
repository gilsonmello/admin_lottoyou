<?php echo $this->Form->create('SocCiclo', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> EDITAR Ciclo')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">                
                <?= $this->Form->input('soc_categoria_id', [
                    'label' => 'Categoria', 
                    'class' => 'form-control chosen', 
                    'options' => $optionsCategorias, 
                    'empty' => 'Selecione', 
                    'required' => true
                ]); ?>
            </div>
        </div> 
        <div class="col-lg-2">
            <div class="form-group">              
                <?= $this->Form->input('identificacao', [
                    'label' => 'Identificação', 
                    'class' => 'form-control',
                    'required' => true,
                ]); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">              
                <?= $this->Form->input('data_inicio', [
                    'label' => 'Data de Inicio', 
                    'class' => 'date form-control',
                    'required' => true,
                ]); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">              
                <?= $this->Form->input('hora_inicio', [
                    'label' => 'Hora de Inicio', 
                    'class' => 'hora form-control',
                    'required' => true,
                ]); ?>
            </div>
        </div>        
    </div>

    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">              
                <?= $this->Form->input('data_fim', [
                    'label' => 'Data Final', 
                    'class' => 'date form-control',
                    'required' => true,
                ]); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">              
                <?= $this->Form->input('hora_fim', [
                    'label' => 'Hora Final', 
                    'class' => 'hora form-control',
                    'required' => true,
                ]); ?>
            </div>
        </div>
        <div class="col-lg-3">
            <?= $this->Form->input('active', [
                'type' => 'radio', 
                'legend' => 'Ativo', 
                'class' => 'radio-inline radio-styled tipo', 
                'options' => array(1 => 'Sim', 0 => 'Não'), 
            ]); ?>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>