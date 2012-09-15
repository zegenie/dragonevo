<div id="player_potions_hand" data-slot-no="0">
	<?php $has_potions = false; ?>
	<?php foreach ($cards as $card): ?>
		<?php include_template('game/card', array('card' => $card, 'ingame' => true, 'mode' => 'medium')); ?>
	<?php endforeach; ?>
	<div id="player_no_potions" style="font-family: 'Amaranth'; font-size: 1em; font-weight: normal; padding: 10px 5px; color: rgba(255, 255, 255, 0.9); <?php if (count($cards)): ?>display: none;<?php endif; ?>">You have no potions in this game</div>
</div>