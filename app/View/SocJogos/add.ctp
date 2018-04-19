<?php echo $this->Form->create('SocJogo', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR Jogo')); ?>
<?php fb::info($dadosRodada, "\$dadosRodada"); ?>
<div class="card-body">
    <div class="row">
        <div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
            <div class="form-group">                
                <?php echo $this->Form->input('soc_bolao_id', array('label' => 'Bolão', 'class' => 'form-control chosen', 'options' => $optionsBoloes, 'empty' => 'Selecione', 'required' => true,'value' => $dadosRodada['SocRodada']['soc_bolao_id'], 'readonly' => true)); ?>
            </div>
        </div>                               
        <div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
            <div class="form-group">                
                <?php echo $this->Form->input('soc_rodada_id', array('label' => 'Rodada', 'class' => 'form-control chosen', 'options' => array($dadosRodada['SocRodada']['id'] => $dadosRodada['SocRodada']['nome']), 'required' => true,)); ?>
            </div>
        </div> 
        <div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
            <div class="form-group">                
                <label>Caso esteja faltando algum dado obrigátorio, o registro será ignorado.</label>
            </div>
        </div>              
        <div class="col-xs-12 col-md-3 col-sm-3 col-lg-3" style="display: none">
            <div class="form-group">                
                <?php echo $this->Form->input('data', array('label' => 'Data Término', 'class' => 'form-control date data','value' => $dadosRodada['SocRodada']['data_termino'])); ?>
            </div>
        </div>               
        <div class="col-xs-12 col-md-3 col-sm-3 col-lg-3" style="display: none">
            <div class="form-group">                
                <?php echo $this->Form->input('hora', array('label' => 'Hora Término', 'class' => 'form-control hora','value' => $dadosRodada['SocRodada']['hora_termino'])); ?>
            </div>
        </div>               
    </div>

    <div class="row" data-spy="affix" data-offset-top="200">
        <div  id='card-1'>
            <div class="card card-underline card-lista" id='divClone' style="display: none">
                <div class="card-head card-head-sm style-default-light">
                    <header style="">
                        <div class="col-md-4">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <?php echo $this->Form->input('local', array('label' => 'Local', 'class' => 'form-control', 'required' => true)); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <?php echo $this->Form->input('data', array('label' => 'Data', 'class' => 'form-control date', 'required' => true)); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style=" margin-bottom: 0px;">
                                <?php echo $this->Form->input('hora', array('label' => 'Hora', 'placeholder' => '99:99:00', 'class' => 'form-control hora', 'required' => true)); ?>
                            </div>
                        </div>
                    </header>
                    <div class="tools">
                        <div class="btn-group" style="margin-right: 0px;">
                            <button type="button" class="btn ink-reaction btn-collapse btn-default">
                                <i class="fa fa-angle-down"></i>
                            </button>
                        </div>
                    </div>
                </div><!--end .card-head -->
                <div class="card-body" style="display: block;">
                    <div class="row">
                        <div class="col-md-6 " style="">
                            <div class="form-group">
                                <?php echo $this->Form->input('gel_clube_casa_id', array('empty' => 'Selecione', 'class' => 'form-control ', 'options' => $optionsClubes, 'label' => 'Clube(casa)', 'required' => true)) ?>
                            </div>               
                        </div>               
                        <!--end .col -->
                        <div class="col-md-6" style="">
                            <div class="form-group">
                                <?php echo $this->Form->input('gel_clube_fora_id', array('empty' => 'Selecione', 'class' => 'form-control ', 'options' => $optionsClubes, 'label' => 'Clube(fora)', 'required' => true)) ?>
                            </div><!--end .card-body -->
                        </div><!--end .col -->
                        <!--end .dd.nestable-list -->
                    </div>
                </div><!--end .card-body -->
            </div><!--end .row  -->            
        </div><!--end .row  -->
        <div class="tools" style="text-align: right; margin-bottom: 5px;">
            <button id="btnClonar" type="button" class="btn ink-reaction btn-primary ">
                <i class="fa fa-plus-square"></i>
                Adicionar Jogo
            </button>
        </div>
        <hr/>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>