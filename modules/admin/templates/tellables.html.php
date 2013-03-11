<?php $csp_response->setTitle('Edit '.(($tellable_type == 'story') ? 'stories' : 'adventures')); ?>
<div class="content left">
	<?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right cotw-admin">
	<h1>
		Edit <?php echo ($tellable_type == 'story') ? 'stories' : 'adventures'; ?> <a href="<?php echo make_url('new_tellable', compact('tellable_type')); ?>" class="button button-standard" style="margin-left: 10px;">Create new <?php echo ($tellable_type == 'story') ? 'story' : 'adventure'; ?></a>
	</h1>
	<?php if (count($tellables)): ?>
		<?php foreach ($tellables as $tellable_id => $tellable): ?>
			<?php include_component('admin/tellable', compact('tellable')); ?>
		<?php endforeach; ?>
	<?php else: ?>
		<span class="faded_out" style="display: inline-block; padding: 5px 0;">There are no <?php echo ($tellable_type == 'story') ? 'stories' : 'adventures'; ?> yet</span>
	<?php endif; ?>
</div>