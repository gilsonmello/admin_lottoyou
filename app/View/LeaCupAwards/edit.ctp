<?php echo $this->Form->create('LeagueAward', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Editar Prêmio')); ?>
<?php echo $this->Form->hidden('id', ['id' => $award['LeaCupAward']['id']]); ?>
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
            <div class="col-sm-6 col-lg-4">
                <div class="form-group">
                    <?php echo $this->Form->input('position', array('label' => 'Posição', 'class' => 'form-control decimal', 'required' => true)); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="form-group">
                    <?php echo $this->Form->input('value', [
                        'label' => 'Valor',
                        'class' => 'form-control decimal2',
                        'data-toggle' => "tooltip",
                        'data-placement' => "top",
                        'title' => "Em dinheiro ou Porcentagem",
                        'required' => false
                    ]); ?>
                    <small>
                        Em dinheiro ou Porcentagem
                    </small>
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
                    <?php echo $this->Form->input('type_description', [
                        'label' => 'Descrição do Prêmio',
                        'class' => 'form-control',
                        'required' => false
                    ]); ?>
                    <small>
                        Informe a descrição somente se o prêmio for objeto
                    </small>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>