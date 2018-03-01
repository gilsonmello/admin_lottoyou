<?php $style = (!isset($style)) ? 'primary' : $style; ?>
<div class="card" style="margin-bottom:0;box-shadow:none;">
    <div class="card-head card-head-sm style-<?php echo $style; ?>">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-right:24px;padding-top:14px;"><span aria-hidden="true">&times;</span></button>
        <header><?php echo $title; ?></header>
    </div>
</div>