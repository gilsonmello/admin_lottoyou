<section id="AppRestrito">
    <div class="section-body card">
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-vpn-key" style="margin-bottom:0;"></i> Acesso Restrito 
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b>Configurações de E-mail</b>
            </header>
        </div>
        
        <div class="card-body tab-content">
            <div id="tab1" class="tab-pane active"> 
                <div id="gridFuncionalidades">
                    <h4>Templates para envio de e-mail</h4>
                    <hr style="margin-left: 5px;"/>

                    <?php foreach ($dadosFuncionalidades['records'] as $modulo => $records) { ?>
                    <h4 style="padding-left: 5px;cursor:pointer;"><label class="label label-primary" style="text-transform:uppercase;">Módulo: <?php echo $modulo; ?></label> <i id="<?php echo $records[0]['modulo_id'] ?>" class="fa fa-edit editModulos"></i></h4> 
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