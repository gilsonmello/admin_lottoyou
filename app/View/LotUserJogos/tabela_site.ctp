<?php echo $this->Form->create('LotUserJogo', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->Form->hidden('user_id', array('value' => $this->Session->read('Auth.User.id'))); ?>
<?php echo $this->Form->hidden('lot_jogo_id', array('value' => $dados['LotJogo']['id'])); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR NOVO jogo')); ?>
<style>
    .btn-default-darks {
        background-color: #ffffff;
        border-color: #00003f;
        color: #00003f;
    }
    .btn-default-darking {
        background-color: #4CAF50;
        border-color: #4CAF50;
        color: #ffffff;
    }
    
    .btn-successu {
        background-color: #000053;
        border-color: #000000;
        color: #ffffff;
    }
    
</style>
<div class="card-body">
    <div class="row" id="gridTabelaLotUserJogo">
        <?php for ($i = 1; $i < 7; $i++) { ?>
            <div class="col-xs-2 col-md-2 col-sm-2 col-lg-2 " style="min-width: 210px;">
                <div class="card" >
                    <div class="card-head card-head-xs">
                        <header style="padding: 11px;">Volante <?php echo '0' . $i; ?></header>
                        <div class="tools" style="padding-right: 0px;">
                            <div class="btn-group btn-group-xs">
                                <a style="margin-left: 2px; margin-right: 2px;" class="btn btn-icon-toggle btnRandomDezenas" volante="<?php echo $i; ?>"><i class="glyphicon glyphicon-random" title="Númeoros Aleatórios"></i></a>
                                <a style="margin-left: 2px; margin-right: 2px;" class="btn btn-icon-toggle btnClearDezenas" volante="<?php echo $i; ?>"><i class="glyphicon glyphicon-remove" title="Limpar números"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 2px; margin-left: 9px; margin-right: 9px; background-color: #FCF914; text-align: center;">
                        <?php
                        $sal = 0;
                        $num = $i . '000';
                        $let = $let2 = '';

                        switch ($i) {
                            case 1:
                                $let = 'D';
                                $let2 = 'd';
                                break;
                            case 2:
                                $let = 'E';
                                $let2 = 'e';
                                break;
                            case 3:
                                $let = 'F';
                                $let2 = 'f';
                                break;
                            case 4:
                                $let = 'G';
                                $let2 = 'g';
                                break;
                            case 5:
                                $let = 'H';
                                $let2 = 'h';
                                break;
                            case 6:
                                $let = 'I';
                                $let2 = 'i';
                                break;
                        }
                        for ($index = 0; $index < $dados['LotCategoria']['dezena']; $index++) {
                            if ($sal == $index || $sal == 0) {
                                $sal = $sal + 5;
//                                echo'<div class="btn-group" style="width: 100%">';
                            }
                            $x = (($index + 1) < 10) ? ($index + 1 + $num) : ($index + 1 + $num);
                            if (($x) == ($num + 100)) {
                                echo '<button style="margin: 2px;" type="button" pass="00" id="' . $x . '000" class="btnLotJogosPedras' . $i . ' btn btn-xs ink-reaction btn-floating-action btn-default-darks">00</button>';
                                echo $this->Form->hidden($let . '.' . $let . '00', array('id' => $let . '00'));
                            } else {
                                echo '<button style="margin: 2px;" type="button" pass="' . ($x - $num) . '" id="' . $x . '" class="btnLotJogosPedras' . $i . ' btn btn-xs ink-reaction btn-floating-action btn-default-darks">' . ($x - $num) . '</button>';
                                echo $this->Form->hidden($let . '.' . $let . ($x - $num), array('id' => $let . ($x - $num)));
                            }
                            if ($sal === ($index + 1) && $index !== 0) {
//                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <div class="card-body" style="padding: 2px; margin-left: 9px; margin-right: 9px; background-color: #FCF914; text-align: center;">
                        <?php
                        if (!empty($dados['LotCategoria']['dezena_extra'])) {
                            for ($index = 0; $index < $dados['LotCategoria']['dezena_extra']; $index++) {
                                if ($sal == $index || $sal == 0) {
                                    $sal = $sal + 5;
//                                echo'<div class="btn-group" style="width: 100%">';
                                }
                                $x = (($index + 1) < 10) ? ($index + 1 + $num) : ($index + 1 + $num);
                                if (($x) == ($num + 100)) {
                                    echo '<button style="margin: 2px; border-color: #000; background-color: #e5e6e6;" type="button" pass="00" id="'.$let2 . $i . '000" class="btnLotJogosPedras' . $let2 . $i . ' btn btn-xs ink-reaction btn-floating-action btn-default-darking">00</button>';
                                    echo $this->Form->hidden($let2 . '.' . $let2 . '00', array('id' => $let2 . '00'));
                                } else {
                                    echo '<button style="margin: 2px; border-color: #000;" type="button" pass="' . ($x - $num) . '" id="' . $let2 . $x . '" class="btnLotJogosPedras' . $let2 . $i . ' btn btn-xs ink-reaction btn-floating-action btn-default-darking">' . ($x - $num) . '</button>';
                                    echo $this->Form->hidden($let2 . '.' . $let2 . ($x - $num), array('id' => $let2 . ($x - $num)));
                                }
                                if ($sal === ($index + 1) && $index !== 0) {
//                                echo '</div>';
                                }
                            }
                        }
                        ?>
                    </div>
                    <em class="text-caption" style="padding-left: 0px; margin-bottom: 10px; margin-top: 5px; text-align: center;">
                        <?php
                        echo 'Dezenas restantes - ' . $this->Form->input('qtdNumeros' . $i, array(
                            'id' => 'qtdNumeros' . $i, 'disabled' => true, 'label' => false,'qtdNumerosMin'=>$dados['LotCategoria']['dezena_sel_min'],'qtdNumeros'.$i=>$dados['LotCategoria']['dezena_sel'], 'tns' => $dados['LotCategoria']['dezena'], 'qtdNumeros' . $i => $dados['LotCategoria']['dezena_sel'], 'value' => $dados['LotCategoria']['dezena_sel'], 'style' => 'width: 29px; height: 18px; text-align: center;'));
                        
                        if (!empty($dados['LotCategoria']['dezena_extra'])) {
                            echo $this->Form->input('qtdNumeros' . $let2 . $i, array(
                                'id' => 'qtdNumeros' . $let2 . $i, 'disabled' => true, 'label' => false, 'tns' => $dados['LotCategoria']['dezena_extra'], 'qtdNumeros' . $let2 . $i => $dados['LotCategoria']['dezena_extra_sel'], 'value' => $dados['LotCategoria']['dezena_extra_sel'], 'style' => 'width: 29px; height: 18px; text-align: center;'));
                        }
                        ?>
                    </em>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="modal-footer" style="padding:14px 22px;">
    <button id="btnSalvarLotUserJogo"class="btn btn-primary btn-loading-state btnSalvarLotUserJogo" type="button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando...">SALVAR</button>
    <button class="btn btn-default pull-left" type="button" data-dismiss="modal" style="margin:0;">FECHAR</button>
</div>

<?php echo $this->Form->end(); ?>

