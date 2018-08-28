<?php echo $this->Form->create('League', array('class' => 'form form-validate', 'role' => 'form', 'type' => 'file')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Cadastrar Liga Mata Mata')); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="form-group">
                    <?php echo $this->Form->input('name', array('label' => 'Nome', 'class' => 'form-control name-has-slug', 'required' => true)); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="form-group">
                    <?php echo $this->Form->input('slug', array('label' => 'Slug', 'class' => 'form-control slug-from-name', 'required' => true)); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xs-12 col-md-4">
                <div class="form-group">
                    <?php echo $this->Form->input('value', array('label' => 'Valor', 'class' => 'form-control money', 'required' => true)); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-lg-2">
                <?php echo $this->Form->input('open', [
                    'type' => 'radio',
                    'required' => true,
                    'legend' => 'Aberto?',
                    'class' => 'radio-inline radio-styled tipo',
                    'value' => 1,
                    'options' => [
                        1 => 'Sim',
                        0 => 'Não'
                    ]
                ]); ?>
            </div>
            <div class="col-md-3 col-lg-2">
                <?php echo $this->Form->input('new', [
                    'type' => 'radio',
                    'required' => true,
                    'legend' => 'Novo?',
                    'class' => 'radio-inline radio-styled tipo',
                    'value' => 1,
                    'options' => [
                        1 => 'Sim',
                        0 => 'Não'
                    ]
                ]); ?>
            </div>
            <div class="col-md-3 col-lg-2">
                <?php echo $this->Form->input('active', [
                    'type' => 'radio',
                    'required' => true,
                    'legend' => 'Ativo',
                    'class' => 'radio-inline radio-styled tipo',
                    'value' => 1,
                    'options' => [
                        1 => 'Sim',
                        0 => 'Não'
                    ]
                ]); ?>
            </div>
            <div class="col-md-3 col-lg-2">
                <?php echo $this->Form->input('one_x_one', [
                    'type' => 'radio',
                    'required' => true,
                    'legend' => '1x1 ?',
                    'class' => 'radio-inline radio-styled tipo',
                    'value' => 0,
                    'options' => [
                        1 => 'Sim',
                        0 => 'Não'
                    ]
                ]); ?>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="form-group">
                    <?= $this->Form->input('number_team', [
                        'label' => 'Número de times',
                        'class' => 'form-control chosen',
                        'options' => [
                            '2' => '2',
                            '4' => '4',
                            '8' => '8',
                            '16' => '16',
                            '32' => '32',
                        ],
                        'empty' => 'Selecione',
                        'required' => true
                    ]); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
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
            <div class="col-lg-6">
                <img src="">
            </div>
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