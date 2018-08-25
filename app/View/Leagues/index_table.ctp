<h4>Total de registros: <?= $this->Paginator->params()['count']; ?></h4>
<table id=""
       class="table table-condensed table-hover"
       cellspacing="0"
       width="100%"
       style="margin-bottom:0;">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Slug</th>
        <th>Valor</th>
        <th>Aberto</th>
        <th>Ativo</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($dados as $k => $v) { ?>
        <tr>
            <td>
                <?= $v['League']['name']; ?>
            </td>
            <td>
                <?= $v['League']['slug']; ?>
            </td>
            <td>
                R$<?= $v['League']['value']; ?>
            </td>
            <td>
                <label class="label label-<?php echo $v['League']['aberto_label']; ?>">
                    <?= $v['League']['aberto']; ?>
                </label>
            </td>
            <td>
                <label class="label label-<?php echo $v['League']['ativo_label']; ?>">
                    <?php echo $v['League']['ativo']; ?>
                </label>
            </td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <!--<li class="divider"></li>-->
                        <li><?= $this->Html->link('<i class="md md-create"></i>&nbsp Editar', 'javascript: void(0)', array("escape" => false, 'id' => $v['League']['id'], 'class' => 'btnEditar')) ?></li>
                        <li>
                            <?= $this->Html->link('<i class="md md-delete"></i>&nbsp Excluir', 'javascript: void(0)', [
                                "escape" => false,
                                'id' => $v['League']['id'],
                                'class' => 'btnDeletar'
                            ]) ?>
                        </li>
                        <li style="background: #F1F1F1; font-size: 9px; text-align: center;">Atualizado em: <?= @$v['League']['updated_at'] ?></li>
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