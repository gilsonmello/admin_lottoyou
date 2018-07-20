<h4>Total de registros: <?= $this->Paginator->params()['count']; ?></h4>
<table id=""
       class="table table-condensed table-hover"
       cellspacing="0"
       width="100%"
       style="margin-bottom:0;">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Banco</th>
        <th>Agência</th>
        <th>N. conta</th>
        <th>Tipo de conta</th>
        <th>Operação</th>
        <th>Doc. identificação</th>
        <th>País</th>
        <th>Data</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($dados as $k => $v) { ?>
        <tr>
            <td>
                <?= $v['Agent']['name']; ?>
            </td>
            <td>
                <?= $v['Agent']['bank']; ?>
            </td>
            <td>
                <?= $v['Agent']['agency']; ?>
            </td>
            <td>
                <?= $v['Agent']['number']; ?>
            </td>
            <td>
                <?php
                if($v['Agent']['account_type'] == 1) echo 'C. corrente';
                else if($v['Agent']['account_type'] == 2) echo 'C. poupança';
                ?>
            </td>
            <td>
                <?= $v['Agent']['operation'] ?>
            </td>
            <td>
                <?= $v['Agent']['identification'] ?>
            </td>
            <td>
                <?= $v['Country']['name'] ?>
            </td>
            <td>
                <?= $this->Time->format($v['Agent']['modified'], '%d/%m/%Y %H:%M'); ?>
            </td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                            <?php echo $this->Html->link('<i class="fa fa-send"></i>&nbsp Mandar mensagem', 'javascript: void(0)', array("escape" => false, 'id' => $v['Retirada']['id'], 'class' => 'btnEdit')) ?>
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