<section id="AppLotJogos" style="margin-top: 20px">
    <h1>Loterias</h1>
    <hr/>
    <div class="row">
        <div class="card-body">
            <?php foreach ($dados as $key => $value) { ?>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body no-padd/ing alert alert-callout alert-info no-margin">
                            <div class="no-padding">
                                <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;">
                                    <div class="col-sm-4" style="padding-left: 0px;" >
                                        <?php echo $this->Html->image('http://www.lottoland.com/pt/skins/lottoland/images/lotteryLogos/lt-elGordoPrimitiva.x2-bc4cde5fe7329ee5.png', array('style' => 'background-position: center 0;
    background-repeat: no-repeat;
    background-size: 60px auto;
    height: 60px;
    margin-right: 14px;
    min-width: 60px;
    width: 60px;')) ?>
                                    </div>
                                    <div class="col-sm-8" style="text-align: right; padding-right: 0px;">
                                        <span class="text-primary" style="font-weight: bold"><?php echo $value['LotJogo']['sorteio'] ?></span><br>
                                        <span class="valorCardLoteria">R$ <?php echo $this->App->converterValorReal($value['LotJogo']['premio']) ?></span>
                                    </div>
                                </div>
                                <hr/>
                                <!--<div class="titleCardLoteria2"><?php echo $value['LotJogo']['sorteio'] ?> </div>-->
                                <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;">
                                    <!--<div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;">-->
                                        <div class="col-sm-6" style="padding-left: 0px;" >
                                            <span class="countdown i iHourglass">2 dias 22h</span>
                                        </div>
                                        <div class="col-sm-6" style="padding-left: 0px;" >
                                            <div class="btn btn_lotto_you goOn arrow btnJogarLoteria" style="top: 0px;" id="<?php echo $value['LotJogo']['lot_categoria_id'] ?>">Jogar agora</div>
                                        </div>
                                    <!--</div>-->
                                </div>
                                <div class="stick-bottom-left-right">
                                    <div class="progress progress-hairline no-margin">
                                        <div class="progress-bar progress-bar-success" style="width:13%"></div>
                                    </div>
                                </div>
                                <!--</div>-->
                            </div>
                        </div><!--end .card-body -->
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>