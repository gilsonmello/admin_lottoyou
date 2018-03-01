
<style>

    *::before, *::after {
        box-sizing: border-box;
    }
    *::before, *::after {
        box-sizing: border-box;
    }
    * {
        box-sizing: border-box;
    }

    #game-container #left-bottom-container #info-box-container, #game-container #result-container .result.lost {
        color: #f2d472;
    }
    #right-bottom-container #btn-container .play-clear-btn {
        cursor: pointer;
        display: block;
        margin: 0;
        width: 100%;
        z-index: 100;
    }
    .btn{
        text-transform: inherit;
    }
    #raspadinha100 .modal-content{
        height: 40% !important;
    }
    .btn-game {
        background: rgba(0, 0, 0, 0) linear-gradient(to bottom, #c3dc41 0px, #97bd00 100%) repeat scroll 0 0;
        border: 0 none;
        border-radius: 5px;
        box-shadow: 0 -4px 0 -2px #708f00 inset;
        box-sizing: border-box;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-family: "kievit",arial,sans-serif;
        font-size: 24px;
        font-weight: 700;
        line-height: 48px;
        padding: 0 15px;
        text-align: center;
        text-decoration: none;
        text-shadow: 1px 1px 2px #586e00;
        vertical-align: bottom;
    }
    #result-container .lost {
        border-color: #baa359;
        line-height: 36px;
        font-weight: bold;
        text-align: center;

    }
    #game-container #left-container #welcome-container .info-text {
        line-height: 22px;
        margin: 0;
        min-height: 88px;
        padding: 0 8px;
    }
    #result-container .result {
        margin-left: -10px !important;
        color: #fff;
        border-color: #baa359;
        font-family: "kievit",Helvetica,Arial,sans-serif;
        font-size: 20px;

    }
    #result-container .won {
        color: #628208;
    }
    #result-container .won .msg {
        font-size: 20px;
        line-height: 28px;
        margin-top: 0;
    }
    html, body {
        font-family: "arial";
    }
    body {
        color: #333;
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857;
    }
    html, body {
        font-family: "arial";
    }
    html {
        font-size: 10px;
    }
    html {
        font-family: sans-serif;
    }

    .scratchpad canvas, .scratchpad img{
        left: 0 !important;
        right: 0 !important;
    }

    .bgimg {
        background-image: <?php echo $background ?>;
        background-repeat: no-repeat;
        -moz-background-size: 100% 100%;
        -webkit-background-size: 100% 100%;
        background-size: 100% 100%;

    }
    .result.lost {
        border: 1px solid transparent;
        background: rgba(0, 0, 0, 0.8) none repeat scroll 0 0;
        border-color: #baa359;
        color: #f2d472;
        font-size: 21px !important;
        font-weight: bold;
        width: 411px;
        line-height: 36px;
    }
    .result.won {
        width: 411px;
        background: #fff !important;
        color: #628208 !important;
        border: 1px solid transparent !important;
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif !important;
        border-color: white !important;
    }
    .scratchpad {
        margin: 5px !important;  
    }

    .teste2 .row{
        float: right;
        margin-left: 10px;
    }

    #toast-info{
        margin-top: 25px !important;
        margin-bottom: 6px !important;
    }
    .btn-game {
        margin-top: 25px !important;
        margin-bottom: 6px !important;
    }

    #result-container .sub {
        text-align: center;
        font-size: 14px;
        display: block;
        margin-top: -4px;
        font-weight: bold;
    }

    @media (min-width: 1200px) and  (max-width: 5000px){
        .scratchpad {
            width: 128px !important;
            height: 128px !important;
        }
        .btn-game {
            margin-left: 2px !important;
            width: 403px !important;
        }
        /*        #raspadinha100 .modal-content{
                    width: 900px !important;
                }*/
        .divToast{
            width: 437px !important;
        }
        .msg{
            text-align: center;
            padding-right: 8px;
            padding-bottom: 4px;
            padding-top: 4px;
            font-weight: bold;
        }
        .info-text{
            margin-top: 4px !important;
            margin-bottom: 4px !important;
            font-size: 15px;
        }
        .clearfix{
            margin-left: -20px;
            width: 411px;
        }
        .result lost{
            border-color: #baa359;
        }

    }


    @media (min-width: 1024px) and  (max-width: 1199px){
        #raspadinha100 .modal-content{
            width: 700px !important;
            margin-left: 100px !important;
        }
        /*        #raspadinha100 .modal {
                    align-content: center;
                    text-align: center;
                    padding: 0 !important;
                }*/

        /*        #raspadinha100 .modal:before {
                    align-content: center;
                    content: '';
                    display: inline-block;
                    height: 100%;
                    vertical-align: middle;
                    margin-right: -4px;
                }*/

        /*        #raspadinha100 .modal-dialog {
                    align-content: center;
                    display: inline-block;
                    text-align: left;
                    vertical-align: middle;
                }*/
        .scratchpad {
            width: 91px !important;
            height: 91px !important;
        }
        .btn-game {
            margin-left: 17px !important;
            width: 291px !important;
            font-size: 20px;
        }
        .divToast{
            width: 337px;
        }
        .msg{
            padding-right: 8px;
            padding-bottom: 8px;
            font-size: 18px;
            font-weight: bold;
        }
        .info-text{
            margin-top: 4px !important;
            margin-bottom: 4px !important;
            font-size: 15px;
        }
        .clearfix{
            margin-top: -90px;
            margin-left: -10px;
            width: 310px;
        }
        .result.lost {
            width: 310px !important;
        }
        #result-container{
            margin-top: 140px !important;
        }
        .result.won {
            width: 310px !important;
        }
        .won{
            font-size: 18px !important;
            text-align: center;
        }
        .sub{
            font-size: 14px !important;
            text-align: center;
            font-weight: bolder;
        }

    }

