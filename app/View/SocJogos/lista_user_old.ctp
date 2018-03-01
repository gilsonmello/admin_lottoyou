<?php echo $this->Form->create('SocAposta', array('class' => 'form form-validate floating-label', 'role' => 'form ')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> MEU JOGO')); ?>
<style type="text/css">
    .img_time{
        width: 35px;
    }
</style>
<div class="card-body" style="background-image: url('http2://3.bp.blogspot.com/-_DCyodoUEhQ/U-PZooyRiRI/AAAAAAAAMBg/fzI-HDksqoQ/s1600/10455434_1450466748553965_5286216227028659570_n.jpg'); padding-top: 5px; padding-bottom: 5px;" >
    <!--<div style="position: absolute; background-color: windowtext; opacity: 0.5; margin-top: 0px; top: 0; bottom: 3%; height: 100%; left: 2%; width: 96%;"></div>-->
    <div class="col-xs-12 col-md-12 col-lg-12">
        <?php foreach ($dadosUser as $v) { ?>
            <div class="row ">
                <!--end .col -->
                <div class="col-xs-5 col-md-5 col-lg-5">
                    <div class="col-xs-6 col-md-6 col-lg-6" style="float: right">
                        <div class="form-group"  style="margin-bottom: 0px;">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <?php echo $this->Html->image($v['SocJogo']['escudo_clube_casa'], array('class' => 'img_time')) ?>
                                </span>
                                <div class="input-group-content">
                                    <?php echo $this->Form->hidden($v['SocAposta']['soc_rodada_id'] . '.soc_rodada_id', array('value' => $v['SocAposta']['soc_rodada_id'])); ?>
                                    <?php // echo $this->Form->hidden($v['SocJogo']['soc_jogo_id'].'.gel_clube_casa_id', array('value' => $v['SocJogo']['gel_clube_casa_id']));?>
                                    <?php echo $this->Form->input($v['SocAposta']['soc_jogo_id'] . '.resultado_clube_casa', array('label' => false, 'class' => 'form-control', 'value' => $v['SocAposta']['resultado_clube_casa'], 'style' => 'text-align: center')) ?>
                                </div>                                
                            </div>
                        </div>
                        <div style="">
                            <p> <label for="TicketSubject"><?php echo @$v['SocJogo']['nome_clube_casa'] ?></label></p>
                        </div><!--end .col -->
                    </div><!--end .col -->
                </div><!--end .col -->

                <div class="col-xs-2 col-sm-2 col-lg-2" style="text-align: center">
                    x
                </div><!--end .col -->
                <div class="col-xs-5 col-md-5 col-lg-5">
                    <div class="col-xs-6 col-md-6 col-lg-6" style="float: left">
                        <div class="form-group"  style="margin-bottom: 0px;">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <?php echo $this->Html->image($v['SocJogo']['escudo_clube_fora'], array('class' => 'img_time')) ?>
                                </span>

                                <div class="input-group-content">
                                    <?php echo $this->Form->hidden($v['SocAposta']['soc_jogo_id'] . '.soc_clube_fora_id', array('value' => $v['SocJogo']['gel_clube_fora_id'])); ?>
                                    <?php echo $this->Form->input($v['SocAposta']['soc_jogo_id'] . '.resultado_clube_fora', array('label' => false, 'class' => 'form-control', 'value' => $v['SocAposta']['resultado_clube_fora'], 'style' => 'text-align: center')) ?>
                                </div>
                            </div>
                        </div>
                        <div style="">
                            <p><label for="TicketSubject"><?php echo @$v['SocJogo']['nome_clube_fora'] ?></label></p>
                        </div>
                    </div>
                </div><!--end .col -->
            </div><!--end .row  -->
            <hr style="margin-top: 0px; margin-bottom: 0px;" >
        <?php } ?>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>