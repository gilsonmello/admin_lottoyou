<?= $this->Form->create('GelClube', [
    'class' => 'form form-validate', 
    'role'=>'form',
    'enctype' => 'multipart/form-data'
]); ?>
<?= $this->element('forms/title', [
    'title' => '<i class="fa fa-edit"></i> EDITAR Clube '
]); ?>
<?= $this->Form->hidden('id'); ?>
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
                    'required' => $this->request->data['GelClube']['escudo'] == null ? true : false,
                    'class' => 'form-control',
                    'accept' => "image/*"
                ]); ?>
            </div>            
        </div>
        <div class="col-md-2"> 
            <div class="form-group">           
                <?= $this->Form->input('abreviacao', [
                    'label' => 'Abreviação', 
                    'class' => 'form-control', 
                    'maxlength' => 3
                ]); ?>
            </div>
        </div>
        <div class="col-sm-3">
            <?= $this->Form->input('active', [
                'type' => 'radio', 
                'legend' => 'Ativo', 
                'class' => 'radio-inline radio-styled', 
                'options' => [1 => 'Sim', 0 => 'Não']
            ]); ?>
        </div>
    </div>  
    <?php if($this->request->data['GelClube']['escudo'] != null) { ?>
        <div class="row">
            <div class="col-lg-12">
                <label>Escudo Cadastrado</label>
                <img class="img-responsive" src="<?= $this->Html->url('/'.$this->request->data['GelClube']['escudo']) ?>">
            </div>
        </div>  
    <?php } ?>
</div>
<?= $this->element('formsButtons') ?>
<?= $this->Form->end(); ?>