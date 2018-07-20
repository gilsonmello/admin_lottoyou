<?php echo $this->Form->create('Balance', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Inserir saldo')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-4 col-lg-4">
            <div class="form-group">                
                <?php echo $this->Form->input('nome', array(
                    'label' => 'Usuário',
                    'value' => $user['User']['name'].' '. $user['User']['last_name'],
                    'class' => 'form-control', 'required' => false, 'desactive', 'readonly')); ?>
            </div>
        </div>
        <div class="col-sm- col-lg-4 col-xs-12 col-md-4">
            <div class="form-group">
                <?php echo $this->Form->input('value', array('label' => 'Valor', 'value' => false, 'class' => 'form-control money', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-4 col-lg-4 col-xs-12 col-md-4">
            <div class="form-group">
                <?php echo $this->Form->input('key', array('label' => 'Chave de segurança', 'class' => 'form-control', 'required' => true)); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->Form->label('reason', 'Motivo<span style="color:red;">*</span>'); ?>
            <?php echo $this->Form->input('reason', [
                'escape' => false,
                'type' => 'textarea',
                'label' => false,
                'class' => 'form-control',
                'required' => true,
            ]); ?>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>