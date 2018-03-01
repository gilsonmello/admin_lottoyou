<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-edit"></i> Cadastrar iamgem do Clube')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">

        <div class="col-md-2">
            <div class="pull-left width-3 clearfix hidden-xs">
                <?php
                $photo = !empty($dados['SocCategoria']) ? $dados['SocCategoria']['imagem_capa'] : '';
                $file = (is_file('img/soccer-expert/categoria/' . $photo)) ? $photo : 'default.png';
                ?>
                <img class="img-circle size-2" src="<?php echo $this->Html->url('../img/soccer-expert/categoria/' . $file) ?>" alt="">
            </div>
        </div>

        <div class="col-lg-offset-2 col-md-8">
            <div class="card">
                <div class="card-body no-padding">

                    <?php echo $this->Form->create('SocCategoria', array('class' => 'form-validate dropzone', 'role' => 'form')); ?>
                    <div class="dz-message">
                        <h3>Solte os arquivos aqui ou clique para carregar.</h3>
                        <em>(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</em>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div><!--end .card-body -->
            </div><!--end .card -->
        </div><!--end .col -->
    </div><!--end .row -->   
</div>
<?php echo $this->element('formsButtons') ?>