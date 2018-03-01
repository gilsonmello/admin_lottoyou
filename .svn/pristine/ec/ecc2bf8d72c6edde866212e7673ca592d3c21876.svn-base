<section id="AppRestrito" <?php echo ($modal == 1) ? 'style="padding:0;"' : '' ?>>
    <div class="section-body card" <?php echo ($modal == 1) ? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-extension" style="margin-bottom:0;"></i> Configurações 
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b>Permissões de Acesso</b>
            </header>
            <div class="tools">
                <button id="voltar" type="button" class="btn ink-reaction btn-flat btn-default-bright" data-dismiss="modal"><a href="javascript: history.go(-1])"><i class="fa fa-fw fa-arrow-left"></i> voltar</a></button>
            </div>
        </div>

        <div class="card-body tab-content">
            <div id="tab1" class="tab-pane active">	
                <div id="gridFuncionalidades">                
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="alert alert-callout alert-warning" role="alert" style="margin-left: 0px;">
                                <h4>
                                    Funcionalidades 
                                    <button id="addFuncionalidades" type="button" class="btn btn-xs btn-warning pull-right">Cadastrar</button>
                                </h4>
                                <hr style="margin:0 0 7px 0;"/>
                                <table style="width:100%;margin-bottom:0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th>Total</th>
                                        <th>Ativos</th>
                                        <th>Inativos</th>
                                        <th>Sem Permissão</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $dadosFuncionalidades['total']; ?></td>
                                        <td><?php echo $dadosFuncionalidades['ativo']; ?></td>
                                        <td><?php echo $dadosFuncionalidades['inativo']; ?></td>
                                        <td><?php echo $dadosFuncionalidades['semPermissao']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="alert alert-callout alert-info" role="alert" style="margin-left: 0px;">
                                <h4>
                                    Permissões
                                    <button id="addPermissoes" type="button" class="btn btn-xs btn-info pull-right">Atualizar Automaticamente</button>
                                </h4>
                                <hr style="margin:0 0 7px 0;"/>
                                <table style="width:100%;margin-bottom:0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th>Total</th>
                                        <th>Adicionar</th>
                                        <th>Remover</th>
                                        <th>Órfãs</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $dadosPermissions['total']; ?></td>
                                        <td><?php echo count($dadosPermissions['adicionar']); ?></td>
                                        <td><?php echo count($dadosPermissions['remover']); ?></td>
                                        <td><?php echo count($dadosPermissions['semVinculoComFuncionalidade']); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>               
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-lg-6">
                            <div class="alert alert-callout alert-danger" role="alert" style="margin-left: 0px;">
                                <h4>
                                    Módulos 
                                    <button id="listModulos" type="button" class="btn btn-xs btn-danger pull-right">GERIR</button>
                                </h4>
                                <hr style="margin:0 0 7px 0;"/>
                                <table style="width:100%;margin-bottom:0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th>Total</th>
                                        <th>Ativos</th>
                                        <th>Inativos</th>
                                        <th>Sem Funcionalidade</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $dadosModulos['total']; ?></td>
                                        <td><?php echo $dadosModulos['ativo']; ?></td>
                                        <td><?php echo $dadosModulos['inativo']; ?></td>
                                        <td><?php echo $dadosModulos['semFuncionalidade']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="alert alert-callout alert-success" role="alert" style="margin-left: 0px;">
                                <h4>
                                    Sessão 
                                    <button id="lock" type="button" class="btn btn-xs btn-success pull-right">REVALIDAR SESSÃO</button>
                                </h4>
                                <hr style="margin:0 0 7px 0;"/>
                                <table style="width:100%;margin-bottom:0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th>Último login</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $dadosUser['User']['last_login']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <hr style="margin-left: 0px;"/>

                    <?php foreach ($dadosFuncionalidades['records'] as $modulo => $records) { ?>
                        <h4 style="padding-left: 5px;cursor:pointer;"><label class="label label-<?php echo ($records[0]['modulo_active'] == 1) ? 'primary' : 'danger'; ?>" style="text-transform:uppercase;">Módulo: <?php echo $modulo; ?></label> <i id="<?php echo $records[0]['modulo_id'] ?>" class="fa fa-edit editModulos"></i></h4> 
                        <table class="table table-condensed table-hover" cellspacing="0" width="100%" style="">
                            <thead>
                                <tr>
                                    <th>Funcionalidade</th>
                                    <th class="text-center" style="width:150px;">Grupos Associadas</th>
                                    <th class="text-center" style="width:180px;">Permissões Associadas</th>
                                    <th style="width:100px;">Ativo</th>
                                    <th style="width:50px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($records as $v) { ?>
                                    <tr>
                                        <td><?php echo $v['name']; ?></td>
                                        <td class="text-center"><?php echo $v['totalGrupos']; ?></td>
                                        <td class="text-center"><?php echo $v['totalPermissoes']; ?></td>
                                        <td><label class="label label-<?php echo $v['ativo_label']; ?>"><?php echo $v['ativo']; ?></label></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                    <li><?php echo $this->Html->link('<i class="md md-create"></i>&nbsp Editar', 'javascript: void(0)', array("escape" => false, 'id' => $v['id'], 'class' => 'editFuncionalidades')) ?></li>
                                                    <li><?php echo $this->Html->link('<i class="md md-delete"></i>&nbsp Excluir', 'javascript: void(0)', array("escape" => false, 'id' => $v['id'], 'class' => 'delFuncionalidades')) ?></li>
                                                    <li style="background: #F1F1F1; font-size: 9px; text-align: center;">Atualizado em: <?php echo @$v['modified'] ?></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>				
            </div>
            <div id="tab2" class="tab-pane">						
            </div>
        </div>
    </div>
</section>