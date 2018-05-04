<?php echo $this->Form->create('SocAposta', array('class' => 'form form-validate floating-label', 'role' => 'form ')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> MEU JOGO')); ?>
<style type="text/css">
    .img_time{
        width: 35px;
    }
    .content{
        display: block;
        position: relative;
        text-align: center;
    }
    .text-white{
        color: #fff;
    }
    .backgroud-blueviolet{
        background-color: blueviolet;
    }
    .vcenter {
        display: flex;
        align-items: center;
    }
    .text-date{
        font-size: 11px;
    }
    .text-scoreboard{
        font-size: 30px;
        padding: 22px;
    }
    .text-local{
        font-size: 11px;
    }
    .table-game{
        width: 100%;
    }
    .img-responsive{
        max-width: 100%;
        margin: 0 auto;
    }
    .text-team{
        font-size: 20px;
    }

    @media (max-width:768px){
        .text-scoreboard{
            font-size: 18px;
            padding: 0;
        }
        .text-team{
            font-size: 15px;
        }
        .no-padding{
            padding: 0 !important;
        }
    }
</style>
<div class="card-body backgroud-blueviolet" style=" padding-top: 5px; padding-bottom: 5px;" >
    <div class="container" style="width: 100% !important">
        <?php foreach ($dadosUser as $v) { ?>
            <div class="row vcenter table-game">
                <div class="col-lg-4 col-xs-4 col-sm-4 col-md-4">
                    <div class="content">
                        <?php echo $this->Html->image($v['SocJogo']['escudo_clube_casa'], array('class' => 'img_time')) ?>
                        <p class="text-center text-team text-white">
                            <?= @$v['SocJogo']['nome_clube_casa'] ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-4 col-sm-4 col-md-4">
                    <div class="row">
                        <div class="col-lg-12 no-padding">
                            <p class="text-date text-center text-white">
                                <?= $this->App->dataExtenso(@$v['SocJogo']['data']) .' às '. @$v['SocJogo']['hora']?>
                            </p>
                            <!--<p class="text-date text-center text-white">DOM, 02/07/2017 16:00</p>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="text-scoreboard text-center text-white"><?php echo $v['SocAposta']['resultado_clube_casa'] ?> X <?php echo $v['SocAposta']['resultado_clube_fora'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 no-padding">
                            <p class="text-local text-center text-white">Local: <?php echo @$v['SocJogo']['local'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-4 col-sm-4 col-md-4">
                    <div class="content">
                        <?php echo $this->Html->image($v['SocJogo']['escudo_clube_fora'], array('class' => 'img_time')) ?>
                        <p class="text-center text-team text-white"><?php echo @$v['SocJogo']['nome_clube_fora'] ?></p>
                    </div>
                </div>
            </div><hr/>
        <?php } ?>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>