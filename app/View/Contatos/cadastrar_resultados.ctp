<?= $this->Form->create('SocJogo', ['class' => 'form form-validate floating-label', 'role' => 'form']); ?>

<div class="card" style="margin-bottom:0;box-shadow:none;">
    <div class="card-head card-head-sm style-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-right:24px;padding-top:14px;"><span aria-hidden="true">&times;</span></button>
        <header>
            <i class="fa fa-plus-square"></i> Cadastrar Resultados
        </header>
    </div>
</div>
<style type="text/css">
    .img_time {
        width: 35px;
    }
    
    .vcenter {
        display: flex;
        align-items: center;
    }

    @media (max-width: 330px) {
        .input-group-addon {
            display: block !important;
            min-width: 100% !important;
            margin-left: 0 !important;
            text-align: center !important;
        }
    }

    @media (max-width: 432px) {
        label {
            font-size: 12px !important;
        }
    }
    /*.form-control{*/
    /*        color: white;
        }
        .input-group-content > label{
            color: white;
            text-align: center;
        }*/
    /*    input{
            color: white;
            text-align: center;
        }*/
</style>
<div class="card-body">
    
    <?php if($categoria['SocRodada']['active'] == 1) { ?>
        <div class="row">
            <div class="col-lg-12">
                <button id="<?= $categoria['SocRodada']['id'] ;?>" type="button" class="btn btn-loading-state btn-xs btn-info btnAtualizarPontuacao" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando...">
                    Atualizar Pontuação
                </button>
                <button id="<?= $categoria['SocRodada']['id'] ;?>" type="button" class="btn btn-loading-state btn-xs btn-info btnGerarPremiacao" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando...">
                    Gerar Premiação
                </button>
            </div>
        </div>
    <?php } ?>
    
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <ol class="breadcrumb" style="background: none">
                <li>
                    <?php echo $categoria['SocRodada']['bolao']; ?>
                </li>
                <li class="">
                    <?php echo $categoria['SocRodada']['nome'] ?> 
                    <label class="label label-info">
                        <?php echo $categoria['SocRodada']['tipo_name'] ?> 
                    </label>
                </li>
            </ol>
        </div>
    </div>
    <?php foreach ($jogos as $k => $v) { ?>
        <?php // echo $this->Form->hidden('soc_jogo_id', array('value' => ));?>
        <div class="row vcenter">
            <!--end .col -->
            <div class="col-xs-5 col-md-5 col-lg-5">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <img class="img_time text-center" src="/<?php echo @$v['SocJogo']['escudo_clube_casa'] ?>"/>
                        </span>
                        <div class="input-group-content">
                            <?= $this->Form->hidden($v['SocJogo']['id'] . '.soc_rodada_id', [
                                'value' => $soc_rodada_id
                            ]); ?>
                            <?= $this->Form->hidden($v['SocJogo']['id'] . '.gel_clube_casa_id', [
                                'value' => $v['SocJogo']['gel_clube_casa_id']
                            ]); ?>
                            <?= $this->Form->input($v['SocJogo']['id'] . '.resultado_clube_casa', [
                                'label' => @$v['SocJogo']['nome_clube_casa'], 
                                'class' => 'form-control',
                                'value' => $v['SocJogo']['resultado_clube_casa']
                            ]) ?>
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
                            <img class="img_time text-center" src="/<?php echo @$v['SocJogo']['escudo_clube_fora'] ?>"/>
                        </span>
                        <div class="input-group-content">
                            <?= $this->Form->hidden($v['SocJogo']['id'] . '.gel_clube_fora_id', [
                                'value' => $v['SocJogo']['gel_clube_fora_id']
                            ]); ?>
                            <?= $this->Form->input($v['SocJogo']['id'] . '.resultado_clube_fora', [
                                'label' => @$v['SocJogo']['nome_clube_fora'], 
                                'class' => 'form-control',
                                'value' => $v['SocJogo']['resultado_clube_fora']
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div><!--end .col -->
        </div><!--end .row  -->
    <?php } ?>    
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>