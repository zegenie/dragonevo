<h6 style="padding-bottom: 2px;">
	<?php if (isset($is_child)) echo '&raquo;&nbsp;&nbsp;'; ?><a href="<?php echo make_url('edit_tellable', array('tellable_type' => $tellable->getTellableType(), 'tellable_id' => $tellable->getId())); ?>" class="button button-standard" style="font-size: 0.9em; margin-right: 5px;">Edit</a><?php echo $tellable->getName(); ?>
</h6>
<?php if (isset($children)): ?>
	<?php if (count($children)): ?>
		<ul style="margin-left: 15px; <?php if ($tellable->getTellableType() == 'story') echo 'margin-bottom: 15px;'; ?> <?php if ($tellable->getTellableType() == 'chapter') echo 'margin-bottom: 5px;'; ?> list-style: none;">
			<?php foreach ($children as $t): ?>
				<?php include_component('admin/tellable', array('tellable' => $t, 'is_child' => true)); ?>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<div class="faded_out" style="margin: 2px 0 10px 25px;"><?php echo ($tellable->getTellableType() == 'story') ? 'This story has no chapter' : 'This chapter has no parts'; ?></div>
	<?php endif; ?>
<?php endif; ?>
