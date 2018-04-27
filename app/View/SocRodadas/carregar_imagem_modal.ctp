<?php echo $this->Form->create('SocRodada', array('enctype' => 'multipart/form-data' ,'class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR Imagem do Modal')); ?>
<div class="card-body">
    <div class="row">
    	<div class="col-sm-8 col-lg-4 col-md-4 col-xs-12">
    		<img src="<?= $this->Html->url('/' . $dados['SocRodada']['imagem_modal']); ?>" class="img-responsive">
    	</div>
        <div class="col-sm-8 col-lg-8 col-md-8 col-xs-12">
            <div class="form-group">
                <?php echo $this->Form->input('imagem_modal', [
                    'type' => 'file', 
                    'label' => 'Imagem do Modal',
                    'class' => 'form-control',
                    'accept' => "image/*"
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php $btnSubmitName = (isset($btnSubmitName)) ? $btnSubmitName : 'SALVAR'; ?>
<?php $disabled = (isset($disabled)) ? 'disabled="disabled"' : ''; ?>
<div class="modal-footer">
	<button type="button" class="btn btn-primary btn-loading-state carregar_imagem" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando..." <?php echo $disabled; ?>><?php echo $btnSubmitName; ?></button>
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin:0;">FECHAR</button>
</div>
<?php echo $this->Form->end(); ?>