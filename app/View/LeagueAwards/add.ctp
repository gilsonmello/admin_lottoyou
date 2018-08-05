<?php echo $this->Form->create('LeagueAward', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Cadastrar Prêmio')); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="form-group">
                    <?= $this->Form->input('league_id', [
                        'label' => 'Liga',
                        'class' => 'form-control chosen',
                        'options' => $optionsLeague,
                        'empty' => 'Selecione',
                        'required' => true
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="form-group">
                    <?php echo $this->Form->input('position', array('label' => 'Posição', 'class' => 'form-control decimal', 'required' => true)); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="form-group">
                    <?php echo $this->Form->input('value', array('label' => 'Valor', 'class' => 'form-control money', 'required' => true)); ?>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>