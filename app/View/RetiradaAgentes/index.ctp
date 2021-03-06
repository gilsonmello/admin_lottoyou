<section id="AppRetiradaAgentes" <?php echo ($modal == 1) ? 'style="padding:0;"' : '' ?>>
    <div class="section-body" <?php echo ($modal == 1) ? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-apps" style="margin-bottom:0;"></i> Contatos
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b>Todos</b>
            </header>
            <div class="tools">
                <button id="voltar" type="button" class="btn ink-reaction btn-flat btn-default-bright" data-dismiss="modal">
                    <a href="javascript: void()">
                        <i class="fa fa-fw fa-arrow-left"></i>
                        Voltar
                    </a>
                </button>
            </div>
        </div>
        <div class="card card-collapsed" style="min-height:500px;">
            <div class="card-head card-head-sm" style="border-bottom:1px solid #f2f3f3;">
                <div class="tools">
                    <div class="btn-group" style="margin-right: 0px;">
                        <button type="button" class="btn ink-reaction btn-collapse btn-default">
                            <i class="fa fa-angle-down"></i>
                        </button>
                    </div>
                </div>
                <header>
                    <i class="fa fa-filter" style="vertical-align: inherit;margin-top: -0.3em;margin-left: 2px;margin-right: 4px;"></i>
                    Filtro
                </header>
            </div>
            <div class="card-body style-default-light" style="display: none;padding-top:10px;padding-bottom:10px;">
                <?php echo $this->Form->create('search', array('id' => 'pesquisarRetiradaAgentes', 'class' => 'form', 'role' => 'form', 'type' => 'get')); ?>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <?= $this->Form->input('name', ['label' => 'Nome', 'class' => 'form-control', 'required' => false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <?= $this->Form->input('dt_begin', ['label' => 'Data Inicio', 'class' => 'form-control date', 'required' => false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <?= $this->Form->input('dt_end', ['label' => 'Data Final', 'class' => 'form-control date', 'required' => false]); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" style="vertical-align:bottom;">
                        <button type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando..." class="btn ink-reactio/n btn-primary-dark" style="margin-right: -4px;">
                            <i class="fa fa-search"></i>&nbsp;
                            Pesquisar
                        </button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
            <div id="gridRetiradaAgentes" style="padding: 24px;">
                <h4>
                    Total de registros: <?= $this->Paginator->params()['count']; ?>
                </h4>
                <table id=""
                       class="table table-condensed table-hover"
                       cellspacing="0"
                       width="100%"
                       style="margin-bottom:0;">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
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
                    <?php $total = 0.00; foreach ($dados as $k => $v) { ?>
                        <tr>
                            <td>
                                <?php
                                    if($v['RetiradaAgente']['name'] != null) echo $v['RetiradaAgente']['name'];
                                    else echo 'Não informado';
                                ?>
                            </td>
                            <td>
                                <?php $total += $v['RetiradaAgente']['value']; ?>
                                <?php
                                if($v['RetiradaAgente']['value'] != null) echo '$'.$v['RetiradaAgente']['value'];
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
                    <tr>
                        <th>
                            Total
                        </th>
                        <td colspan="10">
                            $<?= number_format($total, 2, '.', '') ?>
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
            </div>
        </div>
    </div>
</section>