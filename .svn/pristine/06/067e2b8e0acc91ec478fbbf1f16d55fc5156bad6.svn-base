<section class="section-account" style="background-color:#E5E6E6">
	<div class="img-backdrop" style="height: 100px;background-image: url('<?php echo $this->Html->url('/img/img16.jpg'); ?>')"></div>
	<div class="spacer" style="height: 100px;"></div>
	<div class="card style-transparent">
		<div style="padding-top:20px">
			<div class="row">
				<div class="col-sm-12">
					<?php $file = (is_file('img/avatar/'.$photo)) ? $photo : 'default.png'; ?>
					<img class="img-circle" style="position:absolute; top:-83px; width: 90px;height: 90px;"  src="<?php echo $this->Html->url('../img/avatar/'.$file) ?>?1403934956" alt="" />
					<h2><?php echo $name; ?></h2>
					<?php echo $this->Form->create('User', array('controller'=>'users','action'=>'check','class'=>'form form-validate', 'accept-charset'=>'utf-8')); ?>
						<?php echo $this->Form->hidden('username', array('value'=>$username)); ?>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-content">
									<?php echo $this->Form->input('password', array('label'=>'Informe sua senha', 'class'=>'form-control', 'autocomplete'=>'off', 'value'=>'')); ?>
								</div>
								<div class="input-group-btn">
									<button class="btn btn-floating-action btn-primary btn-loading-state" data-loading-text="<i class='fa fa-spinner fa-spin'></i>" type="submit"><i class="fa fa-unlock"></i></button>
								</div>
							</div><!--end .input-group -->
						</div><!--end .form-group -->
					<?php echo $this->Form->end(); ?>
				</div><!--end .col -->
			</div><!--end .row -->
		</div><!--end .card-body -->
	</div><!--end .card -->
</section>