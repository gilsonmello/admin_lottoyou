<section id="AppGelPessoas" <?php echo ($modal == 1)? 'style="padding:0;"' : '' ?>>
    <div class="section-body" <?php echo ($modal == 1)? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-apps" style="margin-bottom:0;"></i> Cadastros 
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b>Pessoas</b>
            </header>
            <div class="tools">
                <button id="voltar" type="button" class="btn ink-reaction btn-flat btn-default-bright" data-dismiss="modal">
                    <a href="javascript: void()">
                        <i class="fa fa-fw fa-arrow-left"></i> 
                        Voltar
                    </a>
                </button>
                <button id="cadastrarGelPessoa" type="button" class="btn ink-reaction btn-default-light">
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
                <?php echo $this->Form->create('search', array('id'=>'pesquisarGelPessoa','class' => 'form', 'role' => 'form')); ?>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <?php echo $this->Form->input('GelPessoa.nome', array('label' => 'Nome', 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group ">
                            <?php echo $this->Form->input('GelPessoa.active', array('label' => 'Ativo', 'options' => array('1'=>'Sim', '0'=>'Não'), 'empty'=>'Todos', 'class' => 'form-control')); ?>
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
            <div id="gridGelPessoa" style="padding: 24px;">                
                <h4 style="margin-left: 5px;">Total de registros: <?php echo count($dados); ?></h4> 
                <table id=""
                       class="table table-condensed table-hover" 
                       cellspacing="0" 
                       width="100%"
                       style="margin-bottom:0;">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Pessoa</th>
                            <th>CPF/CNPJ</th>
                            <th>Telefone</th>
                            <th>Celular</th>
                            <th>E-mail</th>
                            <th style="width:80px;">Ativo</th>
                            <th style="width:50px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados as $k => $v) { ?>
                            <tr>
                                <td><label class="label label-<?php echo $v['GelPessoa']['tipo_cadastro_label']; ?>" data-toggle="tooltip" data-original-title="<?php echo $optionsTipoCadastro[$v['GelPessoa']['tipo_cadastro']]; ?>" data-html="true" data-placement="right"><?php echo $v['GelPessoa']['tipo_cadastro']; ?></label></td>
                                <td><?php echo $v['GelPessoa']['nome']; ?></td>
                                <td><?php echo $v['GelPessoa']['cpf_cnpj']; ?></td>
                                <td><?php echo $v['GelPessoa']['contato_telefone']; ?></td>
                                <td><?php echo $v['GelPessoa']['contato_celular']; ?></td>
                                <td><?php echo $v['GelPessoa']['contato_email']; ?></td>
                                <td><label class="label label-<?php echo $v['GelPessoa']['ativo_label']; ?>"><?php echo $v['GelPessoa']['ativo']; ?></label></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <li><?php echo $this->Html->link('<i class="md md-create"></i>&nbsp Editar', 'javascript: void(0)', array("escape" => false, 'id' => $v['GelPessoa']['id'], 'class' => 'btnEditar')) ?></li>
                                            <li><?php echo $this->Html->link('<i class="md md-delete"></i>&nbsp Excluir', 'javascript: void(0)', array("escape" => false, 'id' => $v['GelPessoa']['id'], 'class' => 'btnDeletar')) ?></li>
                                            <li style="background: #F1F1F1; font-size: 9px; text-align: center;">Atualizado em: <?php echo @$v['GelPessoa']['modified'] ?></li>
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