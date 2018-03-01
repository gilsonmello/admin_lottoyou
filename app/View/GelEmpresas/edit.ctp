<?php echo $this->Form->create('GelEmpresa', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php $tipo = ($this->data['GelEmpresa']['matriz'] == 1) ? 'MATRIZ' : 'FILIAL'; ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-edit"></i> EDITAR EMPRESA ('.$tipo.')')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <?php if(isset($existe_filiais) && $existe_filiais > 0 && $this->data['GelEmpresa']['matriz'] == 1){ ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info text-justify" style="margin-bottom: 15px;">
                <h4>Atenção!</h4>
                Ao cadastrar filiais, automaticamente, o CNPJ da empresa matriz é bloqueado para alteração. 
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">                
                <?php echo $this->Form->input('nome', array('label' => 'Nome Fantasia', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">     
                <?php $readonly = ($existe_filiais && $this->data['GelEmpresa']['matriz'] == 1) ? 'true' : 'false'; ?>           
                <?php echo $this->Form->input('cnpj', array('label' => 'CNPJ', 'class' => 'form-control cnpj', 'readonly' => $readonly)); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">                
                <?php echo $this->Form->input('razao', array('label' => 'Razão Social', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'),'value'=>1)); ?>
        </div>
    </div>
</div>
<?php echo $this->element('forms/buttons') ?>
<?php echo $this->Form->end(); ?>