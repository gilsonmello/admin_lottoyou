<?php echo $this->Form->create('GelEmpresa', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR EMPRESA (FILIAL)')); ?>

<div class="card-body">
    <?php if(isset($cnpj_matriz_informado) && $cnpj_matriz_informado == 0){ ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info text-justify" style="margin-bottom: 15px;">
                <h4>Atenção!</h4>
                O CNPJ da empresa matriz é condição fundamental para liberação do cadastro de filiais. Pois, 
                somente através deste, poderemos checar a relação existente entre as empresas do grupo.
            </div>
        </div>
    </div>
    <?php } else { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info text-justify" style="margin-bottom: 15px;">
                <h4>Atenção!</h4>
                É terminantemente proibido efetuar o cadastro de empresas que não sejam filiais da 
                empresa informada durante o cadastro da conta de acesso.
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">                
                <?php echo $this->Form->input('nome', array('label' => 'Nome Fantasia', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">                
                <?php echo $this->Form->input('cnpj', array('label' => 'CNPJ', 'class' => 'form-control cnpj')); ?>
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
    <?php }  ?>
</div>
<?php echo $this->element('forms/buttons') ?>
<?php echo $this->Form->end(); ?>