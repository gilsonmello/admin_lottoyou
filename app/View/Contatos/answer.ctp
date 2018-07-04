<?php echo $this->Form->create('Contato', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Responder Contato')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-6 col-lg-6">
            <div class="form-group">                
                <?php echo $this->Form->input('name', array('label' => 'Nome', 'class' => 'form-control', 'required' => false, 'disabled' => true, 'readonly' => true)); ?>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6">
            <div class="form-group">
                <?php echo $this->Form->input('email', array('label' => 'E-mail', 'class' => 'form-control', 'required' => false, 'disabled' => true, 'readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5 col-lg-5">
            <div class="form-group">
                <?php echo $this->Form->input('category', array('value' => $this->request->data['ContatoCategoria']['name'], 'label' => 'Categoria', 'class' => 'form-control', 'required' => false, 'disabled' => true, 'readonly' => true)); ?>
            </div>
        </div>
        <div class="col-sm-4 col-lg-4">
            <div class="form-group">
                <?php echo $this->Form->input('subject', array('label' => 'Assunto', 'class' => 'form-control', 'required' => false, 'disabled' => true, 'readonly' => true)); ?>
            </div>
        </div>
        <div class="col-md-3 col-lg-3">
            <?php echo $this->Form->input('answered', [
                'type' => 'radio',
                'legend' => 'Respondido?',
                'class' => 'radio-inline radio-styled tipo',
                'options' => [1 => 'Sim', 0 => 'Não'],
                'disabled' => true, 'readonly' => true
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <?php if($this->request->data['Contato']['file'] != null) { ?>
                <a href="<?= $this->request->data['Contato']['file'] ?>" target="_blank" class="btn btn-xs btn-info">
                    Clique aqui para visualizar o arquivo
                </a>
            <?php } else { ?>
                <span>Nenhum arquivo enviado</span>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->Form->label('description', 'Descrição do Contato'); ?>
            <?php echo $this->Form->input('description', [
                'escape' => false,
                'type' => 'textarea',
                'label' => false,
                'class' => 'form-control',
                'disabled' => true, 'readonly' => true
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->Form->label('answer', 'Resposta do Contato'); ?>
            <?php echo $this->Form->input('answer', [
                'escape' => false,
                'type' => 'textarea',
                'label' => false,
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>