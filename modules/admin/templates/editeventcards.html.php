<?php $csp_response->setTitle('Market'); ?>
<div class="content admin-menu">
	<h4>Edit event cards</h4>
	<div style="margin: 5px;">
		<?php if (count($cards)): ?>
			<?php foreach ($cards as $card): ?>
			<?php endforeach; ?>
		<?php else: ?>
			<span class="faded_out">There are no event cards</span>
		<?php endif; ?>
	</div>
</div>