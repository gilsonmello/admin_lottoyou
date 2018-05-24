<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Lista de assertos ')); ?>
<div class="section-body" <?php echo!empty($modal) ? 'style="margin:0;"' : '' ?>>
    <?php if (!empty($dados['LotJogosResultado']['id'])) { ?>
        <div class="card-body card-collapsed" style="min-height:">
            <div class="row card card-outlined" >
                
            </div>
            <div class="card card-outlined style-default-dark ">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group" style="margin: 8px;">
                        <label style="font-size: 16px;"><b><?php echo!empty($dados['LotJogo']['sorteio']) ? $dados['LotJogo']['sorteio'] : ''; ?></b></label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group" style="margin: 8px;">
                        <label class="label label-success">Concurso:</label>&nbsp;<b><?php echo $dados['LotJogo']['concurso']; ?></b>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group" style="margin: 8px;">
                        <label class="label label-success">Sorteado: </label>&nbsp; <b> <?php echo $dados['LotJogosResultado']['concurso_data']; ?></b>
                    </div>
                </div>
                <table id=""
                       class="table table-condensed table-bordered" 
                       cellspacing="" 
                       width=""
                       style="padding:10px;">
                    <thead>
                        <tr>
                            <th>Quantidade de acertos</th>
                            <th>Quantidade de jogadores</th>
                            <th style="width:50px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lotUserJogos as $k => $v) { ?>
                            <tr>
                                <td style="padding-left: 12px"><?php echo $v['LotUserJogo']['num_acerto']; ?></td>
                                <td style="padding-left: 12px"><?php echo $v[0]['contador']; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            <li>
                                                <?=
                                                    $this->Html->link(
                                                        '<i class="md md-view-headline"></i>&nbsp Detalhar',
                                                        'javascript: void(0)',
                                                        [
                                                            "escape" => false,
                                                            'id' => $v['LotUserJogo']['lot_jogo_id'],
                                                            'acertos'=> $v['LotUserJogo']['num_acerto'],
                                                            'class' => 'btnDetalhar'
                                                        ]
                                                    )
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    <?php } else { ?>
        <div class="card-body card-collapsed style-gray-dark" >
            <div class="row" style="min-height:300px; padding-top: 100px;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <center>
                        <h1 class="text-warning">Resultado ainda não cadastrado!</h1>
                    </center>
                </div>
            </div>
        </div>

    <?php } ?>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin:0;">FECHAR</button>
</div>