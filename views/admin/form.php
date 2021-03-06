<section class="title">
	<!-- We'll use $this->method to switch between survey.create & survey.edit -->
	<h4><?php echo lang('survey:'.$this->method); ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		
		<div class="form_inputs">
	
		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('survey:name'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('name', set_value('name', $survey->name), 'class="width-15"'); ?></div>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="slug"><?php echo lang('survey:slug'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('slug', set_value('slug', $survey->slug), 'class="width-15"'); ?></div>
			</li>
		</ul>
		
		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>
