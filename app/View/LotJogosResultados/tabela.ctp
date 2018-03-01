<div class="col-sm-1"></div>
<div class="col-sm-10">
    <div class="card card-body card-bordered">
        <table class="table no-margin">
            <thead>
                <tr>
                    <th colspan="5"><center><h3><?php echo $dados['LotJogo']['sorteio']; ?></h3></center></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sal = 0;
            for ($index = 0; $index < $dados['LotCategoria']['dezena']; $index++) {
                if ($sal === $index || $sal === 0) {
                    $sal += 5;
                    echo '<tr>';
                }
                $x = (($index + 1) < 10) ? ($index + 1 + 1000) : ($index + 1 + 1000);
                if (($x) == 1100) {
                    echo '<td><button type="button" pass="00" id="1000" class="btnLotJogosPedras btn ink-reaction btn-floating-action btn-default-light">00</button></td>';
                    echo $this->Form->hidden('D00', array('id' => 'D00'));
                } else {
                    echo '<td><button type="button" pass="' . ($x - 1000) . '" id="' . $x . '" class="btnLotJogosPedras btn ink-reaction btn-floating-action btn-default-light">' . ($x - 1000) . '</button></td>';
                    echo $this->Form->hidden('D' . ($x - 1000), array('id' => 'D' . ($x - 1000)));
                }
                if ($sal === $index && $index !== 0) {
                    echo '</tr>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php echo $this->Form->hidden('qtdNumeros', array('id' => 'qtdNumeros', 'qtdNumeros' => $dados['LotCategoria']['dezena_sel'])); ?>
</div>
<div class="col-sm-1"></div>