<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Detalhes das apostas ')); ?>
<div class="card-body card-collapsed" style="min-height:500px; padding: 0px;">
    <div id="gridLotUserJogos" style="padding: 24px;">
        <h4>Total de registros: <?php echo count($apostas); ?></h4>
        <table class="table table-condensed table-hover" 
               cellspacing="0"
               width="100%"
               style="margin-bottom:0;">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Nome</th>
                    <th>Dezenas</th>
                    <th>Dezenas Extras</th>
                    <th>Acertos</th>
                    <th>Acertos Extras</th>
                    <th>Total de Acertos</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($apostas as $k => $v) { ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $v['User']['username']; ?></td>
                        <td><?php echo $v['User']['name']; ?></td>&nbsp;&nbsp;
                        <td>
                            <?php
                                $btnNum = '';
                                foreach ($v['LotUserNumero'] as $k => $x) {
                                    $btnNum .= '<button type="button" class="btn btn-xs ink-reaction btn-floating-action">' . $x['numero'] . '</button>&nbsp;&nbsp;';
                                }
                                foreach ($v['LotUserNumeroExtra'] as $k => $x) {
                                    $btnNum .= '<button type="button" class="btn btn-xs ink-reaction btn-floating-action">' . $x['numero'] . '</button>&nbsp;&nbsp;';
                                }
                                echo $btnNum;
                            ?>
                        </td>
                        <td>
                            <?php
                                $btnNum = '';
                                foreach ($v['LotUserNumeroExtra'] as $k => $x) {
                                    $btnNum .= '<button type="button" class="btn btn-xs ink-reaction btn-floating-action">' . $x['numero'] . '</button>&nbsp;&nbsp;';
                                }
                                echo $btnNum == '' ? 'Não há dezenas extras' : $btnNum;
                            ?>
                        </td>
                        <td><?= $v['LotUserJogo']['num_acerto']; ?></td>
                        <td><?= $v['LotUserJogo']['num_acerto_extra']; ?></td>
                        <td><?= $v['LotUserJogo']['num_acerto'] + $v['LotUserJogo']['num_acerto_extra']; ?></td>
                        <td><?= $v['LotUserJogo']['modified']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin:0;">FECHAR</button>
</div>