<section id="AppProfile">
    <div class="section-body card">
        <!-- BEGIN CONTACT DETAILS HEADER -->
        <div class="card-head card-head-sm style-primary">
            <div class="tools pull-left">
                <div class="btn btn-flat" style="cursor:default;margin-left:21px;">
                    <span class="md md-person"></span>&nbsp;Alterar dados pessoais
                </div>
            </div>
        </div>

        <div class="card-tiles">
            <div class="hbox-md col-md-12">
                <div class="hbox-column col-md-9">
                    <div class="row">

                        <!-- BEGIN CONTACTS MAIN CONTENT -->
                        <div class="col-sm-10 col-md-11 col-lg-12" id="gridUser">
                            <div class="margin-bottom-xxl">
                                <div class="pull-left width-3 clearfix hidden-xs">
                                    <?php
                                    $photo = $this->Session->read('Auth.User.photo');
                                    $photoSocial = $this->Session->read('Auth.User.RedesUser');
                                    if (empty($photoSocial[0])) {
                                        $file = (is_file('img/avatar/' . $photo)) ? $photo : 'default.png';
                                        ?>
                                        <img class="img-circle size-2" src="<?php echo $this->Html->url('../img/avatar/' . $file) ?>" alt="">
                                    <?php } else { ?>
                                        <img class='img-circle size-2' src="<?php echo $photoSocial[0]['picture'] ?>" alt=''>
                                    <?php } ?>
                                </div>
                                <h1 class="text-light no-margin"><?php echo $this->data['User']['name']; ?></h1>
                                <h5 style="margin-top:4px;margin-bottom:2px;">&nbsp;Perfil de  Acesso: <?php echo $this->data['Group']['name']; ?></h5>
                                <h5 id="btnAlterarFoto" class="hidden-xs" style="margin-top:4px;margin-bottom:2px;">&nbsp;
                                    <label 
                                        title="Selecione uma imagem..." 
                                        data-toggle="popover" 
                                        data-placement="bottom" 
                                        data-content='
                                            <?php echo $this->Form->create('User', array('action'=>'change_photo','id'=>'UserProfileForm3','class' => 'dropzone', 'enctype'=>'multipart/form-data')); ?>
                                            <div class="md md-photo-camera" style="font-size: 500%; padding-left: 41px; padding-right: 41px;cursor:pointer;">
                                            </div>
                                            <?php echo $this->Form->end(); ?>' 
                                        class="label label-default" 
                                        style="cursor:pointer;">Alterar foto</label>
                                </h5>
                                &nbsp;&nbsp;
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-head card-head-xs">
                                            <header>Meu Cadastro</header>
                                        </div>
                                        <div class="card-body style-default-light">
                                            <?php echo $this->Form->create('User', array('class' => 'form form-validate', 'role' => 'form')); ?>
                                            <?php echo $this->Form->hidden('id'); ?>
                                            <?php echo $this->Form->hidden('active'); ?>
                                            <div style="margin-top:20px;"></div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('name', array('label' => 'Primeiro e último nome', 'class' => 'form-control')); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('username', array('label' => 'E-mail', 'class' => 'form-control')); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('cpf', array('label' => 'CPF', 'class' => 'form-control cpf')); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group ">
                                                        <div class="input-group">
                                                            <div class="input-group-content">
                                                                <?php echo $this->Form->input('born', array('type' => '', 'label' => 'Data Nascimento', 'placeholder' => 'dd/mm/yyyy', 'data-bv-format' => 'dd/mm/yyyy', 'class' => 'date form-control', 'div' => false)); ?>
                                                            </div>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('fixo', array('label' => 'Telefone Fixo', 'class' => 'form-control telefone')); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('celular', array('label' => 'Celular', 'class' => 'form-control telefone')); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('cep', array('label' => 'CEP', 'class' => 'form-control cep')); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('address', array('type' => 'text', 'label' => 'Endereço Residencial', 'class' => 'form-control')); ?>
                                                    </div>
                                                </div>
                                                <?php if($this->request->data['User']['group_id'] != 1){ ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">                
                                                        <?php echo $this->Form->input('group_id', array('label' => 'Grupo', 'class' => 'form-control chosen', 'options' => $grupos)); ?>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('vencimento_habilitacao', array('type' => '', 'label' => 'Venc. Habilitação', 'placeholder' => 'dd/mm/yyyy', 'data-bv-format' => 'dd/mm/yyyy', 'class' => 'date form-control', 'div' => false)); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('key', array('type' => '', 'label' => 'Chave de segurança', 'placeholder' => 'Sua chave de segurança', 'class' => 'form-control', 'div' => false, 'required' => true)); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="pull-right btn btn-primary btn-loading-state" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando...">SALVAR</button>
                                            <?php echo $this->Form->end(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-head card-head-xs">
                                            <header>Senha de Acesso</header>
                                        </div>

                                        <div class="card-body style-default-light">
                                            <?php echo $this->Form->create('User', array('id' => 'UserProfileForm2', 'class' => 'form form-validate', 'role' => 'form', 'autocomplete' => 'off')); ?>
                                            <?php echo $this->Form->hidden('id'); ?>
                                            <div style="margin-top:20px;"></div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('atual', array('type' => 'password', 'label' => 'Senha Atual', 'value' => '', 'placeholder' => 'Informe sua senha atual', 'data-bv-notempty' => 'true', 'class' => 'form-control', 'autocomplete' => 'false')); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('password', array('type' => 'password', 'label' => 'Nova Senha', 'placeholder' => 'Informe uma senha nova', 'data-bv-notempty' => 'true', 'data-bv-identical' => 'true', 'data-bv-identical-field' => 'data[User][confirmacao]', 'data-bv-identical-message' => 'Nova Senha e Confirme a Senha devem ser iguais', 'class' => 'form-control', 'autocomplete' => 'false')); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <?php echo $this->Form->input('confirmacao', array('type' => 'password', 'label' => 'Confirme a Senha<span style="color:red;">*</span>', 'placeholder' => 'Confirme a nova senha informada', 'data-bv-notempty' => 'true', 'data-bv-identical' => 'true', 'data-bv-identical-field' => 'data[User][password]', 'data-bv-identical-message' => 'Nova Senha e Confirme a Senha devem ser iguais', 'class' => 'form-control', 'autocomplete' => 'false')); ?>
                                                    </div>                                         
                                                </div>  
                                            </div>

                                            <button type="submit" class="pull-right btn btn-primary btn-loading-state" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processando...">SALVAR</button>
                                            <?php echo $this->Form->end(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>