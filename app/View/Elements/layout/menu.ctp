<div id="menubar" class="menubar-inverse animate">

    <div class="menubar-scroll-panel">

        <!-- BEGIN MAIN MENU -->
        <ul id="main-menu" class="gui-controls">
            <?php echo $this->Menu->link('Dashboard', '/gelDashboard/', array('icon' => 'fa fa-line-chart', 'requestJS' => 'AppDashboard')); ?>

            <?php echo $this->Menu->link('Raspadinha', '/raspadinhas/', array('icon' => 'md md-view-quilt', 'requestJS' => 'AppRaspadinhas')); ?>


            <?php echo $this->Menu->link('Loteria', '/lotUserJogos/', array('icon' => 'md md-language', 'requestJS' => 'AppLotUserJogos')); ?>

            <?php echo $this->Menu->link('Soccer expert', '/socJogos/', array('icon' => 'md md-security', 'requestJS' => 'AppSocJogos')); ?>

            <?php if ($this->Session->read('Auth.User.group_id') == 1) { ?>
                <?php echo $this->Menu->link('Cadastros', '/gelCadastros/', array('icon' => 'fa md-data-usage', 'requestJS' => 'AppGelCadastros')); ?>
            <?php } ?>

            <?php echo $this->Menu->link('Configurações', '/sisConfiguracoes/', array('icon' => 'glyphicon glyphicon-cog', 'requestJS' => 'AppSisConfiguracoes')); ?>

        </ul>
        <!-- END MAIN MENU -->
    </div>
</div>