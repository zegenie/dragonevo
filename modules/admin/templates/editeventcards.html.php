<?php $csp_response->setTitle('Market'); ?>
<div class="content admin-menu">
	<h4>Edit event cards</h4>
	<div style="margin: 5px;">
		<a href="<?php echo make_url('new_card', array('card_type' => 'event')); ?>" class="button button-silver">New card</a>
		<?php if (count($cards)): ?>
			<?php foreach ($cards as $card): ?>
				<?php include_template('main/eventcard', compact('card')); ?>
			<?php endforeach; ?>
		<?php else: ?>
			<p class="faded_out" style="margin-top: 10px;">There are no event cards</p>
		<?php endif; ?>
	</div>
</div>