<?php echo $this->Form->create('RasLotesNumero', array('class' => 'form form-validate', 'role' => 'form', 'enctype' => "multipart/form-data")); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-plus-square"></i> Gerar Prêmio')); ?>
<style type="text/css">
    .linha {
        margin-bottom: 10px;
    }
</style>
<div class="card-body">
    <?php if(count($numeros) > 0 && count($numeros) >= 5) { ?>
        <?php foreach($numeros as $key => $numero) { ?>
            <input type="hidden" name="data[RasLotesNumero][<?php echo $key; ?>][ras_lote_id];" value="<?php echo $numero['RasLotesNumero']['ras_lote_id']; ?>">
            <input type="hidden" name="data[RasLotesNumero][<?php echo $key; ?>][id]" value="<?php echo $numero['RasLotesNumero']['id']; ?>">
            
            <div class="row linha linha-<?php echo $key; ?>">
                <div class="col-lg-3">
                    <div class="form-group">
                        <input value="<?php echo $numero['RasLotesNumero']['number']; ?>" name="data[RasLotesNumero][<?php echo $key; ?>][number]" class="numbers form-control money" type="text" id="RasLoteNumber[0]" style="text-align: left;">
                        <label for="RasLoteNumber[<?php echo $key; ?>]">Número</label>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="btn-group">
                        <span class="btn btn-success fileinput-button" style="margin: 8px;">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Imagem</span>
                            <input id="fileupload" data-line="<?php echo $key; ?>" class="img" type="file" name="data[RasLotesNumero][<?php echo $key; ?>][img]">
                        </span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <span class="img-name"></span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <img src="<?php echo BASE . '/'. $numero['RasLotesNumero']['img']; ?>" class="img-responsive img-target" style="height: 100px;width: 100px;">
                </div>
                <div class="col-lg-1">
                    <span class="btn remover-numero" data-line=".linha-<?php echo $key; ?>" data-id="<?php echo $numero['RasLotesNumero']['id']; ?>"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
            </div>
        <?php } ?>
    <?php } else if(count($numeros) > 0 && count($numeros) < 5) { ?>
        <?php foreach($numeros as $key => $numero) { ?>
            <input type="hidden" name="data[RasLotesNumero][<?php echo $key; ?>][ras_lote_id];" value="<?php echo $numero['RasLotesNumero']['ras_lote_id']; ?>">
            <input type="hidden" name="data[RasLotesNumero][<?php echo $key; ?>][id]" value="<?php echo $numero['RasLotesNumero']['id']; ?>">
            
            <div class="row linha linha-<?php echo $key; ?>">
                <div class="col-lg-3">
                    <div class="form-group">
                        <input value="<?php echo $numero['RasLotesNumero']['number']; ?>" name="data[RasLotesNumero][<?php echo $key; ?>][number]" class="numbers form-control money" type="text" id="RasLoteNumber[0]" style="text-align: left;">
                        <label for="RasLoteNumber[<?php echo $key; ?>]">Número</label>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="btn-group">
                        <span class="btn btn-success fileinput-button" style="margin: 8px;">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Imagem</span>
                            <input id="fileupload" data-line="<?php echo $key; ?>" class="img" type="file" name="data[RasLotesNumero][<?php echo $key; ?>][img]">
                        </span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <span class="img-name"></span>
                    </div>
                </div>
                <div class="col-lg-2">
                    <img src="<?php echo BASE . '/'. $numero['RasLotesNumero']['img']; ?>" class="img-responsive img-target" style="height: 100px;width: 100px;">
                </div>
                <div class="col-lg-1">
                    <span class="btn remover-numero" data-line=".linha-<?php echo $key; ?>" data-id="<?php echo $numero['RasLotesNumero']['id']; ?>"><i class="glyphicon glyphicon-minus"></i></span>
                </div>
            </div>
        <?php } ?>
        <?php $key = count($numeros); for($i = 0; $i < 5 - count($numeros); $i++) { ?>
                <div class="row linha linha-<?php echo $key; ?>">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input name="data[RasLotesNumero][<?php echo $key; ?>][number]" class="numbers form-control money" type="text" id="RasLoteNumber[<?php echo $key; ?>]" style="text-align: left;">
                            <label for="RasLoteNumber[<?php echo $key; ?>]">Número</label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="btn-group">
                            <span class="btn btn-success fileinput-button" style="margin: 8px;">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Imagem</span>
                                <input id="fileupload" data-line="<?php echo $key; ?>" class="img" type="file" name="data[RasLotesNumero][<?php echo $key; ?>][img]">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <span class="img-name"></span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <img src="" class="img-responsive img-target" style="height: 100px;width: 100px;">
                    </div>
                </div>
            <?php $key++; } ?>
    <?php } else { ?>
            <?php for($i = 0; $i < 5; $i++) { ?>
                <div class="row linha linha-<?php echo $i; ?>">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <input name="data[RasLotesNumero][<?php echo $i; ?>][number]" class="numbers form-control money" type="text" id="RasLoteNumber[<?php echo $i; ?>]" style="text-align: left;">
                            <label for="RasLoteNumber[<?php echo $i; ?>]">Número</label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="btn-group">
                            <span class="btn btn-success fileinput-button" style="margin: 8px;">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Imagem</span>
                                <input id="fileupload" data-line="<?php echo $i; ?>" class="img" type="file" name="data[RasLotesNumero][<?php echo $i; ?>][img]">
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <span class="img-name"></span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <img src="" class="img-responsive img-target" style="height: 100px;width: 100px;">
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    <div class="row">
        <div class="col-lg-12">
            <a href="javascript: void(0)" class="btn btn-success btn-md adicionar-numero">Adicionar Número</a>
        </div>
    </div>
</div>
<?php echo $this->element('formsButtons') ?>
<?php echo $this->Form->end(); ?>