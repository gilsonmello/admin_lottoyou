<?php echo $this->Form->create('SocConfRodada', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> EDITAR Configuração')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-3 col-lg-3 col-md-3 col-xs-12">
            <div class="form-group">                
                <?php echo $this->Form->input('hit_a_result', array('label' => '1 Resultado', 'class' => 'form-control decimal')); ?>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3 col-md-3 col-xs-12">
            <div class="form-group">                
                <?php echo $this->Form->input('hit_the_difference_result', array('label' => 'Diferença de Resultados', 'class' => 'form-control decimal')); ?>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3 col-md-3 col-xs-12">
            <div class="form-group">                
                <?php echo $this->Form->input('hit_all_results', array('label' => 'Todos os Resultatos', 'class' => 'form-control decimal')); ?>
            </div>
        </div>
        <div class="col-md-3 col-lg-3">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'), 'value' => '1')); ?>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>