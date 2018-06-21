<h4>Total de registros: <?php echo $this->Paginator->params()['count']; ?></h4>
<table id=""
       class="table table-condensed table-hover"
       cellspacing="0"
       width="100%"
       style="margin-bottom:0;">
    <thead>
    <tr>
        <th>Usuário</th>
        <th>Modalidade</th>
        <th>Valor</th>
        <th>Data</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($dados as $k => $v) { ?>
        <tr>
            <td>
                <?php echo $v['User']['username']; ?>
            </td>
            <td>
                <?php
                if($v['OrderItem']['type'] == "scratch_card") echo "Raspadinha";
                else if($v['OrderItem']['type'] == "soccer_expert") echo "Soccer Expert";
                else echo "Loteria";
                ?>
            </td>
            <td>
                $<?php echo $v['OrderItem']['amount']; ?>
            </td>
            <td>
                <?= $this->Time->format($v['OrderItem']['created_at'], '%d/%m/%Y %H:%M'); ?>
            </td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                            <?php /*echo $this->Html->link('<i class="fa fa-cart-plus"></i>&nbsp Gerar Prêmios', 'javascript: void(0)', array("escape" => false, 'id' => $v['RasLote']['id'], 'class' => 'btnGerarNumeros')) */?>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<div class="">
    <ul class="pagination">
        <?php
        echo $this->Paginator->prev(__('<'), ['tag' => 'li'], null, ['tag' => 'li','class' => 'disabled','disabledTag' => 'a']);
        echo $this->Paginator->numbers(['separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1]);
        echo $this->Paginator->next(__('>'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
        ?>
    </ul>
</div>
