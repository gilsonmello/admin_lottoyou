<?php echo $this->Form->create('RasLote', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Gerar LOTE de Raspadinha')); ?>
<?php echo $this->Form->hidden('lote_id', array('value' => $id)); ?>
<?php echo $this->Form->hidden('user_id', array('value' => $this->Session->read('Auth.User.id'))); ?>
<?php echo $this->Form->hidden('tema_id', array('value' => $lote['RasLote']['temas_raspadinha_id'])); ?>
<?php echo $this->Form->hidden('auto', array('value' => 0)); ?>
<div class="card-body">
    <div class="card-body style-default-light" style="padding-top:10px;padding-bottom:20px;">
        <div class="row"">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="vertical-align:bottom;">
                <div class="card">
                    <div class="card-body no-padding">
                        <div class="alert alert-callout alert-danger no-margin" style="min-height: 123px;">
                            <h1 class="pull-right text-danger"><i class="md md-timer"></i></h1>
                            <strong class="text-xl"><?php echo $lote['RasLote']['qtd_raspadinhas'] ?></strong><br>
                            <span class="opacity-25">Total Bilhetes</span>
                        </div>
                    </div><!--end .card-body -->
                </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="vertical-align:bottom;">
                <div class="card">
                    <div class="card-body no-padding">
                        <div class="alert alert-callout alert-info no-margin" style="min-height: 120px;">
                            <h1 class="pull-right text-info"><i class="md md-timer"></i></h1>
                            <strong class="text-xl"><?php echo ($lote['RasLote']['valor_premio'] - $lote['RasLote']['total_premiadas']) ?></strong><br>
                            <span class="opacity-25"> Bilhetes Disponiveis Premiados</span>
                        </div>
                    </div><!--end .card-body -->
                </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="vertical-align:bottom;">
                <div class="card">
                    <div class="card-body no-padding">
                        <div class="alert alert-callout alert-success no-margin" style="min-height: 123px;">
                            <h1 class="pull-right text-success"><i class="md md-timer"></i></h1>
                            <strong class="text-xl"><?php echo $lote['RasLote']['total_premiadas'] ?></strong><br>
                            <span class="opacity-25">Bilhetes Premiados</span>
                        </div>
                    </div><!--end .card-body -->
                </div>                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">              
                <?php
                echo $this->Form->input('qtd_premiadas', array('label' => 'Quant. Premiadas', 'class' => 'form-control'
                    . '', 'placeholder' => '20', 'data-rule-min' => '0', 'data-rule-max' => '10', 'required' => true));
                ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">       
                <?php echo $this->Form->input('valor_premiado', array('label' => 'Valor do Premio', 'required' => true, 'class' => 'form-control chosen', 'options' => $numeros_possiveis)); ?>    

                <!-- <?php echo $this->Form->input('valor_premiado', array('label' => 'Valor do Premio', 'class' => 'form-control money', 'placeholder' => '$: 10,00', 'required' => true)); ?> -->
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">              
                <?php echo $this->Html->link('Gerar Raspadinhas', 'javascript: void(0);', 
                    array(
                        'class' => 'btn btn-success pull-right', 
                        'escape' => false, 'id' => 'btnSalvar',
                        'data-loading-text' => "<i class='fa fa-spinner fa-spin'></i> Processando..."
                    )); ?>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-12">
            <h4>Bilhetes Premiados</h4>
            <table class="table table-bordered table-condensed table-striped">
                <tr>
                    <th style="width: 50%">Valor Prêmio</th>
                    <th style="width: 50%">Qtd. Geradas</th>
                </tr>
                <?php if (!empty($dados)) { ?>
                    <?php $totalGeradas = 0; ?>
                    <?php foreach ($dados as $key => $value) { ?>
                        <tr>
                            <td><?php echo $value['ras']['premio'] ?></td>
                            <td><?php echo $value[0]['qtd_geradas'] ?></td>
                        </tr>
                        <?php $totalGeradas += $value[0]['qtd_geradas']; ?>
                    <?php } ?>
                    <tr>
                        <td>Total em Prêmios: </td>
                        <td><?php echo $totalGeradas ?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="3">Não há Registro</td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Bilhetes <strong style="color: red">Não</strong> Premiados</h4>
            <?php echo $this->Html->link('Gerar Bilhetes Não Premiados', 'javascript: void(0);', 
                array(
                    'class' => 'btn btn-danger pull-right', 
                    'raspadinhas_restantes' => ($lote['RasLote']['qtd_raspadinhas'] - $lote['RasLote']['total_geradas']), 
                    'escape' => false, 
                    'id' => 'btnGerarRaspadinhas',
                    'data-loading-text' => "<i class='fa fa-spinner fa-spin'></i> Processando..."
                )); ?>
            <table class="table table-bordered table-condensed table-striped">
                <tr>
                    <th style="width: 50%">Total:</th>
                    <th style="width: 50%"><?php echo isset($dadosSemPremio[0][0]['qtd_geradas']) ? $dadosSemPremio[0][0]['qtd_geradas'] : 0; ?></th>
                </tr>
            </table>
        </div>
    </div>  
</div>
<?php echo $this->element('formsButtons2') ?>
<?php echo $this->Form->end(); ?>