<?php echo $this->Form->create('RasTabelasDesconto', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR LOTE')); ?>
<div class="card-body">
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">              
                <?php echo $this->Form->input('quantity', array('label' => 'Quantidade', 'class' => 'centena form-control')); ?>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">              
                <?php echo $this->Form->input('percentage', array('label' => 'Porcentagem', 'class' => 'porcentagem form-control')); ?>
            </div>
        </div>
        <div class="col-lg-3">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'), 'value' => '1')); ?>
        </div>

        <div class="col-sm-3 col-lg-3">
            <?php echo $this->Form->input('is_discount', [
                'type' => 'radio', 
                'legend' => 'Desconto?', 
                'class' => 'radio-inline radio-styled tipo', 
                'options' => array(1 => 'Sim', 0 => 'Não'), 
                'value' => '0'
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-lg-12">
            <div class="form-group">              
                <?php echo $this->Form->input('tema_id', array('label' => 'Tema', 'class' => 'form-control chosen', 'options' => $optionsTemas)); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>