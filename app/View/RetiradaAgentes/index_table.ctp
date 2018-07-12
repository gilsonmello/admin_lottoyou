<h4>Total de registros: <?= $this->Paginator->params()['count']; ?></h4>
<table id=""
       class="table table-condensed table-hover"
       cellspacing="0"
       width="100%"
       style="margin-bottom:0;">
    <thead>
    <tr>
        <th>Valor</th>
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
                <?php
                if($v['RetiradaAgente']['value'] != null) echo '$'.$v['RetiradaAgente']['value'];
                else echo 'Não informado';
                ?>
            </td>
            <td>
                <?php
                if($v['RetiradaAgente']['name'] != null) echo $v['RetiradaAgente']['name'];
                else echo 'Não informado';
                ?>
            </td>
            <td>
                <?php
                if($v['RetiradaAgente']['bank'] != null) echo $v['RetiradaAgente']['bank'];
                else echo 'Não informado';
                ?>
            </td>
            <td>
                <?php
                if($v['RetiradaAgente']['agency'] != null) echo $v['RetiradaAgente']['agency'];
                else echo 'Não informado';
                ?>
            </td>
            <td>
                <?php
                if($v['RetiradaAgente']['number'] != null) echo $v['RetiradaAgente']['number'];
                else echo 'Não informado';
                ?>
            </td>
            <td>
                <?php
                if($v['RetiradaAgente']['account_type'] == 1) echo 'C. corrente';
                else if($v['RetiradaAgente']['account_type'] == 2) echo 'C. poupança';
                else echo 'Não informado';
                ?>
            </td>
            <td>
                <?php
                if($v['RetiradaAgente']['operation'] != null) echo $v['RetiradaAgente']['operation'];
                else echo 'Não informado';
                ?>
                <?= $v['RetiradaAgente']['operation'] ?>
            </td>
            <td>
                <?php
                if($v['RetiradaAgente']['identification'] != null) echo $v['RetiradaAgente']['identification'];
                else echo 'Não informado';
                ?>
            </td>
            <td>
                <?php
                if($v['Country']['name'] != null) echo $v['Country']['name'];
                else echo 'Não informado';
                ?>
            </td>
            <td>
                <?= $this->Time->format($v['RetiradaAgente']['modified'], '%d/%m/%Y %H:%M'); ?>
            </td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                            <?php echo $this->Html->link('<i class="fa fa-send"></i>&nbsp Mandar mensagem', 'javascript: void(0)', array("escape" => false, 'id' => $v['RetiradaAgente']['id'], 'class' => 'btnEdit')) ?>
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
        $this->Paginator->options(array('url' =>  $query));
        echo $this->Paginator->prev('«', array('tag' => 'li'), null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
        echo $this->Paginator->numbers(['separator' => '','currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1]);
        echo $this->Paginator->next(__('»'), array('tag' => 'li', 'currentClass' => 'disabled'), null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
        ?>
    </ul>
</div>