<?php echo $this->Form->create('RasTabelasPremio', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR Tabela')); ?>
<div class="card-body">
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">                
                <?= $this->Form->input('tema_raspadinha_id', [
                    'label' => 'Tema', 
                    'class' => 'form-control chosen', 
                    'options' => $optionsTemas, 
                    'empty' => 'Selecione', 
                    'required' => true
                ]); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">              
                <?= $this->Form->input('nivel', [
                    'label' => 'Nível', 
                    'class' => 'integer form-control',
                    'required' => true
                ]); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">              
                <?= $this->Form->input('disponivel', [
                    'label' => 'Disponível', 
                    'class' => 'integer form-control',
                    'required' => true
                ]); ?>
            </div>
        </div>
        <div class="col-lg-2">
           <div class="form-group">              
                <?= $this->Form->input('quantia', [
                    'label' => 'Quantia', 
                    'class' => 'money form-control',
                    'required' => true
                ]); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <?= $this->Form->input('active', [
                'type' => 'radio', 
                'legend' => 'Ativo', 
                'class' => 'radio-inline radio-styled tipo', 
                'options' => [1 => 'Sim', 0 => 'Não'], 
                'value' => '1'
            ]); ?>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>