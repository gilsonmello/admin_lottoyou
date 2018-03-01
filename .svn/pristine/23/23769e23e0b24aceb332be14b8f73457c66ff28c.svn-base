<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Detalhes dos ganhadores ')); ?>
<div class="card-body card-collapsed" style="min-height:400px; padding:24px;">
    <div class="card" style="">


        <div class="card-body">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6 btn-group">
                    <div class="card-head cheaderbar-right">
                        <header class="headerbar-left style-success">Parabéns pelo jogo</header>
                    </div>
                    <?php
                    $numb = explode(' + ', $dados['LotUserJogo']['numeros']);
                    $numero = explode(' - ', $numb[0]);
                    unset($numb[0]);
                    $numeros = array_merge($numero, $numb);
                    $btnNum = '';

                    foreach ($numeros as $k => $x) {
                        $btnNum .= '<button type="button" class="btn ink-reaction btn-floating-action" style="margin: 4px;"><font>' . $x . '</font></button>&nbsp;&nbsp;';
                    }
                    echo $btnNum;
                    ?>
                </div>
                <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"></div>
                <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4">
                    <div class="card-head cheaderbar-right">
                        <header class="headerbar-right style-info">Assertos </header>
                    </div>
                    <div style="text-align: right; padding-left: 3%">
                        <button class="btn ink-reaction btn-floating-action " type="button" style="background-color: #ffc000; border-color: #fffb00; color: #ffffff; width: 90px; height: 90px;">
                            <font style="font-size: 50px;">
                            <?php echo $dados['LotUserJogo']['num_acerto'] + $dados['LotUserJogo']['num_acerto_extra']; ?>
                            </font>
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin:0;">FECHAR</button>
</div>