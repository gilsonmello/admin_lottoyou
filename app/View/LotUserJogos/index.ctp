<section id="AppLotUserJogos" <?php echo ($modal == 1) ? 'style="padding:0;"' : '' ?>>
    <div class="section-body" <?php echo ($modal == 1) ? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary ">
            <header>
                <i class="md md-apps" style="margin-bottom:0;"></i> Loteria
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b>Jogos</b>
            </header>
        </div>
        <div class="card card-body card-underline" style="padding: 0px;">
            <div class="card-head card-head-sm">
                <ul class="nav nav-tabs pull-right" data-toggle="tabs">
                    <li class="active"><a href="#first">JOGOS DISPONIVEIS</a></li>
                    <li><a href="#second">MEUS JOGOS</a></li>
                </ul>
                <header>LOTTOYOU</header>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="first">
                    <div class="card-body" style="min-height:500px;">
                        <?php
                        if (count($dados) > 0) {
                            foreach ($dados as $key => $value) {

                                $datar = str_replace('/', '-', $value['LotJogo']['data_fim'] . ' ' . $value['LotJogo']['hora_fim']);
                                $data1 = new DateTime(date('d-m-Y H:m:s'));
                                $data2 = new DateTime($datar);
                                $intervalo = $data1->diff($data2);
                                if ($intervalo->d == 0 && $intervalo->h == 0 && $intervalo->i <= 30 || $intervalo->invert == 1) {
                                    continue;
                                }
                                ?>
                                <a href="javascript: void(0);" class="btnLotJogarLoteria" id="<?php echo $value['LotJogo']['id']; ?>">
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="card">
                                            <div class="card-body alert alert-callout alert-info no-margin">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px;">
                                                    <div class="col-xs-3  col-sm-3 col-md-3 col-lg-3" style="padding: 0px;">
                                                        <img src="http://www.lottoland.com/pt/skins/lottoland/images/lotteryLogos/lt-elGordoPrimitiva.x2-bc4cde5fe7329ee5.png" style="background-position: center 0;
                                                             background-repeat: no-repeat;
                                                             background-size: 60px auto;
                                                             height: 60px;
                                                             margin-right: 14px;
                                                             min-width: 60px;
                                                             width: 60px;" alt="">
                                                    </div>
                                                    <div class="col-sm-9" style="text-align: right; padding: 0px;">
                                                        <span class="text-primary" style="font-weight: bold; font-size: large;"><?php echo $value['LotJogo']['sorteio']; ?></span><br>
                                                        <span style="font-size: x-large;"><b><?php echo $this->App->converterValorReal($value['LotJogo']['premio']); ?></b></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;">
                                                    <div class="col-sm-6" style="padding-left: 0px;">
                                                        
                                                    </div>
                                                    <div class="col-sm-6" style="text-align: right; padding-right: 0px;">
                                                        <div class="btn ink-reaction btn-raised btn-success btnJogarLoteria" style="top: 0px;" id="10"><b>Jogar agora</b></div>
                                                    </div>
                                                    
                                                    <div class="col-sm-12" style="text-align: left; padding-left: 0px; margin-top: 10px;">
                                                        <span class="countdown i iHourglass">
                                                            <i class="md md-alarm"></i>
                                                            <?php echo $intervalo->days > 0 ? $intervalo->days . ' Dias, ' . $intervalo->h . 'H e ' . $intervalo->m . "M" : $intervalo->h . 'H e ' . $intervalo->m . "M"; ?>
                                                        </span>
                                                    </div>

                                                </div>
                                                <div class="stick-bottom-left-right">
                                                    <div class="progress progress-hairline no-margin">
                                                        <div class="progress-bar progress-bar-success" style="width:<?php echo $this->App->resPorcentagem(30, 20); ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="tab-pane" id="second">						
                    <div class="card-body card-collapsed" style="min-height:500px; padding: 0px;">
                        <div id="gridLotUserJogos" style="padding: 24px;">
                            <h4>Total de registros: <?php echo count($userJogos); ?></h4>
                            <table class="table table-condensed table-hover" 
                                   cellspacing="0"
                                   width="100%"
                                   style="margin-bottom:0;">
                                <thead>
                                    <tr>
                                        <th>Concurso</th>
                                        <th>Sorteio</th>
                                        <th>Dezenas</th>
                                        <th>Data</th>
                                        <th style="width:50px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($userJogos as $k => $v) { ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $v['LotJogo']['concurso']; ?></td>
                                            <td><?php echo $v['LotJogo']['sorteio']; ?></td>&nbsp;&nbsp;
                                            <td><?php
                                                $numb = explode(' + ', $v['LotUserJogo']['numeros']);
                                                $numero = explode(' - ', $numb[0]);
                                                unset($numb[0]);
                                                $numeros = array_merge($numero, $numb);
                                                $btnNum = '';
                                                foreach ($numeros as $k => $x) {
                                                    $btnNum .= '<button type="button" class="btn btn-xs ink-reaction btn-floating-action">' . $x . '</button>&nbsp;&nbsp;';
                                                }
                                                echo $btnNum;
                                                ?></td>
                                            <td><?php echo $v['LotUserJogo']['modified']; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                        <?php if ($v['LotUserJogo']['num_acerto']>= 0) { ?>
                                                            <li><?php echo $this->Html->link('<i class="md md-replay"></i>&nbsp Detalhar', 'javascript: void(0)', array("escape" => false, 'id' => $v['LotUserJogo']['id'], 'class' => 'btnDetalharLotUserJogo')) ?></li>
                                                        <?php } ?>
                                                <!--<li><?php echo $this->Html->link('<i class="md md-create"></i>&nbsp Atualizar', 'javascript: void(0)', array("escape" => false, 'id' => $v['LotUserJogo']['id'], 'class' => 'btnAtualizarLotUserJogo')) ?></li>-->
                                                        <li><?php echo $this->Html->link('<i class="md md-delete"></i>&nbsp Excluir', 'javascript: void(0)', array("escape" => false, 'id' => $v['LotUserJogo']['id'], 'class' => 'btnDeletarLotUserJogo')) ?></li>
                                                        <li style="background: #F1F1F1; font-size: 9px; text-align: center;">Atualizado em: <?php echo @$v['LotUserJogo']['modified'] ?></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end .card -->

    </div>
</section>
