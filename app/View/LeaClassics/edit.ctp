<?php echo $this->Form->create('League', array('class' => 'form form-validate', 'role' => 'form', 'type' => 'file')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> EDITAR Liga Clássica')); ?>
<?php echo $this->Form->hidden('id'); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="form-group">
                    <?= $this->Form->label('lea_package_id', 'Pacote<span style="color:red;">*</span>', []); ?>
                    <?= $this->Form->input('lea_package_id', [
                        'label' => false,
                        'class' => 'form-control chosen',
                        'options' => $packages,
                        'empty' => 'Selecione',
                        'required' => false
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="form-group">
                    <?php echo $this->Form->input('name', array('label' => 'Nome', 'class' => 'form-control name-has-slug', 'required' => true)); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="form-group">
                    <?php echo $this->Form->input('slug', array('label' => 'Slug', 'class' => 'form-control slug-from-name', 'required' => true)); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="form-group">
                    <?= $this->Form->input('type_award_id', [
                        'label' => 'Método de premiação',
                        'class' => 'form-control chosen',
                        'value' => $leaClassic['LeaClassic']['type_award_id'],
                        'options' => [
                            '1' => 'Campeonato',
                            '2' => 'Mês',
                            '3' => 'Turno',
                            '4' => 'Patrimônio',
                            '5' => 'Rodada atual',
                        ],
                        'empty' => 'Selecione',
                        'required' => true
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-3 col-lg-3 col-xs-12 col-md-3">
                <div class="form-group">
                    <?php echo $this->Form->input('value', array('label' => 'Valor', 'class' => 'form-control money', 'required' => true)); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12 col-sm-6 col-lg-2">
                <?php echo $this->Form->input('open', [
                    'type' => 'radio',
                    'required' => true,
                    'legend' => 'Aberto?',
                    'class' => 'radio-inline radio-styled tipo',
                    'options' => [
                        1 => 'Sim',
                        0 => 'Não'
                    ]
                ]); ?>
            </div>
            <div class="col-md-4 col-xs-12 col-sm-6 col-lg-2">
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
            <div class="col-md-4 col-xs-12 col-sm-6 col-lg-2">
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
            <div class="col-sm-6 col-lg-2 col-xs-12 col-md-6">
                <div class="form-group">
                    <?= $this->Form->input('min_players', [
                        'label' => 'Mínimo de times',
                        'class' => 'form-control integer',
                        'required' => true,
                        'value' => $leaClassic['LeaClassic']['min_players'],
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-2 col-xs-12 col-md-6">
                <div class="form-group">
                    <?= $this->Form->input('max_players', [
                        'label' => 'Máximo de times',
                        'class' => 'form-control integer',
                        'required' => false,
                        'value' => $leaClassic['LeaClassic']['max_players'],
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-2 col-xs-12 col-md-6">
                <div class="form-group">
                    <?= $this->Form->input('last_round', [
                        'label' => 'Última rodada',
                        'class' => 'form-control integer',
                        'required' => true,
                        'value' => $leaClassic['LeaClassic']['last_round'],
                    ]); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-5">
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
            <?php if($this->request->data['League']['bg_image'] != null) { ?>
                <div class="col-lg-7">
                    <img
                        class="img-responsive"
                        src="<?= $this->request->data['League']['bg_image_domain'] . '/'. $this->request->data['League']['bg_image'] . '?' . time(); ?>">
                </div>
            <?php } else { ?>
                <div class="col-lg-7">
                    <h4>Nenhuma imagem cadastrada</h4>
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