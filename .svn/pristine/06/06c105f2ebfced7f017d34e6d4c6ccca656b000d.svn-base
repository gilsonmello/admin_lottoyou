<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Detalhes dos ganhadores ')); ?>
<div class="card-body card-collapsed" style="min-height:500px; padding: 0px;">
    <div id="gridLotUserJogos" style="padding: 24px;">
        <h4>Total de registros: <?php echo count($usersJogos); ?></h4>
        <table class="table table-condensed table-hover" 
               cellspacing="0"
               width="100%"
               style="margin-bottom:0;">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Nome</th>
                    <th>Dezenas</th>
                    <th>Data</th>
                    <th>Assertos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usersJogos as $k => $v) { ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $v['users']['username']; ?></td>
                        <td><?php echo $v['users']['name']; ?></td>&nbsp;&nbsp;
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
                        <td><?php echo $v['LotUserJogo']['num_acerto']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin:0;">FECHAR</button>
</div>