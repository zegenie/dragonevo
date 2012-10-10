<?php $csp_response->setTitle(__('Dragon Evo - The Card Game')); ?>
<?php include_template('main/profileleftmenu'); ?>
<div class="content left" id="profile-cards-container">
	<h2 style="margin-bottom: 10px;">
		My card collection<br>
		<span id="top-shelf-menu-container" style="display: none; font-weight: normal; font-size: 0.7em;"><a href="javascript:void(0);" onclick="Devo.Main.loadProfile();">&laquo; Back to profile</a></span>
	</h2>
	<p>
		These are your cards, collected throughout the game, including your starter pack cards.
	</p>
	<div class="shelf" id="cards-shelf">
		<?php if (count($cards)): ?>
			<ul>
				<?php foreach ($cards as $card): ?>
					<li>
						<div onclick="Devo.Main.showCardActions('<?php echo $card->getUniqueId(); ?>');" style="cursor: pointer;">
							<?php include_template('game/card', array('card' => $card, 'mode' => 'medium', 'ingame' => false)); ?>
						</div>
						<div id="card_<?php echo $card->getUniqueId(); ?>_actions" class="card_actions" style="display: none;">
							<div class="card_actions_description">
								<h3><?php echo $card->getName(); ?></h3>
								<p><?php echo nl2br($card->getLongDescription()); ?></p>
							</div>
							<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
								<div class="card_actions_attacks">
									<h3>Attacks</h3>
									<?php foreach ($card->getAttacks() as $attack): ?>
										<h6><?php echo $attack->getName(); ?></h6>
										<p><?php echo $attack->getDescription(); ?></p>
										<div class="cardattack_damage"><?php include_template('game/cardattackdamage', compact('attack')); ?></div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<br style="clear: both;">
							<div class="card_actions_actions">
								<h5>Actions</h5>
								<a href="#"><img src="/images/glyph_fullscreen.png">Look at card</a>
							</div>
							<br style="clear: both;">
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<div class="no_cards" style="position: absolute; font-size: 2em; font-weight: normal; color: rgba(200, 200, 200, 0.8); top: 100px; width: 500px; text-align: center; left: 50%; margin-left: -250px; z-index: 200;">You don't have any cards yet</div>
			<ul>
				<?php for ($cc = 0; $cc < 5; $cc++): ?>
					<li><div class="card medium flipped faded"></div></li>
				<?php endfor; ?>
			</ul>
		<?php endif; ?>
		<br style="clear: both;">
	</div>
</div>