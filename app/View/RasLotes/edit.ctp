<?php echo $this->Form->create('RasLote', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> EDITAR lote')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
     <div class="row">
        <div class="col-lg-5">
            <div class="form-group">              
                <?php echo $this->Form->input('nome', array('label' => 'Nome', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-sm-4" >
            <div class="form-group">   
                <?php echo $this->Form->input("value", array('label' => 'Valor', 'class' => 'form-control money')) ?>
            </div>     
        </div> 
        <div class="col-lg-3">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'))); ?>
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