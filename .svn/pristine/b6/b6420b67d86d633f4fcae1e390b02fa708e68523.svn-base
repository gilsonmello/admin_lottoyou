<?php echo $this->Form->create('SocJogo', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR Jogo')); ?>
<div class="card-body">
    <div class="row">
        <div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
            <div class="form-group">                
                <?php echo $this->Form->input('soc_bolao_id', array('label' => 'Bolão', 'class' => 'form-control', 'options' => $optionsBoloes, 'required' => true,'value' => $dados[0]['SocRodada']['soc_bolao_id'], 'readonly')); ?>
            </div>
        </div>                               
        <div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
            <div class="form-group">                
                <?php echo $this->Form->input('soc_rodada_id', array('label' => 'Rodada', 'class' => 'form-control readonly', 'options' => array($dados[0]['SocRodada']['id'] => $dados[0]['SocRodada']['nome']), 'readonly', 'required' => true, 'readonly')); ?>
            </div>
        </div>               
        <div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
            <div class="form-group">                
                <?php echo $this->Form->input('data_termino', array('label' => 'Data Término', 'class' => 'form-control date data', 'value' => $dados[0]['SocRodada']['data_termino'], 'required' => true, 'readonly')); ?>
            </div>
        </div>               
        <div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
            <div class="form-group">                
                <?php echo $this->Form->input('hora_termino', array('label' => 'Hora Término', 'class' => 'form-control hora', 'value' => $dados[0]['SocRodada']['hora_termino'], 'required' => true, 'readonly')); ?>
            </div>
        </div>
    </div>

    <div class="row" data-spy="affix" data-offset-top="200">
        <div  id='card-1'>
            <div class="card card-underline card-lista" id='divClone' style="display: none">
                <div class="card-head card-head-sm style-default-light">
                    <header style="padding-top: 0px; padding-bottom: 0px;">
                        <div class="col-md-5">
                            <div class="form-group"  style="padding-top: 0px; margin-bottom: 0px;">
                                <?php echo $this->Form->input('data', array('label' => false, 'placeholder' => 'Data', 'class' => 'form-control date data')); ?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group"  style="padding-top: 0px; margin-bottom: 0px;">
                                <?php echo $this->Form->input('hora', array('label' => false, 'placeholder' => '99:99:00', 'class' => 'form-control hora')); ?>
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
                    <div class="col-md-6 " style="">
                        <div class="form-group">
                            <?php echo $this->Form->input('gel_clube_casa_id', array('empty' => 'Selecione', 'class' => 'form-control ', 'options' => $optionsClubes, 'label' => 'Clube(casa)')) ?>
                        </div>               
                    </div>               
                    <!--end .col -->
                    <div class="col-md-6" style="">
                        <div class="form-group">
                            <?php echo $this->Form->input('gel_clube_fora_id', array('empty' => 'Selecione', 'class' => 'form-control ', 'options' => $optionsClubes, 'label' => 'Clube(fora)')) ?>
                        </div><!--end .card-body -->
                    </div><!--end .col -->
                </div><!--end .card-body -->
            </div><!--end .row  -->            
        </div><!--end .row  -->
        <div class="col-lg-12">
            <?php foreach ($dados as $value) { ?>
                <?php foreach ($value['SocJogo'] as $k => $v) { ?>
                    <div class="row well">
                        <div class="col-xs-5 col-md-5 col-lg-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <img class="img_time text-center" src="<?php echo @$v['escudo_clube_casa'] ?>"/>
                                    </span>
                                    <div class="input-group-content">
                                        <?php echo $this->Form->hidden($v['id'] . '.soc_clube_casa_id', array('value' => $v['gel_clube_casa_id'])); ?>
                                        <?php echo $this->Form->input($v['id'] . '.resultado_clube_casa', array('label' => @$v['nome_clube_casa'], 'class' => 'form-control', 'value' => @$v['resultado_clube_casa'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div><!--end .col -->

                        <div class="col-xs-2 col-md-2 col-sm-2 col-lg-2" style="text-align: center">
                            x
                        </div><!--end .col -->

                        <div class="col-xs-5 col-md-5 col-lg-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <img class="img_time text-center" src="<?php echo @$v['escudo_clube_fora'] ?>"/>
                                    </span>
                                    <div class="input-group-content">
                                        <?php echo $this->Form->hidden($v['id'] . '.soc_clube_fora_id', array('value' => $v['gel_clube_fora_id'])); ?>
                                        <?php echo $this->Form->input($v['id'] . '.resultado_clube_fora', array('label' => @$v['nome_clube_fora'], 'class' => 'form-control', 'value' => @$v['resultado_clube_fora'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div><!--end .col -->
                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
                            <div class="tools" style="top: 2px;z-index: 9">
                                <button type="button" class="btn ink-reaction btn-default btnDelete pull-right" style="" data-toggle="tooltip" title="Excluir Jogo">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </div><!--end .col -->
                    </div>  
                <?php } ?>
            <?php } ?>
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