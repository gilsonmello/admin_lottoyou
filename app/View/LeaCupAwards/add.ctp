<?php echo $this->Form->create('LeaCupAward', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Cadastrar Prêmio')); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="form-group">
                    <?= $this->Form->input('lea_cup_id', [
                        'label' => 'Liga',
                        'class' => 'form-control chosen',
                        'options' => $optionsLeaCup,
                        'empty' => 'Selecione',
                        'required' => true
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="form-group">
                    <?php echo $this->Form->input('position', array('label' => 'Posição', 'class' => 'form-control decimal', 'required' => true)); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="form-group">
                    <?php echo $this->Form->input('value', array('label' => 'Valor', 'class' => 'form-control money', 'required' => false)); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="form-group">
                    <?= $this->Form->input('type', [
                        'label' => 'Tipo do Prêmio',
                        'class' => 'form-control chosen',
                        'options' => [
                            '1' => 'Quantia fixa',
                            '2' => 'Porcentagem',
                            '3' => 'Objetos',
                        ],
                        'empty' => 'Selecione',
                        'required' => true
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-8">
                <div class="form-group">
                    <?php echo $this->Form->input('type_description', array('label' => 'Descrição do Prêmio', 'class' => 'form-control', 'required' => false)); ?>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>