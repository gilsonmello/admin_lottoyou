<?php echo $this->Form->create('SocRodada', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> EDITAR Cartela')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">                
                <?php echo $this->Form->input('nome', array('label' => 'Nome', 'class' => 'form-control', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">                
                <?php echo $this->Form->input('soc_bolao_id', array('label' => 'Bolão', 'class' => 'form-control chosen', 'options' => $optionsBoloes, 'empty' => 'Selecione', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">                
                <?php echo $this->Form->input('soc_categoria_id', array('label' => 'Categoria', 'class' => 'form-control chosen', 'options' => $optionsCategorias, 'empty' => 'Selecione', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">                
                <?php echo $this->Form->input('data_termino', array('label' => 'Data Termino', 'class' => 'form-control date', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">                
                <?php echo $this->Form->input('hora_termino', array('label' => 'Hora Termino', 'class' => 'form-control hora', 'required' => true)); ?>
            </div>
        </div>
    </div>
    <div class="row">
       <div class="col-sm-4">
            <div class="form-group">                
                <?php echo $this->Form->input('valor', array('label' => 'Valor', 'class' => 'form-control money', 'required' => true)); ?>
            </div>
        </div>
         <div class="col-md-4">
            <?php echo $this->Form->input('tipo', array('type' => 'radio', 'legend' => '&nbsp;&nbsp;', 'class' => 'radio-inline radio-styled tipo', 'options' => array(0 => 'ILIMITADO', 1 => 'LIMITADO'), 'style' => 'font-size: 12px')); ?>
        </div>
        <div class="col-sm-4">
            <div class="form-group">                
                <?php echo $this->Form->input('limite', array('label' => 'Qtd Limite', 'class' => 'form-control number', 'required' => true)); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>