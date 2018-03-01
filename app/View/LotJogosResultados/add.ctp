<?php echo $this->Form->create('LotJogosResultado', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->Form->hidden('user_id', array('value' => $this->Session->read('Auth.User.id'))); ?>
<?php echo $this->Form->hidden('lot_jogo_id', array('value' => $lotJogoId)); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR NOVO jogo')); ?>
<style>
    .btn-default-darking {
        background-color: #33426F;
        border-color: #000000;
        color: #ffffff;
    }
</style>
<div class="card-body">
    <div class="row ">
        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('sorteio', array('label' => 'Sorteio', 'type' => 'text', 'class' => 'form-control', 'disabled' => 'disabled', 'value' => $dados['LotJogo']['sorteio']));
                ?>
            </div>
        </div>
        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2">
            <div class="form-group">
                <?php
                echo $this->Form->input('concurso', array('label' => 'Concurso', 'type' => 'text', 'class' => 'form-control', 'disabled' => 'disabled', 'value' => $dados['LotJogo']['concurso']));
                ?>
            </div>
        </div>
        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('data_limite', array('label' => 'Data limite', 'type' => 'text', 'class' => 'form-control', 'disabled' => 'disabled', 'value' => $dados['LotJogo']['data_fim']));
                ?>
            </div>
        </div>
        <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
            <div class="form-group">
                <?php echo $this->Form->input('concurso_data', array('label' => 'Data do resultado', 'class' => 'form-control date')); ?>
            </div>
        </div>
    </div>
    <div class="row" id="gridTabelaLotJogosResultados" style="margin-right: 34px; margin-left: 34px;">
        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
            <div class="card card-body card-bordered" style="text-align: center;align-items: center;">
                <div class="card-head card-head-xs" style="text-align: center;">
                    <header><h3><?php echo $dados['LotJogo']['sorteio']; ?></h3></header>
                </div>
                <?php if (empty($dezenas)) { ?>
                    <div class="card-body btn-group btn-group-sm btn-group-lg btn-group-xs" style="padding: 2px; margin-left: 0px; margin-right: 0px; background-color: #e5e6e6; text-align: center;">
                        <?php
                        $sal = 0;
                        $num = 1000;
                        $let = 'D';
                        $let2 = 'd';
                        $i = 1;
                        for ($index = 0; $index < $dados['LotCategoria']['dezena']; $index++) {
                            if ($sal == $index || $sal == 0) {
                                $sal = $sal + 5;
//                                echo'<div class="btn-group" style="width: 100%">';
                            }
                            $x = (($index + 1) < 10) ? ($index + 1 + $num) : ($index + 1 + $num);
                            if (($x) == ($num + 100)) {
                                echo '<button style="margin: 4px;" type="button" pass="00" id="' . $i . '000" class="btnLotJogosPedras' . $i . ' btn ink-reaction btn-floating-action btn-default-light"><font style="font-size: 19px">00</font></button>';
                                echo $this->Form->hidden($let . '.' . $let . '00', array('id' => $let . '00'));
                            } else {
                                echo '<button style="margin: 4px;" type="button" pass="' . ($x - $num) . '" id="' . $x . '" class="btnLotJogosPedras' . $i . ' btn ink-reaction btn-floating-action btn-default-light"><font style="font-size: 19px ;text-align: center;">' . ($x - $num) . '</font></button>';
                                echo $this->Form->hidden($let . '.' . $let . ($x - $num), array('id' => $let . ($x - $num)));
                            }
                            if ($sal === ($index + 1) && $index !== 0) {
//                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <div class="card-body btn-group btn-group-sm btn-group-lg btn-group-xs" style="padding: 2px; margin-left: 0px; margin-right: 0px; background-color: #e5e6e6; text-align: center;">
                        <?php
                        if (!empty($dados['LotCategoria']['dezena_extra'])) {
                            for ($index = 0; $index < $dados['LotCategoria']['dezena_extra']; $index++) {
                                if ($sal == $index || $sal == 0) {
                                    $sal = $sal + 5;
//                                echo'<div class="btn-group" style="width: 100%">';
                                }
                                $x = (($index + 1) < 10) ? ($index + 1 + $num) : ($index + 1 + $num);
                                if (($x) == ($num + 100)) {
                                    echo '<button style="margin: 4px; border-color: #000; background-color: #e5e6e6;" type="button" pass="00" id="' . $let2 . $i . '000" class="btnLotJogosPedras' . $let2 . $i . ' btn ink-reaction btn-floating-action btn-default-darking"><font style="font-size: 19px">00</font></button>';
                                    echo $this->Form->hidden($let2 . '.' . $let2 . '00', array('id' => $let2 . '00'));
                                } else {
                                    echo '<button style="margin: 4px; border-color: #000;" type="button" pass="' . ($x - $num) . '" id="' . $let2 . $x . '" class="btnLotJogosPedras' . $let2 . $i . ' btn ink-reaction btn-floating-action btn-default-darking"><font style="font-size: 19px ;text-align: center;">' . ($x - $num) . '</font></button>';
                                    echo $this->Form->hidden($let2 . '.' . $let2 . ($x - $num), array('id' => $let2 . ($x - $num)));
                                }
                                if ($sal === ($index + 1) && $index !== 0) {
//                                echo '</div>';
                                }
                            }
                        }
                        ?>
                    </div>
                    <em class="text-caption" style="padding-left: 9px; margin-bottom: 10px; margin-top: 5px; text-align: center;">
                        <?php
                        echo 'Dezenas restantes - ' . $this->Form->input('qtdNumeros1', array(
                            'id' => 'qtdNumeros1', 'disabled' => true, 'label' => false, 'tns' => $dados['LotCategoria']['dezena'], 'qtdNumeros1' => $dados['LotCategoria']['dezena_sel'], 'value' => $dados['LotCategoria']['dezena_sel'], 'style' => 'width: 30px; height: 18px; text-align: center;'));
                        if (!empty($dados['LotCategoria']['dezena_extra'])) {
                            echo $this->Form->input('qtdNumeros' . $let2 . $i, array(
                                'id' => 'qtdNumeros' . $let2 . $i, 'disabled' => true, 'label' => false, 'tns' => $dados['LotCategoria']['dezena_extra'], 'qtdNumeros' . $let2 . $i => $dados['LotCategoria']['dezena_extra_sel'], 'value' => $dados['LotCategoria']['dezena_extra_sel'], 'style' => 'width: 29px; height: 18px; text-align: center;'));
                        }
                        ?>
                    </em>
                <?php } else { ?>
                    <div class="card-body btn-group btn-group-sm btn-group-lg btn-group-xs" style="padding: 2px; margin-left: 0px; margin-right: 0px; background-color: #e5e6e6; text-align: center;">
                        <?php
                        $sal = 0;
                        $num = 0;
                        $let = 'D';
                        $let2 = 'd';
                        $i = 1;
                        for ($index = 1; $index < ($dados['LotCategoria']['dezena']+1); $index++) {
                            if ($index == 100) {
                            ?>
                                <button style="margin: 4px;" type="button" id="00" class="<?php echo empty($dezenas[$index]) ? 'btn-default-light' : 'btn-success'; ?> btn ink-reaction btn-floating-action"><font style="font-size: 19px">00</font></button>
                            <?php } else { ?>
                                <button style="margin: 4px;" type="button"class="<?php echo empty($dezenas[$index]) ? 'btn-default-light' : 'btn-success'; ?> btn ink-reaction btn-floating-action"><font style="font-size: 19px ;text-align: center;"><?php echo $index ?></font></button>
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <div class="card-body btn-group btn-group-sm btn-group-lg btn-group-xs" style="padding: 2px; margin-left: 0px; margin-right: 0px; background-color: #e5e6e6; text-align: center;">
                        <?php
                        if (!empty($dados['LotCategoria']['dezena_extra'])) {
                            fb($dezenas2, 'dezenas2');
                            for ($index = 0; $index < $dados['LotCategoria']['dezena_extra']; $index++) {

                                $x = (($index + 1) < 10) ? ($index + 1 + $num) : ($index + 1 + $num);
                                if (($x) == ($num + 100)) {
                                    ?>
                                    <button style="margin: 4px;" type="button" id="<?php echo 'd00' ?>" class="<?php echo empty($dezenas2[$index]) ? 'btn-default-darking' : 'btn-success'; ?> btn ink-reaction btn-floating-action"><font style="font-size: 19px">00</font></button>
                                <?php } else { ?>
                                    <button style="margin: 4px;" type="button"  id="<?php echo 'd'. $index?>" class="<?php echo empty($dezenas2[$index]) ? 'btn-default-darking' : 'btn-success'; ?> btn ink-reaction btn-floating-action"><font style="font-size: 19px ;text-align: center;"><?php echo $index ?></font></button>
                                <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <em class="text-caption" style="padding-left: 9px; margin-bottom: 10px; margin-top: 5px; text-align: center;">
                        <?php
                        echo 'Dezenas restantes - ' . $this->Form->input('qtdNumeros1', array(
                            'id' => 'qtdNumeros1', 'disabled' => true, 'label' => false, 'tns' => $dados['LotCategoria']['dezena'], 'qtdNumeros1' => $dados['LotCategoria']['dezena_sel'], 'value' => 0, 'style' => 'width: 30px; height: 18px; text-align: center;'));
                        if (!empty($dados['LotCategoria']['dezena_extra'])) {
                            echo $this->Form->input('qtdNumeros' . $let2 . $i, array(
                                'id' => 'qtdNumeros' . $let2 . $i, 'disabled' => true, 'label' => false, 'tns' => $dados['LotCategoria']['dezena_extra'], 'qtdNumeros' . $let2 . $i => $dados['LotCategoria']['dezena_extra_sel'], 'value' => 0, 'style' => 'width: 29px; height: 18px; text-align: center;'));
                        }
                        ?>
                    </em>
                <?php } ?>
            </div>
            <?php //  echo $this->Form->hidden('qtdNumeros', array('id' => 'qtdNumeros', 'qtdNumeros' => $dados['LotCategoria']['dezena_sel']));   ?>
        </div>
    </div>
</div>
<div class="modal-footer" style="padding:14px 22px;">
    <button class="btn btn-primary btn-loading-state btnSalvarLotJogosResultados" type="button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando...">SALVAR</button>
    <button class="btn btn-default pull-left" type="button" data-dismiss="modal" style="margin:0;">FECHAR</button>
</div>

<?php echo $this->Form->end(); ?>

