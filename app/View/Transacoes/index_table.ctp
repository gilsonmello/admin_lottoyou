<h4>
    Total de registros: <?= $this->Paginator->params()['count']; ?>&nbsp;&nbsp;&nbsp;
    Total entrada: $<?= $totalEntrada[0]['total_entrada']; ?>&nbsp;&nbsp;&nbsp;
    Total saída: $<?= $totalSaida[0]['total_saida']; ?>
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
        <th>Data</th>
        <th>Modalidade</th>
        <!--<th>Descrição</th>-->
        <th>Tipo</th>
        <th>Quantia</th>
        <!--<th>Ações</th>-->
    </tr>
    </thead>
    <tbody>
    <?php $totalEntrada = 0.00; $totalSaida = 0.00; foreach ($dados as $k => $v) { ?>
        <?php if($v['HistoricBalance']['type'] == 1) $totalEntrada += $v['HistoricBalance']['amount'] ?>
        <?php if($v['HistoricBalance']['type'] == 0) $totalSaida += $v['HistoricBalance']['amount'] * -1 ?>
        <tr>
            <td>
                <?= $v['Owner']['name'] . ' '. $v['Owner']['last_name'] ?>
            </td>
            <td>
                <?= $v['Owner']['username'] ?>
            </td>
            <td>
                <?= $this->Time->format($v['HistoricBalance']['created'], '%d/%m/%Y %H:%M'); ?>
            </td>
            <td>
                <?php $modalidade = ''; ?>
                <?php
                if(isset($v['LotUserJogo']) && $v['LotUserJogo']['id'] != null) $modalidade = 'Loteria';
                else if(isset($v['SocAposta']) && $v['SocAposta']['id'] != null) $modalidade = 'Soccer Expert';
                else if(isset($v['Raspadinha']) && $v['Raspadinha']['id'] != null) $modalidade = 'Raspadinhas';
                else if(isset($v['PedidoPaypal']) && $v['PedidoPaypal']['id'] != null) $modalidade = 'Depósito';
                else if(isset($v['PedidoPagseguro']) && $v['PedidoPagseguro']['id'] != null) $modalidade = 'Depósito';
                else if(isset($v['Item']) && $v['Item']['id'] != null) $modalidade = 'Compra';
                else if(isset($v['BalanceInsert']) && $v['BalanceInsert']['id'] != null) $modalidade = 'Depósito';
                else if(isset($v['RetiradaAgente']) && $v['RetiradaAgente']['id'] != null) $modalidade = 'Retirada';
                else $modalidade = 'Indefinido';
                ?>


                <?= $modalidade ?>
            </td>
            <!--<td>

            </td>-->
            <td>
                <?php $tipo = ''; ?>
                <?php
                if($v['HistoricBalance']['description'] == 'buy') $tipo = 'Compra';
                else if($v['HistoricBalance']['description'] == 'agent withdrawal') $tipo = 'Ag. Pagamento';
                else if($v['HistoricBalance']['description'] == 'award') $tipo = 'Prêmio';
                else if($v['HistoricBalance']['description'] == 'pagseguro devolution') $tipo = 'Devolução Pagseguro';
                else if($v['HistoricBalance']['description'] == 'paypal devolution') $tipo = 'Devolução Paypal';
                else if($v['HistoricBalance']['description'] == 'paypal deposit') $tipo = 'Depósito Paypal';
                else if($v['HistoricBalance']['description'] == 'pagseguro deposit') $tipo = 'Depósito Pagseguro';
                else if($v['HistoricBalance']['description'] == 'internal balance') $tipo = 'Depósito Interno';
                else $tipo = 'Indefinido';
                ?>

                <?= $tipo ?>
            </td>
            <td>
                $<?= $v['HistoricBalance']['amount'] ?>
            </td>
            <!--<td>
                <div class="btn-group">
                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                            <?php /*echo $this->Html->link('<i class="fa fa-edit"></i>&nbsp Editar', 'javascript: void(0)', array("escape" => false, 'id' => $v['LotPremio']['id'], 'class' => 'btnEditar')) */?>
                        </li>
                    </ul>
                </div>
            </td>-->
        </tr>
    <?php } ?>
    <tr>
        <th>
            Total de Entrada
        </th>
        <td colspan="5">
            $<?= number_format($totalEntrada, 2, '.', '') ?>
        </td>
    </tr>
    <tr>
        <th>
            Total de Saída
        </th>
        <td colspan="5">
            $<?= number_format($totalSaida, 2, '.', '') ?>
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