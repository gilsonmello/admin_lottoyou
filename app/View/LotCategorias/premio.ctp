<?php echo $this->Form->create('LotCategoria', array('class' => 'form form-validate', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Prêmios')); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="form-group">                
                <?php echo $this->Form->input('num_acertos', array('label' => 'Número de acertos', 'class' => 'form-control centena', 'title' => 'Números de acertos', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="form-group">
                <?php echo $this->Form->input('num_acertos_extras', array('label' => 'Número de acertos extras', 'class' => 'form-control centena', 'title' => 'Números de acertos extras', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12 col-md-4 col-lg-4" >
            <div class="form-group">   
                <?php echo $this->Form->input("value", [
                    'label' => 'Valor', 
                    'class' => 'form-control money',
                    'required' => true,
                    'placeholder' => 'Valor que o jogador ganhará',
                ]) ?>
            </div>     
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>

