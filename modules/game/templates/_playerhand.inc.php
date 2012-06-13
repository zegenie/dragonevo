<div id="player_hand" data-slot-no="0">
	<?php foreach ($game->getCards() as $card_type => $cards): ?>
		<?php foreach ($cards as $card): ?>
			<?php if ($card->getSlot() != 0) continue; ?>
			<?php include_template('game/card', array('card' => $card)); ?>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>