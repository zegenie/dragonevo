<?php $csp_response->setTitle(__('Page not found')); ?>
<div style="margin: 15px;">
	<?php if (isset($message) && $message): ?>
		<?php echo $message; ?>
	<?php else: ?>
		The page cannot be found.
	<?php endif; ?>
</div>