<h4>Total de registros: <?= $this->Paginator->params()['count']; ?></h4>
<table id=""
       class="table table-condensed table-hover"
       cellspacing="0"
       width="100%"
       style="margin-bottom:0;">
    <thead>
    <tr>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Assunto</th>
        <th>Descrição</th>
        <th>Respondido</th>
        <th>Data</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($dados as $k => $v) { ?>
        <tr>
            <td>
                <?= $v['Contato']['name']; ?>
            </td>
            <td>
                <?= $v['Contato']['email']; ?>
            </td>
            <td>
                <?= $v['Contato']['subject']; ?>
            </td>
            <td>
                $<?= $v['Contato']['description']; ?>
            </td>
            <td>
                <?= $v['Contato']['answered'] == 1 ? 'Sim' : 'Não'; ?>
            </td>
            <td>
                <?= $this->Time->format($v['Contato']['modified'], '%d/%m/%Y %H:%M'); ?>
            </td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                            <?php echo $this->Html->link('<i class="fa fa-send"></i>&nbsp Responder', 'javascript: void(0)', array("escape" => false, 'id' => $v['Contato']['id'], 'class' => 'btnResponder')) ?>
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