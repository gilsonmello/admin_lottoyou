<ul class="header-nav header-nav-profile" style="margin-right: 23px;">
    <li class="dropdown">
        <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
            <?php
            $photo = $this->Session->read('Auth.User.photo');
            $photoSocial = $this->Session->read('Auth.User.RedesUser');
            if (empty($photoSocial[0])) {
                $file = (is_file('img/avatar/' . $photo)) ? $photo : 'default.png';
                ?>
                <img src="<?php echo $this->Html->url('../img/avatar/' . $file) ?>" alt="" />
            <?php } else { ?>
                <img src="<?php echo $photoSocial[0]['picture'] ?>" alt="" />                
            <?php } ?>
            <span class="profile-info">
                <?php echo $this->Session->read('Auth.User.name'); ?>
                <small><?php echo $this->Session->read('Auth.User.grupo'); ?></small>
            </span>
        </a>
        <ul id="header-menu" class="dropdown-menu animation-dock">
            <li class="dropdown-header">Minha conta</li>
            <li><?php echo $this->Html->link('Alterar dados pessoais', array('controller' => 'users', 'action' => 'profile'), array('requestJS' => 'AppProfile')) ?></li>
            <?php if($this->Session->read("Auth.User.group_id") == 1) {?>
            <li class="dropdown-header">Configurações</li>
            <li><?php echo $this->Html->link('Gerenciar empresas', array('controller' => 'users', 'action' => 'profile')) ?></li>
            <li><?php echo $this->Html->link('Gerenciar usuários', array('controller' => 'users'), array('requestJS' => 'AppUsers')) ?></li>
            <?php } ?>
            <li class="divider"></li>
            <li><?php echo $this->Html->link('<i class="fa fa-fw fa-lock"></i> Bloquear tela', array('controller' => 'users', 'action' => 'lock'), array('escape' => false, 'modal'=>1)) ?></li>
            <li><?php echo $this->Html->link('<i class="fa fa-fw fa-power-off text-danger"></i> Sair do sistema', array('controller' => 'users', 'action' => 'logout'), array('class' => 'sair', 'escape' => false)) ?></li>
        </ul><!--end .dropdown-menu -->
    </li><!--end .dropdown -->
</ul><!--end .header-nav-profile -->