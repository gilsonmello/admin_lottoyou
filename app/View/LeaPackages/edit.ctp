<?php echo $this->Form->create('LeaPackage', array('class' => 'form form-validate', 'role' => 'form', 'type' => 'file')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Editar Pacote de Ligas')); ?>
<?php echo $this->Form->hidden('id'); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="form-group">
                    <?= $this->Form->label('league_id', 'Ligas<span style="color:red;">*</span>', []); ?>
                    <?= $this->Form->input('league_id', [
                        'label' => false,
                        'class' => 'form-control chosen',
                        'options' => $leagues,
                        'selected' => $selected,
                        //'empty' => 'Selecione',
                        'multiple' => 'multiple',
                        'required' => false
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-4 col-xs-12 col-md-4">
                <div class="form-group">
                    <?php echo $this->Form->input('name', array('label' => 'Nome', 'class' => 'form-control name-has-slug', 'required' => true)); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xs-12 col-md-4">
                <div class="form-group">
                    <?php echo $this->Form->input('slug', array('label' => 'Slug', 'class' => 'form-control slug-from-name', 'required' => true)); ?>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 col-xs-12 col-md-4">
                <div class="form-group">
                    <?php echo $this->Form->input('value', array('label' => 'Valor', 'class' => 'form-control money', 'required' => true)); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <?php echo $this->Form->input('new', [
                    'type' => 'radio',
                    'required' => true,
                    'legend' => 'Novo?',
                    'class' => 'radio-inline radio-styled tipo',
                    'options' => [
                        1 => 'Sim',
                        0 => 'Não'
                    ]
                ]); ?>
            </div>
            <div class="col-md-6 col-lg-6">
                <?php echo $this->Form->input('active', [
                    'type' => 'radio',
                    'required' => true,
                    'legend' => 'Ativo',
                    'class' => 'radio-inline radio-styled tipo',
                    'options' => [
                        1 => 'Sim',
                        0 => 'Não'
                    ]
                ]); ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <?php echo $this->Form->input('bg_image', [
                        'escape' => false,
                        'label' => 'Imagem de fundo',
                        'required' => false,
                        'accept' => "image/png, image/jpeg, image/jpg",
                        'type' => 'file',
                    ]);?>
                </div>
            </div>
            <?php if($this->request->data['LeaPackage']['bg_image'] != null) { ?>
                <div class="col-lg-8">
                    <img class="img-responsive" src="<?= $this->request->data['LeaPackage']['bg_image_domain'] . '/'. $this->request->data['LeaPackage']['bg_image']?>">
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <?php echo $this->Form->input('small_description', [
                        'escape' => false,
                        'type' => 'text',
                        'label' => 'Descrição Rápida',
                        'class' => 'form-control',
                        'required' => true,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <?php echo $this->Form->input('description', [
                        'escape' => false,
                        'type' => 'textarea',
                        'label' => 'Descrição',
                        'class' => 'form-control',
                        'required' => false,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>