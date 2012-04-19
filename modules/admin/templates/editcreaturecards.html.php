<?php $csp_response->setTitle('Edit creature cards'); ?>
<div class="content admin-menu">
	<h4>Edit cards</h4>
	<div style="margin: 5px;">
		<a href="<?php echo make_url('new_card', array('card_type' => 'creature')); ?>" class="button button-silver">New card</a>
		<?php foreach ($cards as $faction => $faction_cards): ?>
			<?php if (count($cards)): ?>
				<h5 style="margin-top: 15px;"><?php echo ucfirst($faction); ?> cards</h5>
				<ul style="margin-left: 15px;">
					<?php foreach ($faction_cards as $card): ?>
						<li><a href="<?php echo make_url('edit_card', array('card_id' => $card->getB2DBID(), 'card_type' => 'creature')); ?>"><?php echo $card->getName(); ?></a>
					<?php endforeach; ?>
				</ul>
			<?php else: ?>
				<p class="faded_out" style="margin-top: 10px;">There are no <?php echo ucfirst($faction); ?> cards</p>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>