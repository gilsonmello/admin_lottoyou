<section id="AppSocCiclos" <?php echo ($modal == 1) ? 'style="padding:0;"' : '' ?>>
    <div class="section-body" <?php echo ($modal == 1) ? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-apps" style="margin-bottom:0;"></i> Cadastros 
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b>Ciclos</b>
            </header>
            <div class="tools">
                <button id="voltar" type="button" class="btn ink-reaction btn-flat btn-default-bright" data-dismiss="modal">
                    <a href="javascript: void()">
                        <i class="fa fa-fw fa-arrow-left"></i> 
                        Voltar
                    </a>
                </button>
                <button id="cadastrarSocCiclo" type="button" class="btn ink-reaction btn-default-light">
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
                <?= $this->Form->create('SocCiclo', [
                    'id' => 'pesquisarSocCiclo', 
                    'class' => 'form', 
                    'role' => 'form'
                ]); ?>
                <div class="row">
                    <div class="col-sm-3 col-lg-3">
                        <div class="form-group">                
                            <?= $this->Form->input('soc_categoria_id', [
                                'label' => 'Categoria', 
                                'class' => 'form-control chosen', 
                                'options' => $optionsCategorias, 
                                'empty' => 'Selecione', 
                            ]); ?>
                        </div>
                    </div> 
                    <div class="col-lg-2">
                        <div class="form-group">              
                            <?= $this->Form->input('identificacao', [
                                'label' => 'Identificação', 
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <?= $this->Form->input('SocCiclo.active', [
                                'label' => 'Ativo', 
                                'options' => array('1' => 'Sim', '0' => 'Não'), 
                                'empty' => 'Todos', 
                                'class' => 'form-control'
                            ]); ?>
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
            <div id="gridSocCiclos" style="padding: 24px;">                
                <h4>Total de registros: <?php echo count($dados); ?></h4> 
                <table id=""
                       class="table table-condensed table-hover" 
                       cellspacing="0" 
                       width="100%"
                       style="margin-bottom:0;">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Identificação</th>
                            <th>Data Inicio</th>
                            <th>Data Fim</th>
                            <th style="width:80px;">Ativo</th>
                            <th style="width:50px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados as $k => $v) { ?>
                            <tr>
                                <td><?php echo $v['SocCategoria']['nome']; ?></td>
                                <td><?php echo $v['SocCiclo']['identificacao']; ?></td>
                                <td><?php echo $v['SocCiclo']['data_inicio']; ?></td>
                                <td><?php echo $v['SocCiclo']['data_fim']; ?></td>
                                <td>
                                    <label class="label label-<?php echo $v['SocCiclo']['ativo_label']; ?>">
                                        <?php echo $v['SocCiclo']['ativo']; ?>
                                    </label>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown">   
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <!-- <li class="divider"></li> -->
                                            <li><?php echo $this->Html->link('<i class="md md-create"></i>&nbsp Editar', 'javascript: void(0)', array("escape" => false, 'id' => $v['SocCiclo']['id'], 'class' => 'btnEditar')) ?></li>
                                            <li><?php echo $this->Html->link('<i class="md md-delete"></i>&nbsp Excluir', 'javascript: void(0)', array("escape" => false, 'id' => $v['SocCiclo']['id'], 'class' => 'btnDeletar')) ?></li>
                                            <li style="background: #F1F1F1; font-size: 9px; text-align: center;">Atualizado em: <?php echo @$v['SocCiclo']['modified'] ?></li>
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