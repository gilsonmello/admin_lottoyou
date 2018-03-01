<?php echo $this->Form->create('LotUserJogo', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->Form->hidden('id'); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR NOVO jogo')); ?>
<div class="card-body">
    <h3>Área em desenvolvimento</h3>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <?php echo $this->Form->input('lot_jogo_id', array('label' => 'Tipo de jogo', 'class' => 'form-control chosen slqTipo', 'options' => $tiposJogos, 'empty' => 'Selecione um Jogo')); ?>
            </div>

        </div>
    </div>
    <div class="row" id="gridTabelaLotUserJogo">
        
    </div>
</div>
<div class="modal-footer" style="padding:14px 22px;">
    <button class="btn btn-primary btn-loading-state btnSalvarLotUserJogo" type="button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando...">SALVAR</button>
    <button class="btn btn-default pull-left" type="button" data-dismiss="modal" style="margin:0;">FECHAR</button>
</div>

<?php echo $this->Form->end(); ?>

