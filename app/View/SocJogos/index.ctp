<script type="text/css">
    .ItemHolder {
        margin: 5px;
        padding: 0 15px 25px;
        background: #EFEFEF;
        color: black;
        border-radius: 5px;
        -webkit-transition: all .5s ease;
        -moz-transition: all .5s ease;
        -o-transition: all .5s ease;
        transition: all .5s ease;
        cursor: pointer;
    };

    .img_time{
        width: 25px;
    };

    .vcenter {
        display: flex;
        align-items: center;
    }
</script>
<section id="AppSocJogos">
    <div class="section-body" style="margin:0;">
        <div class="card-head card-head-sm style-primary">
            <header>
                <i class="md md-apps" style="margin-bottom:0;"></i> SOCCER EXPERT 
                <i class="md md-navigate-next" style="margin-bottom:0;"></i> <b>Jogos</b>
            </header>
        </div>
        <div class='row'>

            <div class="col-md-12">
                <div class="card card-underline">
                    <div class="card-head">
                        <ul class="nav nav-tabs pull-right" data-toggle="tabs">
                            <li class="active"><a href="#first22">JOGOS DISPONIVEIS</a></li>
                            <li><a href="#second22">MEUS JOGOS</a></li>
                        </ul>
                        <header>LOTTOYOU</header>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane active" id="first22">
                            <div class="row" id='divCategoria'>
                                <?php foreach ($dadosCategorias as $key => $value) { ?>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="game ItemHolder card-raspadinha card" style="padding-top: 8px;">
                                            <span class="ng-scope" style="position: absolute;">
                                                <?php echo ($value['SocCategoria']['novo'] == 1) ? $this->Html->image('../img/raspadinha/novo.png', array('class' => 'game-badge', 'style' => 'margin-left: -5px;')) : ''; ?>
                                            </span>
                                            <div class="game-header">
                                                <?php echo $this->Html->image($this->Html->url('/').$value['SocCategoria']['imagem_capa'], array('class' => 'header-image', 'alt' => 'Capa', 'style' => 'height: 150px; width: 100%;')) ?>
                                                <div style="width: 100%; text-align: center; padding: 4px; background-color: #2FB9E3;">
                                                    <!--<p style="font-size: 14px; color: white;"><b><?php echo $value['SocCategoria']['texto_index']; ?></b></p>-->
                                                </div>
                                                <div style="width: 100%;  padding: 12px; background-color: #0F546D;">
                                                    <a class="" style="font-size: 14px; color: white; margin-left: 0px !important;"><i class="fa fa-money" aria-hidden="true" style="margin-right: 8px;"></i><b><?php echo $value['SocCategoria']['nome'] ?></b></a>
                                                </div>
                                                <div class="descript">
                                                    <div class="row">
                                                        <div class="col-sm-12" style="text-align: center">
                                                            <?php echo $this->Html->link('<i class="md md-swap-vert-circle"></i>&nbsp;&nbsp;Jogar ', 'javascript: void(0);', array('id' => $value['SocCategoria']['id'], 'class' => 'btn ink-reaction btn-raised btn-primary jogarCategoria', 'escape' => false, 'style' => 'font-si/ze: 10px; width: 100%;')) ?><br/>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div id="gridSocJogos" style="padding: 15px; display: none" class="col-sm-12" >
                                <!--<div class="row">-->
                                <?php foreach ($dados as $k => $v) { ?>
                                    <div class="col-md-4">
                                        <div class="card card-underline">
                                            <div class="card-head">
                                                <header><?php echo $v['SocRodada']['nome'] ?> - $ <?php echo $v['SocRodada']['valor'] ?></header>
                                                <div class="tools">
                                                    <div class="btn-group">
                                                        <a class="btn btn-icon-toggle btn-collapse"><i class="fa fa-angle-down"></i></a>
                                                    </div>
                                                </div>                                                
                                            </div><!--end .card-head -->
                                            <div class="card-body" style="display: block;">
                                                <div class="row">
                                                    <div style="text-align: center; font-weight: bold"><?php echo $v['SocRodada']['qtd_apostas'] ?> <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Quantidade de Jogadores"></i> / <?php echo!empty($v['SocRodada']['limite']) ? $v['SocRodada']['limite'] : 100 ?> <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Quantidade de limite"></i></div>
                                                    <?php
                                                    if ($v['SocRodada']['categoria_name'] == 'ESPECIAL') {
                                                        $c = 'success';
                                                    } else if ($v['SocRodada']['categoria_name'] == 'WOLD') {
                                                        $c = 'info';
                                                    } else {
                                                        $c = 'danger';
                                                    }
                                                    ?>
                                                    <div class="alert alert-<?php echo $c ?>" style="text-align: center; font-weight: bold"><?php echo $v['SocRodada']['categoria_name'] ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 well well-sm" style="font-size: 11px">
                                                        <?php if (!empty($v['SocJogo'])) { ?>
                                                            <?php foreach ($v['SocJogo'] as $k => $vl) { ?>
                                                                <?php // echo $this->Form->hidden('soc_jogo_id', array('value' => ));?>
                                                                <div class="row vcenter">
                                                                    <!--end .col -->
                                                                    <div class="col-xs-12 col-md-5 col-lg-5">
                                                                        <!--<div class="form-group">-->
                                                                            <div class="input-group">
                                                                                <div class="input-group-content"  style="text-align: right">
                                                                                    <label><?php echo @$vl['nome_clube_casa'] ?></label>
                                                                                </div>
                                                                                <span class="input-group-addon">
                                                                                    <img class="img_time text-center" style="width: 25px;" src="/<?php echo @$vl['escudo_clube_casa'] ?>"/>
                                                                                </span>
                                                                            </div>
                                                                        <!--</div>-->
                                                                    </div><!--end .col -->

                                                                    <div class="col-xs-2 col-md-2 col-sm-2 col-lg-2" style="text-align: center">
                                                                        x
                                                                    </div><!--end .col -->

                                                                    <div class="col-xs-10 col-md-5 col-lg-5">
                                                                        <!--<div class="form-group">-->
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon"  style="text-align: left">
                                                                                    <img class="img_time text-center" style="width: 25px;" src="/<?php echo @$vl['escudo_clube_fora'] ?>"/>
                                                                                </span>                                                                            
                                                                                <div class="input-group-content">
                                                                                    <label><?php echo @$vl['nome_clube_fora'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        <!--</div>-->
                                                                    </div><!--end .col -->
                                                                </div><!--end .row  -->
                                                                    <hr style="margin-top: 0px; margin-bottom: 0px;" />
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    Não há Jogos Cadastrados
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <?php echo $this->Html->link('<i class="md md-swap-vert-circle"></i>&nbsp;&nbsp;Jogar', 'javascript: void(0);', array('id' => $v['SocRodada']['id'], 'class' => 'btn ink-reaction btn-raised btn-primary btnApostar', 'escape' => false, 'style' => 'font-si/ze: 10px; width: 100%;')) ?><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <?php echo $this->Html->link('<i class="fa fa-external-link-square"></i>&nbsp;&nbsp;Atualizar', 'javascript: void(0);', array('id' => $v['SocRodada']['id'], 'class' => 'btn ink-reaction btn-raised btn-danger btnEdit', 'escape' => false, 'style' => 'font-siz/e: 10px; width: 100%;')) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end .card-body -->
                                        <em class="text-caption">Termina em: <?php echo $v['SocRodada']['data_termino'] ?> às <?php echo $v['SocRodada']['hora_termino'] ?> hrs</em>
                                    </div><!--end .card -->
                                    <!--</div>-->
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="second22">
                            <div id="gridSocJogosFeitos" style="padding: 15px;" class="col-sm-12">
                                <?php foreach ($meusDados as $k => $v) { ?>
                                    <div class="col-md-4">
                                        <div class="card card-underline">
                                            <div class="card-head">
                                                <header><?php echo $v['SocRodada']['nome'] ?></header>
                                                <div class="tools">
                                                    <div class="btn-group">
                                                        <a class="btn btn-icon-toggle btn-collapse"><i class="fa fa-angle-down"></i></a>
                                                    </div>
                                                </div>
                                            </div><!--end .card-head -->
                                            <div class="card-body" style="display: block;">
                                                Breve descrição .
                                                <?php echo $this->Html->link('<i class="md md-swap-vert-circle"></i> Exibir', 'javascript: void(0);', array('id' => $v['SocRodada']['id'], 'class' => 'btn ink-reaction btn-raised btn-info pull-right btnMeuJogo', 'user_id' => $this->Session->read('Auth.User.id'), 'escape' => false)) ?>
                                            </div><!--end .card-body -->
                                        </div><!--end .card -->
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div><!--end .card -->
                <em class="text-caption">Right aligned tabs</em>
            </div>
        </div>
    </div>
</section>