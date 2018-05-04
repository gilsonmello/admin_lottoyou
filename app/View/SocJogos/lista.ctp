<?php echo $this->Form->create('SocAposta', array('class' => 'form form-validate floating-label', 'role' => 'form ')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Apostar')); ?>
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
<div class="card-body" style="background-image: url('http2://3.bp.blogspot.com/-_DCyodoUEhQ/U-PZooyRiRI/AAAAAAAAMBg/fzI-HDksqoQ/s1600/10455434_1450466748553965_5286216227028659570_n.jpg')">
    <?php foreach ($dados as $value) { ?>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <ol class="breadcrumb" style="background: none">
                    <li>
                        <?php echo $value['SocRodada']['bolao'] ?>
                    </li>
                    <li class="">
                        <?php echo $value['SocRodada']['nome'] ?> 
                        <label class="label label-info">
                            <?php echo $value['SocRodada']['tipo_name'] ?> 
                        </label>
                    </li>
                </ol>
            </div>
        </div>
        <?php foreach ($value['SocJogo'] as $k => $v) { ?>
            <?php // echo $this->Form->hidden('soc_jogo_id', array('value' => ));?>
            <div class="row vcenter">
                <!--end .col -->
                <div class="col-xs-5 col-md-5 col-lg-5">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <img class="img_time text-center" src="<?php echo @$v['escudo_clube_casa'] ?>"/>
                            </span>
                            <div class="input-group-content">
                                <?= $this->Form->hidden($v['id'] . '.soc_rodada_id', [
                                    'value' => $soc_rodada_id
                                ]); ?>
                                <?= $this->Form->hidden($v['id'] . '.soc_clube_casa_id', [
                                    'value' => $v['gel_clube_casa_id']
                                ]); ?>
                                <?= $this->Form->input($v['id'] . '.resultado_clube_casa', [
                                    'label' => @$v['nome_clube_casa'], 
                                    'class' => 'form-control'
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
                                <img class="img_time text-center" src="<?php echo @$v['escudo_clube_fora'] ?>"/>
                            </span>
                            <div class="input-group-content">
                                <?php echo $this->Form->hidden($v['id'] . '.soc_clube_fora_id', array('value' => $v['gel_clube_fora_id'])); ?>
                                <?php echo $this->Form->input($v['id'] . '.resultado_clube_fora', array('label' => @$v['nome_clube_fora'], 'class' => 'form-control')) ?>
                            </div>
                        </div>
                    </div>
                </div><!--end .col -->
            </div><!--end .row  -->
        <?php } ?>
    <?php } ?>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>