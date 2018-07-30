<h4>
    Total de registros: <?= $this->Paginator->params()['count']; ?>&nbsp;&nbsp;&nbsp;
    Total: $<?= $total[0]['total'] != null ? $total[0]['total'] : '0.00'; ?>
</h4>
<table id=""
       class="table table-condensed table-hover"
       cellspacing="0"
       width="100%"
       style="margin-bottom:0;">
    <thead>
    <tr>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Criador</th>
        <th>Valor</th>
        <th>Motivo</th>
        <th>Data</th>
        <!--<th>Ações</th>-->
    </tr>
    </thead>
    <tbody>
    <?php $total = 0.00; foreach ($dados as $k => $v) { ?>
        <tr>
            <td>
                <?= $v['Owner']['name']; ?>
            </td>
            <td>
                <?= $v['Owner']['username']; ?>
            </td>
            <td>
                <?= $v['User']['name']. ' '. $v['User']['last_name'] ?>
            </td>
            <td>
                $<?= $v['BalanceWithdraw']['value']; ?>
                <?php $total += $v['BalanceWithdraw']['value']; ?>
            </td>
            <td>
                <?= $v['BalanceWithdraw']['reason']; ?>
            </td>
            <td>
                <?= $this->Time->format($v['BalanceWithdraw']['created'], '%d/%m/%Y %H:%M'); ?>
            </td>
            <!--<td>
                <div class="btn-group">
                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                            <?php /*echo $this->Html->link('<i class="fa fa-cart-plus"></i>&nbsp Histórico', 'javascript: void(0)', array("escape" => false, 'id' => $v['RasLote']['id'], 'class' => 'btnGerarNumeros')) */?>
                        </li>
                    </ul>
                </div>
            </td>-->
        </tr>
    <?php } ?>
    <tr>
        <th colspan="3">
            Total
        </th>
        <td colspan="3">
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