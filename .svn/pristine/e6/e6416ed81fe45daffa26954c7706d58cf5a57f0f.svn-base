<style>
    .games .game {
        background: #efefef;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 30px;
        position: relative;
    }
    body {
        padding-top: 0;
        background: no-repeat #f0f0f0;
        color: #666;
        text-transform: initial !important;
    }

    .ItemHolder {
        margin: 5px;
        padding: 0 15px 25px;
        background: #EFEFEF;
        color: black;
        border-radius: 5px;
        -webkit-transition: all .5s ease;
        -moz-transition: all .5s ease;
        -o-transition: all .5s ease;
        transition: all .5s ease;
        cursor: pointer;
    }

    body {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
    }

    .card-raspadinha{
        /*width: 360px !important;*/
        /*height: 500px !important;*/
        height: 300px !important;
    }

    .play-demo {
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 5px;
        color: #fff;
        display: block;
        font-size: 13px;
        font-weight: 700;
        padding: 1px 15px 2px;
        transition: border 0.3s ease-in-out 0s;
    }

    a.button.green-but {
        width: 180px;
        margin: 15px auto 0;
    }

    a.button.green-but {
        background-color: #67be13;
        color: #fff;
        box-shadow: inset 0 -2px 0 0 rgba(0,0,0,.15);
        display: block;
        padding: 8px 13px 9px;
        text-align: center;
        font-size: 14px;
        width: 100%;
        text-align: center;
        border: none;
        font-weight: 700;
        border-radius: 5px;
        cursor: pointer;
        -webkit-transition: background-color .3s ease-in-out;
        transition: background-color .3s ease-in-out;
    }

/*    a:hover {
        background-color:#ccc;  cinza escuro 
    }*/


</style>
<section id="AppRaspadinhas" <?php echo ($modal == 1) ? 'style="padding:0;"' : '' ?>>
    <div class="section-body" <?php echo ($modal == 1) ? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b> Raspadinhas </b>
            </header>
            <!--                        <div class="tools">
                                        <button id="jogarRaspadinha" type="button" class="btn ink-reaction btn-default-light">
                                            <i class="fa fa-plus-square-o"></i>
                                            Jogar
                                        </button>
                                    </div>-->
        </div>

        <div class="card card-collapsed" style="min-height:500px;">
            <div id="gridViolencias" style="padding: 12px;">                
                <?php foreach ($temas as $key => $value) { ?>
                    <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4" style="margin-bottom: 50px; max-width:370.333px !important;">
                        <div class="game ItemHolder card-raspadinha card" style="padding-top: 8px;">
                            <span class="ng-scope" style="position: absolute;">
                                <?php echo ($value['TemasRaspadinha']['novo'] == 1) ?  '<img style="margin-left: -5px;" class="game-badge" src="'.BASE.'/webroot/img/raspadinha/novo.png" alt="Novo">' : ''; ?>
                            </span>
                            <div class="game-header">
                                <img class="header-image" style=" height: 150px; width: 100%;" src="<?php echo BASE . "/webroot/" . $value['TemasRaspadinha']['img_card_url']; ?>">
                                <div style="width: 100%; text-align: center; padding: 4px; background-color: #2FB9E3;">
                                    <p style="font-size: 14px; color: white;"><b><?php echo $value['TemasRaspadinha']['texto_index']; ?></b></p>
                                </div>
                                <div style="width: 100%;  padding: 12px; background-color: #0F546D;">
                                    <a class="" style="font-size: 14px; color: white; margin-left: 0px !important;"><i class="fa fa-money" aria-hidden="true" style="margin-right: 8px;"></i><b>Tabela de prêmios</b></a>
                                    <!--<p style="font-size: 14px; color: white;"><b>Ganhe até R$ 1000,00!</b></p>-->
                                    <a class="play-demo ng-pristine ng-valid" style="float: right; margin-top: -2px !important;">Demo</a>
                                </div>
                                <div class="descript">
                                    <!--<h2 class="ng-binding"><?php echo $value['TemasRaspadinha']['nome']; ?></h2>-->
                                    <a class="button green-but l247-btn-primary jogarRaspadinha" id="<?php echo $value['TemasRaspadinha']['id'] ?>">Jogue agora</a>
                                    <!--<button type="button" class="jogarRaspadinha btn btn-default-light" id="<?php echo $value['TemasRaspadinha']['id'] ?>">Jogar</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>