<?= $this->element('forms/title', [
    'title' => '<i class="fa fa-edit"></i> Cadastrar Imagem de Fundo'
]); ?>
<?= $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-md-4 col-lg-3">
            <?php
                $photo = !empty($dados['SocCategoria']) ? $dados['SocCategoria']['imagem_capa'] : '';
                $file = (is_file($photo)) ? $photo : 'default.png';
            ?>
            <img class="img-circle size-2 img-responsive" src="<?= $this->Html->url('/' . $file) ?>" alt="">
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="card">
                <div class="card-body no-padding">
                    <?= $this->Form->create('SocCategoria', [
                        'class' => 'form-validate dropzone', 
                        'role' => 'form'
                    ]); ?>
                        <div class="dz-message">
                            <h3>Solte os arquivos aqui ou clique para carregar.</h3>
                            <em>(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</em>
                        </div>
                    <?= $this->Form->end(); ?>
                </div><!--end .card-body -->
            </div><!--end .card -->
        </div><!--end .col -->
    </div><!--end .row -->   
</div>
<?= $this->element('formsButtons') ?>