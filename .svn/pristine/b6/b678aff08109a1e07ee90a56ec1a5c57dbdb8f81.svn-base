<?php 
// VERIFICA SE O LINK DEVE FICAR ATIVO
$aux = ($this->here == $this->base.'/') ? 'dashboard' : '';
$class = ($this->here.$aux == $this->base.$link || $this->here.$aux.'/' == $this->base.$link) ? 'active' : '';

// VERIFICA SE HÁ REQUEST
$options = (isset($request) && $request != '') ? array('escape' => false, 'request'=>$request) : array('escape' => false);
?>
<li <?php echo 'class="'.$class.'"' ?>>
<?php echo $this->Html->link('<div class="gui-icon"><i class="'.$image.'"></i></div><span class="title">'.$title.'</span>', $link, $options); ?>
</li>