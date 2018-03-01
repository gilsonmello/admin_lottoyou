<?php 
foreach(explode(';',@$this->data[$model][$field]) as $k => $v){ 
	$before = ($k == 0) ? '<label for="$model$field" class="">'.$options['label'].'</label><div class="input-group">' : '<div class="input-group">';
	$after = ($k == 0) ? '<button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>' : '<button type="button" class="btn btn-danger"><i class="fa fa-minus"></i></button>';
	$cols = (isset($options['cols'])) ? $options['cols'] : 'col-xs-12';
	$type = (isset($type)) ? $type : 'text';

	echo $this->Form->input("$model.$field.$k", array(
		'label' => false, 
		'required' => false, 
		'type' => $type, 
		'value'=>trim($v), 
		'class' => 'form-control '.@$options['class'], 
		'placeholder' => ''.@$options['placeholder'], 
		'div' => array('class' => $cols),
		'before'=> $before, 
		'after'=>"<span class=\"input-group-btn\">$after</span></div>"
	));
} 
?>