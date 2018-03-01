<section id="AppGelEmpresas" <?php echo ($modal == 1)? 'style="padding:0;"' : '' ?>>
    <div class="section-body" <?php echo ($modal == 1)? 'style="margin:0;"' : '' ?>>
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-apps" style="margin-bottom:0;"></i> <b>Minhas Empresas</b>
            </header>
            <div class="tools">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top:14px;"><span aria-hidden="true">&times;</span></button>
            </div>
        </div>

        <div class="card card-collapsed" style="margin-bottom: 0;">
            <div class="card-head card-head-sm" style="border-bottom:1px solid #f2f3f3;">
                <header class="" style="font-weight:normal;text-transform:none;">
                    <i class="md md-info text-info" style="vertical-align: inherit;margin-top: -0.3em;"></i> 
                    Selecione a empresa que deseja trabalhar e clique em ENTRAR
                </header>
            </div>
            <div id="gridGelEmpresa" style="padding: 24px;">   

                <ul class="list" data-sortable="true">
                    <?php foreach ($dados as $k => $v) { ?>
                    <li class="tile" style="border-bottom: 1px solid #eeeeee;">
                        <div class="tile-text">
                            <button id="<?php echo $v['GelEmpresa']['id']; ?>" type="button" class="btn btn-primary pull-right" style="margin-top: 3px;">ENTRAR</button>
                            <span>
                                <?php echo $v['GelEmpresa']['nome']; ?> <label class="label label-<?php echo $v['GelEmpresa']['matriz_label']; ?>" style="font-size:10px;"><?php echo $v['GelEmpresa']['matriz_texto2']; ?></label>
                                <small style="font-size: 11px;"><?php echo $v['GelEmpresa']['cnpj']; ?></small>
                            </span>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="modal-footer" style="padding:14px 22px;">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin:0;">FECHAR</button>
            </div>
        </div>
    </div>
</section>