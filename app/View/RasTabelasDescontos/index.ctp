<section id="AppRasTabelasDescontos" <?php echo ($modal == 1) ? 'style="padding:0;"' : '' ?>>
    <div class="section-body" <?php echo ($modal == 1) ? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-apps" style="margin-bottom:0;"></i> Cadastros 
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b>Tabelas de Preços e Descontos</b>
            </header>
            <div class="tools">
                <button id="voltar" type="button" class="btn ink-reaction btn-flat btn-default-bright" data-dismiss="modal">
                    <a href="javascript: void()">
                        <i class="fa fa-fw fa-arrow-left"></i> 
                        Voltar
                    </a>
                </button>
                <button id="cadastrarRasTabelasDesconto" type="button" class="btn ink-reaction btn-default-light">
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
                <?php echo $this->Form->create('RasTabelasDesconto', array('id' => 'pesquisarRasTabelasDesconto', 'class' => 'form', 'role' => 'form')); ?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">              
                            <?php echo $this->Form->input('tema_id', array(
                                'label' => 'Tema', 
                                'class' => 'form-control chosen', 
                                'options' => $optionsTemas,
                                'empty' => 'Selecione o tema'
                            )); ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">              
                            <?php echo $this->Form->input('quantity', array('label' => 'Quantidade', 'class' => 'centena form-control')); ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">              
                            <?php echo $this->Form->input('percentage', array('label' => 'Porcentagem', 'class' => 'porcentagem form-control')); ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <?php echo $this->Form->input('RasTabelasDesconto.active', array('label' => 'Ativo', 'options' => array('1' => 'Sim', '0' => 'Não'), 'empty' => 'Todos', 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2" style="vertical-align:bottom;">
                        <button type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando..." class="btn ink-reactio/n btn-primary-dark pull-right" style="margin-right: -4px;">
                            <i class="fa fa-search"></i>&nbsp;
                            Pesquisar
                        </button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
            <div id="gridRasTabelasDescontos" style="padding: 24px;">                
                <h4>Total de registros: <?php echo count($dados); ?></h4> 
                <table id=""
                       class="table table-condensed table-hover" 
                       cellspacing="0" 
                       width="100%"
                       style="margin-bottom:0;">
                    <thead>
                        <tr>
                            <th>Tema</th>
                            <th>Quantidade</th>
                            <th>Porcentagem</th>
                            <th>É desconto?</th>
                            <th style="width:80px;">Ativo</th>
                            <th style="width:50px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados as $k => $v) { ?>
                            <tr>
                                <td><?php echo $v['TemasRaspadinha']['nome']; ?></td>
                                <td><?php echo $v['RasTabelasDesconto']['quantity']; ?></td>
                                <td><?php echo $v['RasTabelasDesconto']['percentage']; ?>%</td>
                                <td>
                                    <label class="label label-<?php echo $v['RasTabelasDesconto']['is_discount_label']; ?>">
                                        <?php echo $v['RasTabelasDesconto']['is_discount']; ?>
                                    </label>
                                </td>
                                <td>
                                    <label class="label label-<?php echo $v['RasTabelasDesconto']['ativo_label']; ?>">
                                        <?php echo $v['RasTabelasDesconto']['ativo']; ?>
                                    </label>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown">   
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <!-- <li class="divider"></li> -->
                                            <li><?php echo $this->Html->link('<i class="md md-create"></i>&nbsp Editar', 'javascript: void(0)', array("escape" => false, 'id' => $v['RasTabelasDesconto']['id'], 'class' => 'btnEditar')) ?></li>
                                            <li><?php echo $this->Html->link('<i class="md md-delete"></i>&nbsp Excluir', 'javascript: void(0)', array("escape" => false, 'id' => $v['RasTabelasDesconto']['id'], 'class' => 'btnDeletar')) ?></li>
                                            <li style="background: #F1F1F1; font-size: 9px; text-align: center;">Atualizado em: <?php echo @$v['RasTabelasDesconto']['modified'] ?></li>
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