<?php $csp_response->setTitle(__('Dragon Evo - The Card Game')); ?>
<div class="content full">
	<h1>Pick cards for your game</h1>
	<p>
		Before you can start the game <strong>vs. <?php echo $game->getUserOpponent()->getUsername(); ?></strong>, you need to pick cards to play with. Select cards from the list below, and press the big "Play" button when you're ready.
	</p>
	<?php if (count($cards)): ?>
		<form action="<?php echo make_url('pick_cards', array('game_id' => $game->getId())); ?>" method="post">
			<?php foreach ($cards as $card): ?>
				<input type="hidden" name="cards[<?php echo $card->getId(); ?>]" value="<?php echo (int) ($card->isInGame() && $card->getGame()->getId() == $game->getId()); ?>" id="picked_card_<?php echo $card->getId(); ?>">
				<input type="hidden" name="card_types[<?php echo $card->getId(); ?>]" value="<?php echo $card->getCardType(); ?>">
			<?php endforeach; ?>
			<div style="text-align: right; padding: 10px 0 20px;">
				<input type="submit" value="Play game" class="button button-green play-button card-picker" disabled>
			</div>
			<div class="shelf cardpicker">
				<ul>
					<?php foreach ($cards as $card): ?>
						<li>
							<div onclick="Devo.Play.pickCardToggle(<?php echo $card->getId(); ?>);" style="cursor: pointer; position: relative;">
								<?php include_template('game/card', array('card' => $card, 'mode' => 'medium', 'selected' => ($card->isInGame() && $card->getGame()->getId() == $game->getId()))); ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
				<br style="clear: both;">
			</div>
			<div style="text-align: right; padding: 20px 0 10px;">
				<input type="submit" value="Play game" class="button button-green play-button card-picker" disabled>
			</div>
		</form>
	<?php endif; ?>
</div>
<script>
	Devo.Core.Events.listen('devo:core:initialized', function(options) {
		$('fullpage_backdrop').hide();
	});
</script>