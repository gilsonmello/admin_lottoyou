<h4>
    Total de registros: <?= $this->Paginator->params()['count']; ?>&nbsp;&nbsp;&nbsp;
    Total: $<?= $total[0]['total']; ?>
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
        <th>Tipo</th>
        <th>Quantia</th>
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
                //$modalidade = $model->getLotUserJogo($v['HistoricBalance']['id']);
                $found = false;

                if($v['HistoricBalance']['description'] == 'award') {
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
                }

                if(!$found) {
                    $modalidade = 'Indefinido';
                }
                ?>


                <?= $modalidade ?>
            </td>
            <td>
                Prêmio
            </td>
            <td>
                $<?= $v['HistoricBalance']['amount'] ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <th colspan="5">
            Total da página
        </th>
        <td>
            $<?= number_format($totalEntrada, 2, '.', '') ?>
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