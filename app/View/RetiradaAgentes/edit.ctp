<?php echo $this->Form->create('RetiradaAgente', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Enviar mensagem')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-3 col-lg-3">
            <div class="form-group">                
                <?php echo $this->Form->input('name', array(
                    'label' => 'Nome',
                    'class' => 'form-control',
                    'required' => false,
                    'disabled' => true,
                    'readonly' => true,
                )); ?>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div class="form-group">
                <?php echo $this->Form->input('bank', array('label' => 'Banco', 'class' => 'form-control', 'required' => false, 'disabled' => true,
                    'readonly' => true,)); ?>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div class="form-group">
                <?php echo $this->Form->input('agency', array('label' => 'Agência', 'class' => 'form-control', 'required' => false, 'disabled' => true,
                    'readonly' => true,)); ?>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div class="form-group">
                <?php echo $this->Form->input('number', array('label' => 'N. conta', 'class' => 'form-control', 'required' => false, 'disabled' => true,
                    'readonly' => true,)); ?>
            </div>
        </div>
        <!--<div class="col-md-3 col-lg-3">
            <?php /*echo $this->Form->input('fechada', [
                'type' => 'radio', 
                'legend' => 'Fechada?', 
                'class' => 'radio-inline radio-styled tipo', 
                'options' => [1 => 'Sim', 0 => 'Não']
            ]); */?>
        </div>-->
    </div>
    <div class="row">
        <div class="col-sm-2 col-lg-2">
            <div class="form-group">
                <?php
                    $accountType = '';
                    if($this->request->data['RetiradaAgente']['account_type'] == 1) $accountType = 'C. corrente';
                    else if($this->request->data['RetiradaAgente']['account_type'] == 2) $accountType =  'C. poupança';
                ?>
                <?php echo $this->Form->input('account_type', array(
                    'label' => 'Tipo de conta',
                    'class' => 'form-control',
                    'required' => false,
                    'disabled' => true,
                    'readonly' => true,
                    'value' => $accountType
                )); ?>
            </div>
        </div>
        <div class="col-sm-2 col-lg-2">
            <div class="form-group">
                <?php
                    $operation = 'Não informado';
                    if($this->request->data['RetiradaAgente']['operation'] != null) $operation = $this->request->data['RetiradaAgente']['operation'];
                ?>
                <?php echo $this->Form->input('operation', array(
                    'label' => 'Operação',
                    'class' => 'form-control',
                    'required' => false,
                    'disabled' => true,
                    'readonly' => true,
                    'value' => $operation
                )); ?>
            </div>
        </div>
        <div class="col-sm-4 col-lg-4">
            <div class="form-group">
                <?php
                $doc_type = 'Não informado';
                if($this->request->data['RetiradaAgente']['doc_type'] == 1) $doc_type = 'CPF';
                else if($this->request->data['RetiradaAgente']['doc_type'] == 2) $doc_type = 'Carteira de Identidade';
                else if($this->request->data['RetiradaAgente']['doc_type'] == 3) $doc_type = 'Carteira de motorista';
                else if($this->request->data['RetiradaAgente']['doc_type'] == 4) $doc_type = 'Passaporte';
                else if($this->request->data['RetiradaAgente']['doc_type'] == 5) $doc_type = 'Outro';
                ?>
                <?php echo $this->Form->input('doc_type', array(
                    'label' => 'Tipo de documento',
                    'class' => 'form-control',
                    'required' => false,
                    'disabled' => true,
                    'readonly' => true,
                    'value' => $doc_type
                )); ?>
            </div>
        </div>
        <div class="col-sm-4 col-lg-4">
            <div class="form-group">
                <?php echo $this->Form->input('identification', array('label' => 'Doc. identificação', 'class' => 'form-control', 'required' => false, 'disabled' => true,
                    'readonly' => true,)); ?>
            </div>
        </div>
        <div class="col-sm-4 col-lg-4">
            <div class="form-group">
                <?php echo $this->Form->input('country', array(
                    'label' => 'País',
                    'class' => 'form-control',
                    'required' => false,
                    'disabled' => true,
                    'readonly' => true,
                    'value' => $country['Country']['name']
                )); ?>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <?php echo $this->Form->input('finish', [
                'type' => 'radio',
                'legend' => 'Finalizado?',
                'class' => 'radio-inline radio-styled tipo',
                'options' => [1 => 'Sim', 0 => 'Não']
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="form-group">
                <?= $this->Form->label('message', 'Mensagem'); ?>
                <?php echo $this->Form->input('message', [
                    'escape' => false,
                    'type' => 'textarea',
                    'label' => false,
                    'required' => true,
                    'class' => 'form-control',
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php if($this->request->data['RetiradaAgente']['finish'] == 1) { ?>
    <?php echo $this->element('formsButtons', ['disabled' => true]) ?>
<?php } else { ?>
    <?php echo $this->element('formsButtons') ?>
<?php } ?>
<?php echo $this->Form->end(); ?>