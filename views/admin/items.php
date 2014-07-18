<section class="title">
	<h4><?php echo lang('survey:item_list'); ?></h4>
</section>

<section class="item">
	<?php echo form_open('admin/survey/delete');?>
	
	<?php if (!empty($items)): ?>
	
		<table>
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th><?php echo lang('survey:name'); ?></th>
					<th><?php echo lang('survey:slug'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach( $items as $item ): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $item->id); ?></td>
					<td><?php echo $item->name; ?></td>
					<td><a href="<?php echo rtrim(site_url(), '/').'/survey'; ?>">
						<?php echo rtrim(site_url(), '/').'/survey'; ?></a></td>
					<td class="actions">
						<?php echo
						anchor('survey', lang('survey:view'), 'class="button" target="_blank"').' '.
						anchor('admin/survey/edit/'.$item->id, lang('survey:edit'), 'class="button"').' '.
						anchor('admin/survey/delete/'.$item->id, 	lang('survey:delete'), array('class'=>'button')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
		</div>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('survey:no_items'); ?></div>
	<?php endif;?>
	
	<?php echo form_close(); ?>
</section>