</style>
<div class="modal-header" style="background-color: #1a5c7a;color: #fff;height: 50px;">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" background-color: #fff;color: #000;padding: 0 5px;position: absolute;right: 15px;top: 15px; border-radius: 5px; width: 25px; height: 25px;"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" id="myModalLabel" style="font-weight: bold; text-align: center;font-size: 17px; font-family: inherit;">Demo de Raspadinhas sem prêmios</h4>
</div>
<div class="modal-content/" style="border-radius: 5px">
    <div ondragstart="return false;" ondrop="return false;" class="card-body">
        <!--<button type="button" class="btn ink-reaction btn-lg btn-floating-action btn-game pull-right" style=" background-color: #ffdd72;border-color: white;border-radius: 30px;color: black;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <div class="row bgimg" style="border-radius: 5px">
            <div id="game-container" class="col-sm-12 col-lg-12" >
                <!--<div class="row">-->
                <div id="left-container" class="col-sm-6 col-lg-5" style="padding-top: 3%;">
                    <div id="welcome-container">
                        <div id="ticket-number2" style="color: white;">ID do Bilhete: <span class="idBilhete"></span></div>
                        <div class="cleafix card-body">
                        </div>
                        <div id="result-container" hide style="margin-top: 158px;">
                            <div class="clearfix card-body" style="text-align: center;">
                                <p class="info-text" style="color: <?php echo $corTextoRasp ?>; font-weight: bold;"><br><?php echo $textoRaspadinha ?></p>
                            </div>
                            <div id="resultado" class="result">
                                <div class="msg" style="display: block"></div>
                                <span class="sub"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-sm-6 col-md-6 col-xs-12 right-container teste2" style="padding-top: 5px;">
                    <div class="row">
                        <div id="20" class="scratchpad col-md-2 col-lg-2 col-sm-2 col-xs-2"></div>
                        <div id="21" onmousedown="return false" class="scratchpad col-md-2 col-lg-2 col-sm-2 col-xs-2"></div>
                        <div id="22" onmousedown="return false" class="scratchpad col-md-2 col-lg-2 col-sm-2 col-xs-2"></div>
                    </div>
                    <div class="row">
                        <div id="23" onmousedown="return false" class="scratchpad col-md-2 col-lg-2 col-sm-2 col-xs-2"></div>
                        <div id="24" onmousedown="return false" class="scratchpad col-md-2 col-lg-2 col-sm-2 col-xs-2"></div>
                        <div id="25" onmousedown="return false" class="scratchpad col-md-2 col-lg-2 col-sm-2 col-xs-2"></div>
                    </div>
                    <div class="row">
                        <div id="26" onmousedown="return false" class="scratchpad col-md-2 col-lg-2 col-sm-2 col-xs-2"></div>
                        <div id="27" onmousedown="return false" class="scratchpad col-md-2 col-lg-2 col-sm-2 col-xs-2"></div>
                        <div id="28" onmousedown="return false" class="scratchpad col-md-2 col-lg-2 col-sm-2 col-xs-2"></div>
                    </div>
                </div>
                <!--</div>-->
            </div>
            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                <div class="row">
                    <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 divToast">
                        <a id="toast-info" class="btn btn-lg btn-block btn-raised btn-default-bright ink-reaction play-clear-btn" style="background: rgba(0, 0, 0, 0.8) none repeat scroll 0 0; border-color: #baa359; color: #f2d472; font-size: 12px; text-align: left; width: 100%;">
                            <p class="info-text">Raspadinhas restantes: <span id="raspadinhasDisponiveis" style=""><?php echo $quantidadeRaspadinha; ?></span></p>
                        </a>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 botoes">
                        <a href="javascript: void(0);" id="ajax-loader" class="btn btn-game btn-lg play-clear-btn" style="width: 100%">
                            Carregando&nbsp;
                            <img src="../img/raspadinha/ajax-loader.gif">
                        </a>
                        <?php echo $this->Html->link('Revelar todas', 'javascript: void(0);', array('class' => 'btn btn-game btn-lg play-clear-btn', 'id' => 'limpar', 'style' => 'width: 100%')) ?>
                        <?php echo $this->Html->link('Jogar Raspadinha', 'javascript: void(0);', array('class' => 'btn btn-game btn-lg play-clear-btn', 'id' => 'jogar', 'style' => 'width: 100%')) ?>
                        <?php echo $this->Html->link('COMPRAR MAIS BILHETES', 'javascript: void(0);', array('class' => 'btn btn-game btn-lg play-clear-btn', 'id' => 'comprarRaspadinhas', 'style' => 'width: 100%')) ?>
                        <?php echo $this->Html->link('Jogar a próxima raspadinha', 'javascript: void(0);', array('class' => 'btn btn-game btn-lg play-clear-btn', 'id' => 'jogarNovamente', 'style' => 'width: 100%')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
