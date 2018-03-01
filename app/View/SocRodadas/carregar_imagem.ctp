<?php echo $this->Form->create('SocRodada', array('enctype' => 'multipart/form-data' ,'class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR Imagem de Fundo')); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-12- col-lg-12 col-md-12 col-xs-12">
            <div class="form-group">
                <?php echo $this->Form->input('imagem_capa', array('type' => 'file', 'label' => 'Imagem', 'class' => 'form-control')); ?>
            </div>
        </div>
    </div>
</div>
<?php $btnSubmitName = (isset($btnSubmitName)) ? $btnSubmitName : 'SALVAR'; ?>
<?php $disabled = (isset($disabled)) ? 'disabled="disabled"' : ''; ?>
<div class="modal-footer">
	<button type="button" id="carregar_imagem" class="btn btn-primary btn-loading-state" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando..." <?php echo $disabled; ?>><?php echo $btnSubmitName; ?></button>
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin:0;">FECHAR</button>
</div>
<?php echo $this->Form->end(); ?>