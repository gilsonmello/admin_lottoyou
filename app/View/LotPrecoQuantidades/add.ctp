<?php echo $this->Form->create('LotPrecoQuantidade', array('class' => 'form form-validate', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Adicionar Preço')); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
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
        <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4">
            <div class="form-group">
                <?php echo $this->Form->input('qtd', array('label' => 'Quantidade', 'class' => 'form-control centena', 'title' => 'Quantidade', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4" >
            <div class="form-group">
                <?php echo $this->Form->input("valor", [
                    'label' => 'Valor',
                    'class' => 'form-control money',
                    'required' => true,
                    'placeholder' => 'Valor',
                ]) ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>

