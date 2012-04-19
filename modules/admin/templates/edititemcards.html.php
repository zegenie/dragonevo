<?php $csp_response->setTitle('Edit item cards'); ?>
<div class="content admin-menu">
	<h4>Edit item cards</h4>
	<div style="margin: 5px;">
		<a href="<?php echo make_url('new_card', array('card_type' => 'item')); ?>" class="button button-silver">New card</a>
		<?php if (count($cards)): ?>
			<h5 style="margin-top: 15px;">Existing cards</h5>
			<ul style="margin-left: 15px;">
				<?php foreach ($cards as $card): ?>
					<li><a href="<?php echo make_url('edit_card', array('card_id' => $card->getB2DBID(), 'card_type' => 'item')); ?>"><?php echo $card->getName(); ?></a>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p class="faded_out" style="margin-top: 10px;">There are no item cards</p>
		<?php endif; ?>
	</div>
</div>