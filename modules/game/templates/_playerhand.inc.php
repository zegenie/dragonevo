<div id="player_hand" data-slot-no="0">
	<?php foreach ($game->getCards() as $card_type => $cards): ?>
		<?php foreach ($cards as $card): ?>
			<?php if ($card->getSlot() != 0 || $card->getCardType() == \application\entities\Card::TYPE_POTION_ITEM) continue; ?>
			<?php include_template('game/card', array('card' => $card, 'ingame' => true)); ?>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>