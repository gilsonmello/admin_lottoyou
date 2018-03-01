<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb" style="padding: 7px 20px 8px 20px">
    <div class="page-header pull-left">
        <div class="page-title"><?php echo $breadcrumb['funcionalidade']; ?></div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li>
            <i class="fa fa-home"></i>&nbsp;
            <?php echo $this->Html->link('Início', array('controller'=>'dashboard')); ?>&nbsp;&nbsp;
            <i class="fa fa-angle-right"></i>&nbsp;&nbsp;
        </li>
        <li class="active"><?php echo $breadcrumb['modulo']; ?></li>
    </ol>
    <div class="clearfix"></div>
</div>