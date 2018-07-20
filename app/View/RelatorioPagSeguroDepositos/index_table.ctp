<h4>Total de registros: <?php echo $this->Paginator->params()['count']; ?></h4>
<table id=""
       class="table table-condensed table-hover"
       cellspacing="0"
       width="100%"
       style="margin-bottom:0;">
    <thead>
    <tr>
        <th>Status</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Valor</th>
        <th>Data</th>
        <!--<th>Ações</th>-->
    </tr>
    </thead>
    <tbody>
    <?php foreach ($dados as $k => $v) { ?>
        <tr>
            <td>
                <?php
                    if($v['BalanceOrder']['status_pagseguro'] == 1) echo "Aguardando pagamento";
                    else if($v['BalanceOrder']['status_pagseguro'] == 2) echo "Em análise";
                    else if($v['BalanceOrder']['status_pagseguro'] == 3) echo "Paga";
                    else if($v['BalanceOrder']['status_pagseguro'] == 4) echo "Disponível";
                    else if($v['BalanceOrder']['status_pagseguro'] == 5) echo "Em disputa";
                    else if($v['BalanceOrder']['status_pagseguro'] == 6) echo "Devolvida";
                    else if($v['BalanceOrder']['status_pagseguro'] == 7) echo "Cancelada";
                    else if($v['BalanceOrder']['status_pagseguro'] == 0) echo "Em progresso";
                ?>
            </td>
            <td>
                <?= $v['User']['name']; ?>
            </td>
            <td>
                <?= $v['User']['username']; ?>
            </td>
            <td>
                $<?= $v['BalanceOrder']['sub_total']; ?>
            </td>
            <td>
                <?= $this->Time->format($v['BalanceOrder']['created'], '%d/%m/%Y %H:%M'); ?>
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
