<h4>
    Total de registros: <?= $this->Paginator->params()['count']; ?>&nbsp;&nbsp;&nbsp;
    Total entrada: R$<?= $totalEntrada[0]['total_entrada'] != null ? $totalEntrada[0]['total_entrada'] : '0.00'; ?>
    Total saída: R$<?= $totalSaida[0]['total_saida'] != null ? $totalSaida[0]['total_saida'] : '0.00'; ?>
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
    </tr>
    </thead>
    <tbody>
    <?php $modalidades = [
        'deposit' => 'Depósito',
        'buy' => 'Compra',
        'award' => 'Prêmio',
        'withdrawal' => 'Retirada',
    ]; ?>
    <?php $tipos = [
        'paypal.deposit' => 'Paypal',
        'pagseguro.deposit' => 'Pagseguro',
        'buy.soccer_expert' => 'Soccer Expert',
        'buy.lottery' => 'Loteria',
        'buy.scratch_card' => 'Raspadinha',
        'buy.cartoleando.lea_classic' => 'Liga Clássica',
        'buy.cartoleando.lea_cup' => 'Liga Mata Mata',
        'award.soccer_expert' => 'Soccer Expert',
        'award.lottery' => 'Loteria',
        'award.scratch_card' => 'Raspadinha',
        'award.cartoleando.lea_classic' => 'Liga Classica',
        'award.cartoleando.lea_cup' => 'Liga Mata Mata',
        'internal.deposit' => 'Depósito Interno',
        'agent.withdrawal' => 'Ag. Pagamento',
        'internal.withdrawal' => 'Retirada Interna',
    ];?>
    <?php $totalEntrada = 0.00; $totalSaida = 0.00; foreach ($dados as $k => $v) { ?>
        <?php
        if($v['HistoricBalance']['system'] == 1) {
            $totalEntrada += $v['HistoricBalance']['amount'] < 0 ? $v['HistoricBalance']['amount'] * -1 : $v['HistoricBalance']['amount'];
        } ?>
        <?php
        if($v['HistoricBalance']['system'] == 0)
        {
            $totalSaida += $v['HistoricBalance']['amount'] < 0 ? $v['HistoricBalance']['amount'] * -1 : $v['HistoricBalance']['amount'];
        } ?>
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
                //$modalidade = $model->getLotUserJogo($v['HistoricBalance']['id']);
                $found = false;

                /*if($v['HistoricBalance']['description'] == 'award') {
                    $query = count($model->getLotUserJogo($v['HistoricBalance']['id']));
                    $modalidade = 'Loteria';
                    $found = $query > 0 ? true : false;
                }

                if(!$found && $v['HistoricBalance']['description'] == 'award') {
                    $query = count($model->getSocAposta($v['HistoricBalance']['id']));
                    $modalidade = $query > 0 ? 'Soccer Expert' : '';
                    $found = $query > 0 ? true : false;
                }

                if(!$found && $v['HistoricBalance']['description'] == 'award') {
                    $query = count($model->getRaspadinha($v['HistoricBalance']['id']));
                    $modalidade = $query > 0 ? 'Raspadinhas' : '';
                    $found = $query > 0 ? true : false;
                }*/



                /*if(!$found && $v['HistoricBalance']['context_message'] == 'paypal.deposit') {
                    $query = count($model->getPedidoPaypal($v['HistoricBalance']['id']));
                    $modalidade = $query > 0 ? 'Depósito' : '';
                    $found = $query > 0 ? true : false;
                }

                if(!$found && $v['HistoricBalance']['context_message'] == 'pagseguro.deposit') {
                    $query = count($model->getPedidoPagseguro($v['HistoricBalance']['id']));
                    $modalidade = $query > 0 ? 'Depósito' : '';
                    $found = $query > 0 ? true : false;
                }

                if(!$found && $v['HistoricBalance']['context_message'] == 'pagseguro.devolution') {
                    $query = count($model->getPedidoPagseguro($v['HistoricBalance']['id']));
                    $modalidade = $query > 0 ? 'Devolução' : '';
                    $found = $query > 0 ? true : false;
                }

                if(!$found && $v['HistoricBalance']['modality'] == 'buy') {
                    $query = count($model->getItem($v['HistoricBalance']['id']));
                    $modalidade = $query > 0 ? 'Compra' : '';
                    $found = $query > 0 ? true : false;
                }

                if(!$found && $v['HistoricBalance']['context_message'] == 'internal.deposit') {
                    $query = count($model->getBalanceInsert($v['HistoricBalance']['id']));
                    $modalidade = $query > 0 ? 'Depósito' : '';
                    $found = $query > 0 ? true : false;
                }

                if(!$found && $v['HistoricBalance']['context_message'] == 'agent.withdrawal') {
                    $query = count($model->getRetiradaAgente($v['HistoricBalance']['id']));
                    $modalidade = $query > 0 ? 'Retirada' : '';
                    $found = $query > 0 ? true : false;
                }

                if(!$found && $v['HistoricBalance']['context_message'] == 'internal.withdrawal') {
                    $query = count($model->getBalanceWithdraw($v['HistoricBalance']['id']));
                    $modalidade = $query > 0 ? 'Retirada' : '';
                    $found = $query > 0 ? true : false;
                }

                if(!$found) {
                    $modalidade = 'Indefinido';
                }*/

                /*if(isset($v['LotUserJogo']) && $v['LotUserJogo']['id'] != null) $modalidade = 'Loteria';
                else if(isset($v['SocAposta']) && $v['SocAposta']['id'] != null) $modalidade = 'Soccer Expert';
                else if(isset($v['Raspadinha']) && $v['Raspadinha']['id'] != null) $modalidade = 'Raspadinhas';
                else if(isset($v['PedidoPaypal']) && $v['PedidoPaypal']['id'] != null) $modalidade = 'Depósito';
                else if(isset($v['PedidoPagseguro']) && $v['PedidoPagseguro']['id'] != null) $modalidade = 'Depósito';
                else if(isset($v['Item']) && $v['Item']['id'] != null) $modalidade = 'Compra';
                else if(isset($v['BalanceInsert']) && $v['BalanceInsert']['id'] != null) $modalidade = 'Depósito';
                else if(isset($v['RetiradaAgente']) && $v['RetiradaAgente']['id'] != null) $modalidade = 'Retirada';
                else $modalidade = 'Indefinido';*/
                ?>

                <?= $modalidades[$v['HistoricBalance']['modality']] ?>
            </td>
            <!--<td>

            </td>-->
            <td>
                <?php $tipo = ''; ?>
                <?php
                /*if($v['HistoricBalance']['context_message'] == 'buy') $tipo = 'Compra';
                else if($v['HistoricBalance']['context_message'] == 'agent withdrawal') $tipo = 'Ag. Pagamento';
                else if($v['HistoricBalance']['context_message'] == 'award') $tipo = 'Prêmio';
                else if($v['HistoricBalance']['context_message'] == 'pagseguro devolution') $tipo = 'Devolução Pagseguro';
                else if($v['HistoricBalance']['context_message'] == 'paypal devolution') $tipo = 'Devolução Paypal';
                else if($v['HistoricBalance']['context_message'] == 'paypal deposit') $tipo = 'Depósito Paypal';
                else if($v['HistoricBalance']['context_message'] == 'pagseguro deposit') $tipo = 'Depósito Pagseguro';
                else if($v['HistoricBalance']['context_message'] == 'internal deposit') $tipo = 'Depósito Interno';
                else if($v['HistoricBalance']['context_message'] == 'internal withdrawal') $tipo = 'Retirada Interna';
                else $tipo = 'Indefinido';*/
                ?>

                <?= $tipos[$v['HistoricBalance']['context_message']] ?>
            </td>
            <td>
                R$<?= $v['HistoricBalance']['amount'] < 0 ? number_format($v['HistoricBalance']['amount'] * -1, 2, '.', '') : number_format($v['HistoricBalance']['amount'], 2, '.', '') ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <th>
            Total de Entrada
        </th>
        <td colspan="5">
            R$<?= number_format($totalEntrada, 2, '.', '') ?>
        </td>
    </tr>
    <tr>
        <th>
            Total de Saída
        </th>
        <td colspan="5">
            R$<?= number_format($totalSaida, 2, '.', '') ?>
        </td>
    </tr>
    </tbody>
</table>
<div class="">
    <ul class="pagination">
        <?php
        $this->Paginator->options(array('url' =>  array('?' => $query_string)));
        echo $this->Paginator->prev('«', array('tag' => 'li'), null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
        echo $this->Paginator->numbers(['separator' => '','currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1]);
        echo $this->Paginator->next(__('»'), array('tag' => 'li', 'currentClass' => 'disabled'), null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
        ?>
    </ul>
</div>