<?php echo $this->Form->create('LotJogosResultado', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> EDITAR JOGO')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">               
                <?php echo $this->Form->input('sorteio', array('label' => 'Sorteio', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">                
                <?php echo $this->Form->input('concurso', array('label' => 'Concurso', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-md-3">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'), 'value' => '1')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">                
                <?php echo $this->Form->input('lot_categoria_id', array('label' => 'Categoria', 'class' => 'form-control chosen', 'options'=>$gelCategorias)); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $this->Form->input('data_fim', array('label' => 'Data de término', 'class' => 'form-control date')); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('forms/buttons');?>
<?php echo $this->Form->end(); ?>


