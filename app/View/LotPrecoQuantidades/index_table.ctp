<h4>Total de registros: <?= $this->Paginator->params()['count']; ?></h4>
<table id=""
       class="table table-condensed table-hover"
       cellspacing="0"
       width="100%"
       style="margin-bottom:0;">
    <thead>
    <tr>
        <th>Loteria</th>
        <th>Qtd.</th>
        <th>Valor</th>
        <th>Data</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php $total = 0.00; foreach ($dados as $k => $v) { ?>
        <tr>
            <td>
                <?= $v['LotCategoria']['nome']; ?>
            </td>
            <td>
                <?= $v['LotPrecoQuantidade']['qtd']; ?>
            </td>
            <td>
                $<?= $v['LotPrecoQuantidade']['valor']; ?>
            </td>
            <td>
                <?= $this->Time->format($v['LotPrecoQuantidade']['created'], '%d/%m/%Y %H:%M'); ?>
            </td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                            <?php echo $this->Html->link('<i class="fa fa-edit"></i>&nbsp Editar', 'javascript: void(0)', array("escape" => false, 'id' => $v['LotPrecoQuantidade']['id'], 'class' => 'btnEditar')) ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link('<i class="md md-delete"></i>&nbsp Excluir', 'javascript: void(0)', array("escape" => false, 'id' => $v['LotPrecoQuantidade']['id'], 'class' => 'btnDeletar')) ?>
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
        $this->Paginator->options(array('url' =>  array('?' => $query)));
        echo $this->Paginator->prev('«', array('tag' => 'li'), null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
        echo $this->Paginator->numbers(['separator' => '','currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1]);
        echo $this->Paginator->next(__('»'), array('tag' => 'li', 'currentClass' => 'disabled'), null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
        ?>
    </ul>
</div>