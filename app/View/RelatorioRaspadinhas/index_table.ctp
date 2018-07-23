<h4>
    Total de registros: <?= $this->Paginator->params()['count']; ?>
</h4>
<table id=""
       class="table table-condensed table-hover"
       cellspacing="0"
       width="100%"
       style="margin-bottom:0;">
    <thead>
    <tr>
        <th>Tema</th>
        <th>Lote</th>
        <th>Total</th>
        <th>Premiadas restantes</th>
        <th>Não premiadas restantes</th>
        <th>Restantes</th>
        <th>Total premiado</th>
        <th>Utilizadas</th>
    </tr>
    </thead>
    <tbody>
    <?php $total = 0.00; foreach ($dados as $k => $v) { ?>
        <tr>
            <td>
                <?= $v['TemasRaspadinha']['nome'] ?>
            </td>
            <td>
                <?= $v['RasLote']['nome'] ?>
            </td>
            <td>
                <?= $model->getTotalRaspadinhas($v['RasLote']['id']) ?>
            </td>
            <td>
                <?= $model->getRaspadinhasPremiadasRestantes($v['RasLote']['id']) ?>
            </td>
            <td>
                <?= $model->getNaoRaspadinhasPremiadasRestantes($v['RasLote']['id']) ?>
            </td>
            <td>
                <?= $model->getRaspadinhasRestantes($v['RasLote']['id']); ?>
            </td>
            <td>
                <?php
                $premiado = $model->getTotalPremiado($v['RasLote']['id']);
                $total += $premiado;
                ?>
                $<?= number_format($premiado, 2, '.', '') ?>
            </td>
            <td>
                <?= $model->getRaspadinhasUtilizadas($v['RasLote']['id']); ?>
            </td>
            <!--<td>
                <div class="btn-group">
                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                            <?php /*echo $this->Html->link('<i class="fa fa-cart-plus"></i>&nbsp Gerar Prêmios', 'javascript: void(0)', array("escape" => false, 'id' => $v['RasLote']['id'], 'class' => 'btnGerarNumeros')) */?>
                        </li>
                    </ul>
                </div>
            </td>-->
        </tr>
    <?php } ?>
    <tr>
        <th colspan="6">
            Total
        </th>
        <td colspan="2">
            $<?= number_format($total, 2, '.', '') ?>
        </td>
    </tr>
    </tbody>
</table>
<div class="">
    <ul class="pagination">
        <?php
        $this->Paginator->options(array('url' =>  array('?' => $query)));
        echo $this->Paginator->prev('«', array('tag' => 'li'), null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
        echo $this->Paginator->numbers(['separator' => '','currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1]);
        echo $this->Paginator->next(__('»'), array('tag' => 'li', 'currentClass' => 'disabled'), null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
        ?>
    </ul>
</div>