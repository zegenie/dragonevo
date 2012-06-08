<div id="player_hand">
	<?php foreach ($game->getCards() as $card_type => $cards): ?>
		<?php foreach ($cards as $card): ?>
			<?php include_template('game/card', array('card' => $card)); ?>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>