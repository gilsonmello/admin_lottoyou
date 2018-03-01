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

    .ItemHolder1 {
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


    /*    .card-raspadinha{
            width: 340px !important;
        }*/



</style>
<section id="AppTemasRaspadinhas" <?php echo ($modal == 1) ? 'style="padding:0;"' : '' ?>>
    <div class="section-body" <?php echo ($modal == 1) ? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b> Temas Raspadinhas </b>
            </header>
            <div class="tools">
                <button id="cadastrar" type="button" class="btn ink-reaction btn-default-light">
                    <i class="fa fa-plus-square-o"></i>
                    Incluir
                </button>
            </div>
        </div>

        <div class="card card-collapsed" style="min-height:500px;">
            <div id="gridViolencias" style="padding: 12px;">  
                <?php foreach ($temas as $key => $value) { ?>
                    <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4" style="margin-bottom: 50px; max-width:370.333px !important;">
                        <div class="game ItemHolder1 card-raspadinha card" style="padding-top: 8px;">
                            <div class="game-header">
                                <img class="header-image" style=" height: 150px; width: 100%;" src="<?php echo BASE . "/webroot/" . $value['TemasRaspadinha']['img_card_url']; ?>">
                                <div style="width: 100%; text-align: center; padding: 4px; background-color: #2FB9E3;">
                                    <p style="font-size: 14px; color: white;"><b><?php echo $value['TemasRaspadinha']['texto_index']; ?></b></p>
                                </div>
                                <div class="descript">
                                    <h2 class="ng-binding"><?php echo $value['TemasRaspadinha']['nome']; ?></h2>
                                    <button type="button" class="demo btn" style="background-color: #2FB9E3; color: white;" id="<?php echo $value['TemasRaspadinha']['id'] ?>">Visualizar</button>
                                    <button type="button" class="excluirTema btn btn-danger" id="<?php echo $value['TemasRaspadinha']['id'] ?>">Excluir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>