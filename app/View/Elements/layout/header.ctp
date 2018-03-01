<?php $company = $this->Session->read('Auth.Company'); ?>
<header id="header" >
    <div class="headerbar">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="headerbar-left">
            <ul class="header-nav header-nav-options">
                <li class="header-nav-brand" >
                    <div class="brand-holder">
                        <?php echo $this->Html->link('LOTTO<span style="color:#f25d4f">YOU</span>', '/dashboard', array('style'=>'color: rgb(0, 0, 0); font-family: &quot;Oswald&quot;; transition: all 0.2s ease-in-out 0s; letter-spacing: 1px;', 'class'=>'text-lg text-bold','escape' => false, 'title' => Configure::read('Sistema.nome'))); ?>
                    </div>
                </li>
                <li>
                    <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="headerbar-right">
            <ul class="header-nav header-nav-options">
                <li>
                    <!-- Search form -->
                    <!--form class="navbar-search" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" name="headerSearch" placeholder="Entre com palavras-chave" style="width:205px">
                        </div>
                        <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
                    </form-->
                </li>
            </ul><!--end .header-nav-options -->
            <?php echo $this->element('layout/header_menu'); ?>
        </div>
    </div>
</header>