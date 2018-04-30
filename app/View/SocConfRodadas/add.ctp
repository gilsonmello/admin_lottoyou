<?php echo $this->Form->create('SocConfRodada', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR Configuração')); ?>
<?= $this->Form->hidden('soc_rodada_id', ['value' => $socRodadaId]); ?>
<?= $this->Form->hidden('id', ['value' => $id]); ?>
<div class="card-body">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <h3>Apostando que o jogo terá um vencedor</h3>
            <div class="row">
                <div class="col-sm-3 col-lg-6 col-md-3 col-xs-12">
                    <div class="form-group">                
                        <?php echo $this->Form->input('nao_acertar_vencedor_jogo', [
                            'label' => 'Não acertar o vencedor do jogo', 
                            'class' => 'form-control decimal'
                        ]); ?>
                    </div>
                </div>
                <div class="col-sm-3 col-lg-6 col-md-3 col-xs-12">
                    <div class="form-group">                
                        <?php echo $this->Form->input('acertar_vencedor_jogo', [
                            'label' => 'Acertar o vencedor do jogo', 
                            'class' => 'form-control decimal'
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="row">                
                <div class="col-sm-3 col-lg-7 col-md-3 col-xs-12">
                    <div class="form-group">                
                        <?php echo $this->Form->input('acertar_jogo_e_diferenca_gols', [
                            'label' => 'Acertar, alem do vencedor do jogo, a diferença de gols', 
                            'class' => 'form-control decimal'
                        ]); ?>
                    </div>
                </div>
                <div class="col-sm-3 col-lg-5 col-md-3 col-xs-12">
                    <div class="form-group">                
                        <?php echo $this->Form->input('acertar_placar', [
                            'label' => 'Acertar o placar exato', 
                            'class' => 'form-control decimal'
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
            <h3>Apostando que o jogo terminará empatado</h3>
            <div class="row">
                <div class="col-sm-3 col-lg-6 col-md-3 col-xs-12">
                    <div class="form-group">                
                        <?php echo $this->Form->input('empate_com_vencedor', [
                            'label' => 'Apostou no empate, porém o jogo teve um vencedor', 
                            'class' => 'form-control decimal'
                        ]); ?>
                    </div>
                </div>
                <div class="col-sm-3 col-lg-6 col-md-3 col-xs-12">
                    <div class="form-group">                
                        <?php echo $this->Form->input('acertar_empate_sem_exatidao', [
                            'label' => 'Acertar o empate, porem sem ser exato', 
                            'class' => 'form-control decimal'
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-lg-3">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'), 'value' => '1')); ?>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>