<section id="AppTransacoes" <?php echo ($modal == 1) ? 'style="padding:0;"' : '' ?>>
    <div class="section-body" <?php echo ($modal == 1) ? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-apps" style="margin-bottom:0;"></i> Relatório
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b>Transações</b>
            </header>
            <div class="tools">
                <!--<button id="cadastrarTransacoes" type="button" class="btn ink-reaction btn-default-light">
                    <i class="fa fa-plus-square"></i>
                    Cadastrar
                </button>-->
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
                <?php echo $this->Form->create('search', array('id' => 'pesquisarTransacoes', 'class' => 'form', 'role' => 'form', 'type' => 'get')); ?>
                <div class="row">
                    <div class="col-sm-3 col-lg-3">
                        <div class="form-group">
                            <?= $this->Form->input('modality', [
                                'label' => 'Modalidades',
                                'class' => 'form-control chosen',
                                'options' => [
                                    1 => 'Soccer Apostas',
                                    2 => 'Loteria Apostas',
                                    3 => 'Raspadinhas',
                                    4 => 'Depósitos Paypal',
                                    5 => 'Depósitos Pagseguro',
                                    6 => 'Item',
                                    7 => 'Saldos Inseridos',
                                    8 => 'Saldos Removidos',
                                ],
                                'required' => false,
                                'multiple' => true,
                            ]); ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <?= $this->Form->input('nome', ['label' => 'Nome', 'class' => 'form-control', 'required' => false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <?= $this->Form->input('dt_inicio', ['label' => 'Data Inicio', 'class' => 'form-control date', 'required' => false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <?= $this->Form->input('dt_fim', ['label' => 'Data Final', 'class' => 'form-control date', 'required' => false]); ?>
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
            <div id="gridTransacoes" style="padding: 24px;">
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
            </div>
        </div>
    </div>
</section>