<div class="pickcards" id="pickcards-container">
	<h1>Pick cards for your game</h1>
	<p>
		Before you can start the game <strong>vs. <?php echo ($game->getOpponentId()) ? $game->getUserOpponent()->getUsername() : 'Training AI'; ?></strong>, you need to pick cards to play with. Select cards from the list below, and press the big "Play" button when you're ready.
	</p>
	<?php if (count($cards)): ?>
		<form action="<?php echo make_url('pick_cards', array('game_id' => $game->getId())); ?>" method="post" onsubmit="Devo.Game.pickCards();return false;" id="card-picker-form">
			<?php foreach ($cards as $card): ?>
				<?php if ($card->getGameId()) continue; ?>
				<input type="hidden" name="cards[<?php echo $card->getId(); ?>]" value="<?php echo (int) ($card->isInGame() && $card->getGame()->getId() == $game->getId()); ?>" id="picked_card_<?php echo $card->getUniqueId(); ?>">
				<input type="hidden" name="card_types[<?php echo $card->getId(); ?>]" value="<?php echo $card->getCardType(); ?>">
			<?php endforeach; ?>
			<div style="text-align: right; padding: 10px 0 20px;">
				<button class="button button-silver card-picker" onclick="Devo.Game.flee();return false;">Leave game</button>
				<input type="submit" value="Play game" class="button button-green play-button card-picker" disabled>
			</div>
			<div class="shelf cardpicker">
				<ul>
					<?php foreach ($cards as $card): ?>
						<?php if ($card->getCardType() == \application\entities\Card::TYPE_POTION_ITEM || $card->getGameId()) continue; ?>
						<li>
							<div onclick="Devo.Play.pickCardToggle('<?php echo $card->getUniqueId(); ?>');" style="cursor: pointer; position: relative;">
								<?php include_template('game/card', array('card' => $card, 'mode' => 'medium', 'ingame' => false, 'selected' => ($card->isInGame() && $card->getGame()->getId() == $game->getId()))); ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div style="text-align: right; padding: 20px 0 10px;">
				<button class="button button-silver card-picker" onclick="Devo.Game.flee();return false;">Leave game</button>
				<input type="submit" value="Play game" class="button button-green play-button card-picker" disabled>
			</div>
		</form>
	<?php else: ?>
		<div class="shelf">
			<div class="no_cards" style="position: absolute; font-size: 2em; font-weight: normal; color: rgba(200, 200, 200, 0.8); top: 100px; width: 500px; text-align: center; left: 50%; margin-left: -250px; z-index: 200;">
				You don't have any cards yet<br>
				<a class="button button-standard" href="<?php echo make_url('profile'); ?>" style="font-size: 0.7em !important; display: inline-block; margin-top: 5px; padding: 10px 25px !important;">Get starter pack</a>
			</div>
			<ul>
				<?php for ($cc = 0; $cc < 5; $cc++): ?>
					<li><div class="card medium flipped faded"></div></li>
				<?php endfor; ?>
			</ul>
		</div>
	<?php endif; ?>
</div>