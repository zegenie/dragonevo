<?php $csp_response->setTitle('Edit event cards'); ?>
<div class="content full admin-menu">
	<h4>
		Edit event cards
		<a href="<?php echo make_url('new_card', array('card_type' => 'event')); ?>" class="button button-standard" style="margin-left: 10px;">Create new card</a>
	</h4>
	<?php if (count($cards)): ?>
		<div style="margin: 5px;">
			<h6 style="margin-top: 15px;">Existing cards</h6>
			<ul style="margin-left: 15px;">
				<?php foreach ($cards as $card): ?>
					<li><a href="<?php echo make_url('edit_card', array('card_id' => $card->getB2DBID(), 'card_type' => 'event')); ?>"><?php echo $card->getName(); ?></a>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php else: ?>
		<p>There are no event cards</p>
	<?php endif; ?>
</div>