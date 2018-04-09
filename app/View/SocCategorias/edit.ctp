<?= $this->Form->create('SocCategoria', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?= $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> EDITAR Bolão')); ?>
<?= $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">                
                <?= $this->Form->input('nome', [
                    'label' => 'Nome', 
                    'class' => 'form-control'
                ]); ?>
            </div>
        </div>
        <div class="col-sm-3">
            <?= $this->Form->input('novo', [
                'type' => 'radio', 
                'legend' => 'Novo', 
                'class' => 'radio-inline radio-styled tipo', 
                'options' => [1 => 'Sim', 0 => 'Não']
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= $this->Form->input('active', [
                'type' => 'radio', 
                'legend' => 'Ativo', 
                'class' => 'radio-inline radio-styled tipo', 
                'options' => [1 => 'Sim', 0 => 'Não']
            ]); ?>
        </div>
    </div>
</div>
<?= $this->element('formsButtons') ?>
<?= $this->Form->end(); ?>