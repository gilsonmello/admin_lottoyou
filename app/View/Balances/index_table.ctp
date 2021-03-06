<h4>
    Total de registros: <?= $this->Paginator->params()['count']; ?>&nbsp;&nbsp;&nbsp;
    Saldo total: $<?= $balanceTotal[0]['balance_total']; ?>
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
        <th>Saldo</th>
        <th>Data</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php $total = 0; foreach ($dados as $k => $v) { ?>
        <tr>
            <td>
                <?= $v['Owner']['name'].' '.$v['Owner']['last_name']; ?>
            </td>
            <td>
                <?= $v['Owner']['username'] ?>
            </td>
            <td>
                <?= '$'.$v['Balance']['value'] ?>
                <?php $total += $v['Balance']['value']; ?>
            </td>
            <td>
                <?= $this->Time->format($v['Balance']['modified'], '%d/%m/%Y %H:%M'); ?>
            </td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                            <?php echo $this->Html->link('<i class="md md-add"></i>&nbsp Inserir saldo', 'javascript: void(0)', array("escape" => false, 'id' => $v['Balance']['id'], 'class' => 'btnInsert')) ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link('<i class="md md-remove"></i>&nbsp Retirar saldo', 'javascript: void(0)', array("escape" => false, 'id' => $v['Balance']['id'], 'class' => 'btnWithdraw')) ?>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <th colspan="2">
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