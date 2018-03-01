<?php echo $this->Form->create('LotUserJogo', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->Form->hidden('user_id', array('value' => $this->Session->read('Auth.User.id'))); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR NOVO jogo')); ?>
<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <?php echo $this->Form->input('lot_jogo_id', array('label' => 'Tipo de jogo', 'class' => 'form-control chosen slqTipo', 'options' => $tiposJogos, 'empty' => 'Selecione um Jogo')); ?>
            </div>
        </div>
    </div>
    <div class="row" id="gridTabelaLotUserJogo">
        <?php for ($i = 1; $i < 7; $i++) { ?>
            <div class="col-xs-2">
                <div class="card">
                    <div class="card-head card-head-xs">
                        <header style="padding: 11px;">Volante <?php echo '0' . $i; ?></header>
                        <div class="tools" style="padding-right: 0px;">
                            <div class="btn-group btn-group-xs">
                                <a style="margin-left: 2px; margin-right: 2px;" class="btn btn-icon-toggle btnRandomDezenas" volante="<?php echo $i; ?>"><i class="glyphicon glyphicon-random" title="Númeoros Aleatórios"></i></a>
                                <a style="margin-left: 2px; margin-right: 2px;" class="btn btn-icon-toggle btnClearDezenas" volante="<?php echo $i; ?>"><i class="glyphicon glyphicon-remove" title="Limpar números"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 2px; margin-left: 9px; margin-right: 9px; background-color: #e5e6e6; text-align: center;">
                        <?php
                        $sal = 0;
                        $num = $i . '000';
                        $let = '';
                        switch ($i) {
                            case 1:
                                $let = 'D';
                                break;
                            case 2:
                                $let = 'E';
                                break;
                            case 3:
                                $let = 'F';
                                break;
                            case 4:
                                $let = 'G';
                                break;
                            case 5:
                                $let = 'H';
                                break;
                            case 6:
                                $let = 'I';
                                break;
                        }
                        for ($index = 0; $index < $dados['LotCategoria']['dezena']; $index++) {
                            if ($sal == $index || $sal == 0) {
                                $sal = $sal + 5;
                                echo'<div class="btn-group" style="width: 100%">';
                            }
                            $x = (($index + 1) < 10) ? ($index + 1 + $num) : ($index + 1 + $num);
                            if (($x) == ($num + 100)) {
                                echo '<button style="margin: 2px;" type="button" pass="00" id="' . $i . '000" class="btnLotJogosPedras' . $i . ' btn btn-xs ink-reaction btn-floating-action btn-default-dark">00</button>';
                                echo $this->Form->hidden($let . '.' . $let . '00', array('id' => $let . '00'));
                            } else {
                                echo '<button style="margin: 2px;" type="button" pass="' . ($x - $num) . '" id="' . $x . '" class="btnLotJogosPedras' . $i . ' btn btn-xs ink-reaction btn-floating-action btn-default-dark">' . ($x - $num) . '</button>';
                                echo $this->Form->hidden($let . '.' . $let . ($x - $num), array('id' => $let . ($x - $num)));
                            }
                            if ($sal === ($index + 1) && $index !== 0) {
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <em class="text-caption" style="padding-left: 9px; margin-bottom: 10px; margin-top: 5px; text-align: center;">
                        <?php
                        echo 'Dezenas restantes - ' . $this->Form->input('qtdNumeros' . $i, array(
                            'id' => 'qtdNumeros' . $i, 'disabled' => true, 'label' => false, 'tns' => $dados['LotCategoria']['dezena'], 'qtdNumeros' . $i => $dados['LotCategoria']['dezena_sel'], 'value' => $dados['LotCategoria']['dezena_sel'], 'style' => 'width: 30px; height: 18px; text-align: center;'));
                        ?>
                    </em>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="modal-footer" style="padding:14px 22px;">
    <button id="btnSalvarLotUserJogo"class="btn btn-primary btn-loading-state btnSalvarLotUserJogo disabled" type="button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando...">SALVAR</button>
    <button class="btn btn-default pull-left" type="button" data-dismiss="modal" style="margin:0;">FECHAR</button>
</div>

<?php echo $this->Form->end(); ?>

