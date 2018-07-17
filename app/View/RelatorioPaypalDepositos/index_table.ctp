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
                    if($v['BalanceOrder']['status_paypal'] == 'Canceled_Reversal') echo "Reversão cancelada";
                    else if($v['BalanceOrder']['status_paypal'] == 'Completed') echo "Concluído";
                    else if($v['BalanceOrder']['status_paypal'] == 'Created') echo "Criado";
                    else if($v['BalanceOrder']['status_paypal'] == 'Denied') echo "Negado";
                    else if($v['BalanceOrder']['status_paypal'] == 'Expired') echo "Expirado";
                    else if($v['BalanceOrder']['status_paypal'] == 'Failed') echo "Falhou";
                    else if($v['BalanceOrder']['status_paypal'] == 'Pending') echo "Pendente";
                    else if($v['BalanceOrder']['status_paypal'] == 'Refunded') echo "Reembolso";
                    else if($v['BalanceOrder']['status_paypal'] == 'Reversed') echo "Reversão";
                    else if($v['BalanceOrder']['status_paypal'] == 'Processed') echo "Pagamento aceito";
                    else if($v['BalanceOrder']['status_paypal'] == 'Voided') echo "Anulado";
                    else if($v['BalanceOrder']['status_paypal'] == 'In progress') echo "Pendente de pagamento";
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
        $this->Paginator->options(array('url' =>  $query));
        echo $this->Paginator->prev('«', array('tag' => 'li'), null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
        echo $this->Paginator->numbers(['separator' => '','currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1]);
        echo $this->Paginator->next(__('»'), array('tag' => 'li', 'currentClass' => 'disabled'), null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
        ?>
    </ul>
</div>
