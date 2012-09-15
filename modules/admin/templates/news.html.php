<?php $csp_response->setTitle('Edit creature cards'); ?>
<div class="content left">
	<?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right cotw-admin">
	<h1>
		Manage news
	</h1>
	<p>
		News are shown in the right hand column on the front page, and as separate news items.
	</p>
	<h5>
		Previous news items
		<a href="<?php echo make_url('create_news'); ?>" class="button button-standard" style="margin-left: 10px;">Create new news item</a>
	</h5>
	<?php if (count($all_news)): ?>
		<ul style="margin-left: 15px;">
			<?php foreach ($all_news as $news): ?>
				<li><a href="<?php echo make_url('edit_news', array('id' => $news->getId())); ?>"><?php echo $news->getTitle(); ?></a>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<p>There are no news items posted</p>
	<?php endif; ?>
</div>