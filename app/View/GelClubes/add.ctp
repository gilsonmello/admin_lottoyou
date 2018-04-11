<?= $this->Form->create('GelClube', [
    'class' => 'form form-validate', 
    'role'=>'form',
    'enctype' => 'multipart/form-data'
]); ?>
<?= $this->element('forms/title', [
    'title' => '<i class="fa fa-edit"></i> Cadastrar Clube '
]); ?>
<div class="card-body">
    <div class="row">
        <div class="col-md-3"> 
            <div class="form-group">           
                <?php echo $this->Form->input('nome', [
                    'label' => 'Nome', 
                    'class' => 'form-control',
                    'required' => true
                ]); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= $this->Form->input('escudo', [
                    'type' => 'file', 
                    'label' => 'Escudo', 
                    'required' => true,
                    'class' => 'form-control',
                    'accept' => "image/*"
                ]); ?>
            </div>            
        </div>
        <div class="col-md-2"> 
            <div class="form-group">           
                <?php echo $this->Form->input('abreviacao', [
                    'label' => 'Abreviação', 
                    'class' => 'form-control', 
                    'required' => true,
                    'maxlength' => 3
                ]); ?>
            </div>
        </div>
        <div class="col-sm-3">
            <?php echo $this->Form->input('active', [
                'type' => 'radio', 
                'legend' => 'Ativo', 
                'class' => 'radio-inline radio-styled', 
                'value' => 1,
                'options' => [1 => 'Sim', 0 => 'Não']
            ]); ?>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>