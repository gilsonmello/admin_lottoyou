<div class="page-content">
    <div id="page-user-profile" class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs ul-edit responsive">
                        <li class="active">
                            <a href="#tab-consulta" data-toggle="tab"><i class="fa fa-bolt"></i>&nbsp;Consulta</a>
                        </li>
                    </ul>
                    <div id="generalTabContent" class="tab-content" style="padding-top: 15px;padding-bottom: 15px;">
                        <div id="tab-consulta" class="tab-pane fade in active">
                            <div class="table-responsive">
                                <div id="dataGrid" style="width: 100%; height: 400px;"></div>
                                <?php echo $this->Html->script('grids/estados.js', array('inline' => false)); ?>      
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>