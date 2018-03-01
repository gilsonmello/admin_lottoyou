<?php echo $this->Form->create('GelPessoa', array('class' => 'form form-validate', 'role' => 'form')); ?>
<?php echo $this->element('forms/title', array('title' => '<i class="fa fa-edit"></i> EDITAR PESSOA')); ?>
<?php echo $this->Form->hidden('id'); ?>
<div class="card-body">
    <div class="row">
        <div class="col-md-8">
            <?php echo $this->Form->input('tipo_cadastro', array('type' => 'radio', 'legend' => 'Tipo de Cadastro', 'class' => 'radio-inline radio-styled tipo_pessoa', 'options' => $optionsTipoCadastro)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?php echo $this->Form->input('tipo_pessoa', array('type' => 'radio', 'legend' => 'Tipo de Pessoa', 'class' => 'radio-inline radio-styled tipo_pessoa', 'options' => array('PF' => 'Pessoa Física', 'PJ' => 'Pessoa Jurícica'))); ?>
        </div>
        <div class="col-sm-4">
            <div class="form-group pj">                
                <?php echo $this->Form->input('inscricao_estadual', array('label' => 'Inscrição Estadual', 'class' => 'form-control')); ?>
            </div>
        </div>
    </div>
    <div class="row second">
        <div class="col-sm-8">
            <div class="form-group">                
                <?php echo $this->Form->input('nome', array('label' => 'Nome', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">  
                <?php $cpf_cnpj = ($this->data['GelPessoa']['tipo_pessoa'] == 'PF') ? 'cpf' : 'cnpj'; ?>              
                <?php echo $this->Form->input('cpf_cnpj', array('label' => 'CPF', 'class' => 'form-control '.$cpf_cnpj)); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">                
                <?php echo $this->Form->input('apelido', array('label' => 'Apelido', 'class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php echo $this->Form->input('active', array('type' => 'radio', 'legend' => 'Ativo', 'class' => 'radio-inline radio-styled tipo', 'options' => array(1 => 'Sim', 0 => 'Não'))); ?>
        </div>
    </div>

    <!-- CONTATO -->
    <div class="panel-group" style="margin-bottom:5px">
        <div class="card panel" id="accordion1">
            <div class="card-head card-head-xs collapsed style-default-light" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-2" aria-expanded="false">
                <header>CONTATO</header>
                <div class="tools">
                    <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                </div>
            </div>
            <div id="accordion1-2" class="collapse" aria-expanded="false">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">                
                                <?php echo $this->Form->input('contato_email', array('label' => 'E-mail', 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">                
                                <?php echo $this->Form->input('contato_telefone', array('label' => 'Telefone', 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">                
                                <?php echo $this->Form->input('contato_celular', array('label' => 'Celular', 'class' => 'form-control')); ?>
                            </div>
                        </div>
                    </div>                               
                </div>
            </div>
        </div>
    </div>

    <!-- ENDEREÇO -->
    <div class="panel-group" style="margin-bottom:5px">
        <div class="card panel" id="accordion1">
            <div class="card-head card-head-xs collapsed style-default-light" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-1" aria-expanded="false">
                <header>Endereço</header>
                <div class="tools">
                    <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                </div>
            </div>
            <div id="accordion1-1" class="collapse" aria-expanded="false">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">                
                                <?php echo $this->Form->input('endereco_logradoro', array('label' => 'Endereço', 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">                
                                <?php echo $this->Form->input('endereco_numero', array('label' => 'Número', 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">                
                                <?php echo $this->Form->input('endereco_complemento', array('label' => 'Complemento', 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">                
                                <?php echo $this->Form->input('endereco_bairro', array('label' => 'Bairro', 'class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">                
                                <?php echo $this->Form->input('endereco_cep', array('label' => 'CEP', 'class' => 'form-control cep')); ?>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">                
                                <?php echo $this->Form->input('gel_estado_id', array('label' => 'Estado', 'class' => 'form-control chosen', 'options'=>$optionsGelEstados, 'empty'=>'Selecione')); ?>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group">                
                                <?php echo $this->Form->input('gel_cidade_id', array('label' => 'Cidade', 'class' => 'form-control chosen', 'options'=>$optionsGelCidades, 'empty'=>'Selecione')); ?>
                            </div>
                        </div>
                    </div>                                 
                </div>
            </div>
        </div>
    </div>

    <!-- OBSERVAÇÃO -->
    <div class="panel-group" style="margin-bottom:0">
        <div class="card panel" id="accordion1">
            <div class="card-head card-head-xs collapsed style-default-light" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-3" aria-expanded="false">
                <header>OBSERVAÇÃO</header>
                <div class="tools">
                    <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                </div>
            </div>
            <div id="accordion1-3" class="collapse" aria-expanded="false">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">                
                                <?php echo $this->Form->input('observacao', array('label' => 'Outras informações', 'class' => 'form-control', 'rows' => '2')); ?>
                            </div>
                        </div>
                    </div>                             
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('forms/buttons') ?>
<?php echo $this->Form->end(); ?>