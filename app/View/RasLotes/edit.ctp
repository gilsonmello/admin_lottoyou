<?= $this->Form->create('RasLote', [
    'class' => 'form form-validate', 
    'role' => 'form'
]); ?>
<?= $this->element('forms/title', [
    'title' => '<i class="fa fa-plus-square"></i> EDITAR lote'
]); ?>
<?= $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">              
                <?php echo $this->Form->input('nome', array('label' => 'Nome', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-lg-3" >
            <div class="form-group">   
                <?php echo $this->Form->input("value", array('label' => 'Valor', 'class' => 'form-control money')) ?>
            </div>     
        </div> 
        <div class="col-lg-3" >
            <?php echo $this->Form->input('new', [
                'type' => 'radio', 
                'legend' => 'Novo?', 
                'class' => 'radio-inline radio-styled', 
                'options' => [1 => 'Sim', 0 => 'Não']
            ]); ?>
        </div> 
        <div class="col-lg-3">
            <?php echo $this->Form->input('active', [
                'type' => 'radio', 
                'legend' => 'Ativo', 
                'class' => 'radio-inline radio-styled tipo', 
                'options' => [1 => 'Sim', 0 => 'Não']
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-lg-4">
            <div class="form-group">              
                <?php echo $this->Form->input('temas_raspadinha_id', array('label' => 'Tema', 'class' => 'form-control chosen', 'options' => $optionsTemas)); ?>
            </div>
        </div>
        <div class="col-sm-4 col-lg-4">
            <div class="form-group">    
                <?php echo $this->Form->input('qtd_raspadinhas', array('label' => 'Quant. total de Bilhetes', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-sm-4 col-lg-4">
            <div class="form-group">              
                <?php echo $this->Form->input('valor_premio', array('label' => 'Quant. total de Bilhetes Prêmiados', 'class' => 'form-control')); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>