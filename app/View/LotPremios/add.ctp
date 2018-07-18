<?php echo $this->Form->create('LotPremio', array('class' => 'form form-validate', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Adicionar Prêmio')); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-3 col-xs-12 col-md-3 col-lg-3">
            <div class="form-group">
                <?= $this->Form->input('lot_categoria_id', [
                    'label' => 'Categoria',
                    'class' => 'form-control chosen',
                    'options' => $categorias,
                    'empty' => 'Selecione',
                    'required' => true
                ]); ?>
            </div>
        </div>
        <div class="col-sm-3 col-xs-12 col-md-3 col-lg-3">
            <div class="form-group">
                <?php echo $this->Form->input('num_acertos', array('label' => 'Número de acertos', 'class' => 'form-control centena', 'title' => 'Nº de acertos', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-3 col-xs-12 col-md-3 col-lg-3">
            <div class="form-group">
                <?php echo $this->Form->input('num_acertos_extras', array('label' => 'Número de acertos extras', 'class' => 'form-control centena', 'title' => 'Nº acertos extras', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-3 col-xs-12 col-md-3 col-lg-3" >
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

