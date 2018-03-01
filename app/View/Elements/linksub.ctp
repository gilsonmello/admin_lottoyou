<li <?php echo ($this->request->params['controller'] == $controller) ? 'class="active"' : ''; ?>>
    <?php 
    echo $this->Html->link(
		'<i class="fa fa-'.$image.'"></i><span class="submenu-title">'.$title.'</span>', 
    	array('controller'=>$controller,'action'=>'index'), 
    	array('escape' => false,'class'=>'link','title'=>$title,'model'=>$controller)
	); 
    ?>
</li>