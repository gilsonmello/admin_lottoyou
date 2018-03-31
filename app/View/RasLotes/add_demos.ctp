<?php echo $this->Form->create('RasDemo', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR Demos')); ?>
<?= $this->Form->hidden('lote_id', [
    'value' => $lote['RasLote']['id']
])?>
<?= $this->Form->hidden('temas_raspadinha_id', [
    'value' => $lote['RasLote']['temas_raspadinha_id']
])?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">              
                <?php
                echo $this->Form->input('qtd_raspadinhas', array('label' => 'Quantidade', 'class' => 'form-control'
                    . '', 'placeholder' => '20', 'data-rule-min' => '0', 'data-rule-max' => '10', 'required' => true));
                ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">       
                <?php echo $this->Form->input('valor_premiado', [
                    'label' => 'Valor do Premio', 
                    'empty' => 'Sem premiação (0.00)',
                    'required' => true, 
                    'class' => 'form-control chosen', 
                    'options' => $numeros_possiveis
                ]); ?>      

                <!-- <?php echo $this->Form->input('valor_premiado', array('label' => 'Valor do Premio', 'class' => 'form-control money', 'placeholder' => '$: 10,00', 'required' => true)); ?> -->
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons', ['btnSubmitName' => 'Gerar Raspadinhas']) ?>
<?php echo $this->Form->end(); ?>

<hr/>
<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <h4>Bilhetes Premiados</h4>
            <table class="table table-bordered table-condensed table-striped">
                <tr>
                    <th style="width: 50%">Valor Prêmio</th>
                    <th style="width: 50%">Qtd. Geradas</th>
                </tr>
                <?php if (!empty($demos)) { ?>
                    <?php $totalGeradas = 0; ?>
                    <?php foreach ($demos as $key => $value) { ?>
                        <tr>
                            <td><?= $value['RasDemo']['premio'] ?></td>
                            <td><?= $value['RasDemo']['total_geradas'] ?></td>
                        </tr>
                        <?php $totalGeradas += $value['RasDemo']['total_geradas']; ?>
                    <?php } ?>
                    <tr>
                        <td>Total em Prêmios: </td>
                        <td><?= $totalGeradas ?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="3">Não há Registro</td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>