<section id="AppLotJogos" <?php echo ($modal == 1) ? 'style="padding:0;"' : '' ?>>
    <div class="section-body" <?php echo ($modal == 1) ? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-apps" style="margin-bottom:0;"></i> Cadastros 
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b>Gerenciamento de Sorteios</b>
            </header>
            <div class="tools">
                <button id="voltar" type="button" class="btn ink-reaction btn-flat btn-default-bright" data-dismiss="modal">
                    <a href="javascript: void()">
                        <i class="fa fa-fw fa-arrow-left"></i> 
                        Voltar
                    </a>
                </button>
                <button id="cadastrarLotJogo" type="button" class="btn ink-reaction btn-default-light">
                    <i class="fa fa-plus-square"></i>
                    Cadastrar
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
                <?php echo $this->Form->create('search', array('id' => 'pesquisarLotJogo', 'class' => 'form', 'role' => 'form')); ?>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <?php echo $this->Form->input('LotJogo.sorteio', array('label' => 'Nome', 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <?php echo $this->Form->input('LotJogo.concurso', array('label' => 'Concurso', 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="col-md-6" style="vertical-align:bottom;">
                        <button type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando..." class="btn ink-reactio/n btn-primary-dark pull-right" style="margin-right: -4px;">
                            <i class="fa fa-search"></i>&nbsp;
                            Pesquisar
                        </button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
            <div id="gridLotJogos" style="padding: 24px;">                
                <h4>Total de registros: <?php echo count($dados); ?></h4> 
                <table id=""
                       class="table table-condensed" 
                       cellspacing="0" 
                       width="100%"
                       style="margin-bottom:0;">
                    <thead>
                        <tr>
                            <th style="width:90px;">Concurso</th>
                            <th>Sorteio</th>
                            <th style="">Premiação</th>
                            <th style="width:200px;">Data/Hora limite</th>
                            <th style="width:50px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados as $k => $v) { ?>
                            <tr>
                                <td><?php echo $v['LotJogo']['concurso']; ?></td>
                                <td><?php echo $v['LotJogo']['sorteio']; ?></td>
                                <?php
                                $datar = str_replace('/', '-', $v['LotJogo']['data_fim'] . ' ' . $v['LotJogo']['hora_fim']);
                                $data1 = new DateTime(date('d-m-Y H:m:s'));
                                $data2 = new DateTime($datar);
                                $intervalo = $data1->diff($data2);
                                if ($intervalo->d == 0 && $intervalo->h == 0 && $intervalo->i <= 0 || $intervalo->invert == 1) {
                                    $label = '<label class="label label-danger" style="font-size: 12px">';
                                    $label2 = '</label>';
                                } else {
                                    $label = '<label class="label label-success" style="font-size: 12px">';
                                    $label2 = '</label>';
                                }
                                ?>
                                <td><?php echo $v['LotJogo']['premio']; ?></td>
                                <td><?php echo $label . $v['LotJogo']['data_fim'] . ' ' . $v['LotJogo']['hora_fim'] . $label2; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <li><?php echo $this->Html->link('<i class="md md-language"></i>&nbsp Resultado', 'javascript: void(0)', array("escape" => false, 'id' => $v['LotJogo']['id'], 'ret' => $v['LotJogo']['lot_jogos_resultado_id'], 'class' => 'btnResultado')) ?></li>
                                            <li><?php echo $this->Html->link('<i class="md md-grain"></i>&nbsp Ganhadores', 'javascript: void(0)', array("escape" => false, 'id' => $v['LotJogo']['id'], 'class' => 'btnGanhadores')) ?></li>
                                            <li><?php echo $this->Html->link('<i class="md md-create"></i>&nbsp Editar', 'javascript: void(0)', array("escape" => false, 'id' => $v['LotJogo']['id'], 'class' => 'btnEditar')) ?></li>
                                            <li><?php echo $this->Html->link('<i class="md md-delete"></i>&nbsp Excluir', 'javascript: void(0)', array("escape" => false, 'id' => $v['LotJogo']['id'], 'class' => 'btnDeletar')) ?></li>
                                            <li style="background: #F1F1F1; font-size: 9px; text-align: center;">Atualizado em: <?php echo @$v['LotJogo']['modified'] ?></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>