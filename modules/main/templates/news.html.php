<?php $csp_response->setTitle(__('Dragon Evo - The Card Game')); ?>
<div class="content left">
	<?php include_component('main/latestnews'); ?>
</div>
<div class="content right news">
	<?php if ($news instanceof application\entities\News): ?>
		<h3><?php echo $news->getTitle(); ?></h3>
		<time><?php echo ($news->getCreatedAt() >= mktime(0, 0, 1)) ? 'Today' : date('dS M', $news->getCreatedAt()); ?>, <?php echo date('H:i', $news->getCreatedAt()); ?></time>
		<p>
			<?php echo $news->getContent(); ?>
		</p>
	<?php else: ?>
		<p>Cannot find this news item</p>
	<?php endif; ?>
</div>
