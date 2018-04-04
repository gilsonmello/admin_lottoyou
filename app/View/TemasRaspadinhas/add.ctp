<?php
echo $this->Form->create('TemasRaspadinha', array("class" => 'form form-validate', 'role' => 'form'));
echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> CADASTRAR TEMA'));
?>

<style>
    .bar {
        height: 18px;
        background: green;
    }
</style>
<div class="card-body">
    <div class="col-sm-12" >
        <div class="row">
            <div class="col-sm-4" >
                <div class="form-group">   
                    <?php echo $this->Form->input("nome", array('label' => 'Nome do Tema:', 'class' => 'form-control')) ?>
                </div>     
            </div>  
            <div class="col-sm-4" >
                <div class="form-group">   
                    <?php echo $this->Form->input("value", array('label' => 'Valor', 'class' => 'form-control money')) ?>
                </div>     
            </div> 
            <div class="col-sm-4" >
                <?php echo $this->Form->input('ativo', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled', 'options' => array(1 => 'Sim', 0 => 'Não'), 'value' => '1')); ?>
            </div>   
        </div>    
    </div>    
    <div class="col-sm-12" >
        <div class="form-group">   
            <?php echo $this->Form->input("texto_raspadinha", array('label' => 'Texto da Raspadinha:', 'class' => 'form-control', 'rows' => 2)) ?>
        </div>
    </div> 
    <div class="col-sm-4" >
        <div class="form-group">   
            <?php echo $this->Form->input("cor_texto_raspadinha", array('label' => 'Cor do Texto:', 'id' => 'teste2', 'class' => 'form-control')) ?>
        </div>  
    </div>  
    <div class="col-sm-4" >
        <div class="form-group">   
            <?php echo $this->Form->input("texto_index", array('label' => 'Texto do Index:', 'class' => 'form-control')) ?>
        </div>  
    </div> 
    <div class="col-sm-4" >
        <?php echo $this->Form->input('novo', array('type' => 'radio', 'legend' => 'Novo', 'class' => 'radio-inline radio-styled', 'options' => array(1 => 'Sim', 0 => 'Não'), 'value' => '1')); ?>
    </div>  
    <div class="row" style="text-align: center;">
        <div class="btn-group">
            <span class="btn btn-success fileinput-button" style="margin: 8px;">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Background</span>
                <input id="fileupload" type="file" name="files[]">
            </span>
            <span class="btn btn-success fileinput-button" style="margin: 8px;">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Capa</span>
                <input id="fileupload2" type="file" name="files[]">
            </span>
            <span class="btn btn-success fileinput-button" style="margin: 8px;">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Imagem Index.</span>
                <input id="fileupload3" type="file" name="files[]">
            </span>
        </div>

        <!--        <div class="col-sm-4">
        
                </div>
                <div class="col-sm-4">
                    <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Capa</span>
                        <input id="fileupload2" type="file" name="files[]">
                    </span>
                </div>
                <div class="col-sm-4">
                    <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Imagem Index.</span>
                        <input id="fileupload3" type="file" name="files[]">
                    </span>
                </div>-->
    </div>
    <div class="row" style="text-align: center;">
        <p><b>Background (900 x 600)</b> somente suporta imagem do tipo <b>.JPG(JPEG)</b> </p>
        <p><b>Capa (128 x 128)</b> e a <b>Imagem do Index (307 x 150)</b> só suportam <b>.PNG</b></p>
        <p>Tamanho máximo da imagem de  <b>5 megabytes</b></p>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary btn-loading-state" id="btnSalvar" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando...">Salvar</button>
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin:0;">FECHAR</button>

</div>

<?php echo $this->Form->end(); ?> 