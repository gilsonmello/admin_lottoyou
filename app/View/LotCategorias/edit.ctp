<?php echo $this->Form->create('LotCategoria', array('class' => 'form form-validate', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> EDITAR CATEGORIA Dos JOGOs')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
            <div class="form-group">              
                <?php echo $this->Form->input('nome', array('label' => 'Nome', 'class' => 'form-control', 'title' => 'Nome da categoria.', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2">
            <div class="form-group">                
                <?php echo $this->Form->input('dezena', array('label' => 'Dezenas', 'class' => 'form-control centena', 'title' => 'Números disponiveis no sorteio. Ex 100, 00 a 99', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2">
            <div class="form-group">                
                <?php echo $this->Form->input('dezena_sel', array('label' => 'Máximo de números', 'class' => 'form-control decimal', 'title' => 'Quantidade máxima de dezenas selecionaveis.', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2">
            <div class="form-group">
                <?php echo $this->Form->input('dezena_sel_min', array('label' => 'Mínimo de números', 'class' => 'form-control decimal', 'title' => 'Quantidade mínima de dezenas selecionaveis.', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2">
            <div class="form-group">
                <?php echo $this->Form->input('dezena_extra', array('label' => 'Dezenas extras', 'class' => 'form-control decimal', 'title' => 'Números de dezenas extras disponiveis no sorteio.', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
            <div class="form-group">
                <?php echo $this->Form->input('dezena_extra_sel', array('label' => 'Dezenas extras selecionáveis', 'class' => 'form-control decimal', 'title' => 'Quantidade de dezenas extras selecionaveis.', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
            <div class="form-group"> 
                <?php echo $this->Form->input('min_assertos', array('label' => 'Número mínimo de asserto', 'class' => 'form-control decimal', 'title' => 'Quantidade mínima de dezenas para asserto.', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
            <div class="form-group"> 
                <?php echo $this->Form->input('max_assertos', array('label' => 'Número máximo de asserto', 'class' => 'form-control decimal', 'title' => 'Quantidade de dezenas para o primeiro premio.', 'required' => true)); ?>
            </div>
        </div>
        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
            <?php echo $this->Form->input('zero_assertos', array('type' => 'radio', 'legend' => 'Zero pontos', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
            <div class="form-group"> 
                <?php echo $this->Form->input('extra_assertos', array('label' => 'Número de asserto das extras', 'class' => 'form-control decimal', 'title' => 'Quantidade de dezenas extras para asserto.', 'required' => true)); ?>
            </div>
        </div>

        <div class="col-lg-3" >
            <div class="form-group">   
                <?php echo $this->Form->input("value", [
                    'label' => 'Valor', 
                    'class' => 'form-control money',
                    'required' => true,
                ]) ?>
            </div>     
        </div>

        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'))); ?>
        </div>
        <div class="col-sm-12">

        </div>
    </div>
</div>
<?php echo $this->element('forms/buttons') ?>
<?php echo $this->Form->end(); ?>