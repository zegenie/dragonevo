<div class="pickcards" id="pickcards-container">
	<h1>
		<?php if (!$game->isScenario()): ?>
			Pick cards for your game
		<?php else :?>
			<?php echo $game->getPart()->getName(); ?>
		<?php endif; ?>
	</h1>
	<p>
		<?php if (!$game->isScenario()): ?>
			Before you can start the game <strong>vs. <?php echo $game->getUserOpponent()->getCharactername(); ?></strong>, you need to pick cards to play with.<br>
		<?php else :?>
			<?php echo $game->getPart()->getFullstory(); ?><br>
		<?php endif; ?>
		<br>
		<div id="pickcards-summary">
			You need to select <strong>at least <?php echo $game->getMinimumCards(); ?> cards</strong> - minimum <strong><?php echo $game->getMinCreatureCards(); ?> creature cards</strong> and <strong><?php echo $game->getMinItemCards(); ?> item cards</strong>. Select cards from the list below, and press the big "<?php echo ($game->isScenario()) ? 'Start quest' : 'Play game'; ?>" button when you're ready.
		</div>
	</p>
	<?php if (count($cards)): ?>
		<form action="<?php echo make_url('pick_cards', array('game_id' => $game->getId())); ?>" method="post" onsubmit="Devo.Game.pickCards();return false;" id="card-picker-form">
			<div id="pickcards-filter-container">
				<div class="button-group shelf-filter">
					<button class="button button-silver button-pressed" data-filter="creature" onclick="Devo.Main.filterCards('creature');return false;">Creature cards (<span id="picked-creature-cards">0</span>/<?php echo $game->getMaxCreatureCards(); ?>)</button>
					<button class="button button-silver" data-filter="equippable_item" onclick="Devo.Main.filterCards('equippable_item');return false;">Item cards (<span id="picked-item-cards">0</span>/<?php echo $game->getMaxItemCards(); ?>)</button>
					<button class="button button-silver" data-filter="card" onclick="Devo.Main.filterCards('card');return false;">All cards (<span id="picked-all-cards">0</span>/<?php echo $game->getMaximumCards(); ?>)</button>
				</div>
				<div class="play_game_container" id="play-game-container-top">
					<?php if (!$game->isScenario()): ?>
						<button class="button button-silver card-picker" onclick="$('gamemenu-container').hide();Devo.Main.Helpers.Dialog.show('Flee the battle?', 'Quitting the game means you lose, the opponent is awarded battlepoints and XP, and you\'re left with nothing! Not even loot!<br><span class=\'faded_out\'>Actually, the part about loot isn\'t implemented yet, but suddenly it will be and then you\'ll be sorry!</span>', {yes: {click: function() {Devo.Game.flee(); }}, no: {click: function() {Devo.Main.Helpers.Dialog.dismiss();}}});return false;">Leave game</button>
					<?php else: ?>
						<button class="button button-silver card-picker" onclick="Devo.Game.destroyGame();Devo.Main.loadAdventureUI('part', <?php echo $game->getPartId(); ?>);return false;">Try later</button>
					<?php endif; ?>
					<input type="submit" value="<?php echo ($game->isScenario()) ? 'Start quest' : 'Play game'; ?>" class="button button-green play-button card-picker" disabled>
				</div>
			</div>
			<?php foreach ($cards as $card): ?>
				<?php if ($card->getGameId()) continue; ?>
				<input type="hidden" name="cards[<?php echo $card->getUniqueId(); ?>]" value="<?php echo (int) ($game->hasCard($card) && $card->getGame()->getId() == $game->getId()); ?>" id="picked_card_<?php echo $card->getUniqueId(); ?>">
				<input type="hidden" name="card_types[<?php echo $card->getId(); ?>]" value="<?php echo $card->getCardType(); ?>">
			<?php endforeach; ?>
			<br style="clear: both;">
			<div class="shelf cardpicker" id="pickcards-shelf">
				<ul>
					<?php foreach ($cards as $card): ?>
						<?php if ($card->getCardType() == \application\entities\Card::TYPE_POTION_ITEM) continue; ?>
						<li <?php if (!($card->getCardType() == \application\entities\Card::TYPE_CREATURE)): ?>style="display: none;"<?php endif; ?>>
							<div onclick="Devo.Play.pickCardToggle('<?php echo $card->getUniqueId(); ?>');" style="cursor: pointer; position: relative;">
								<?php include_template('game/card', array('card' => $card, 'mode' => 'medium', 'ingame' => false, 'selected' => ($game->hasCard($card) && $card->getGame()->getId() == $game->getId()))); ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="play_game_container">
				<?php if (!$game->isScenario()): ?>
					<button class="button button-silver card-picker" onclick="$('gamemenu-container').hide();Devo.Main.Helpers.Dialog.show('Flee the battle?', 'Quitting the game means you lose, the opponent is awarded battlepoints and XP, and you\'re left with nothing! Not even loot!<br><span class=\'faded_out\'>Actually, the part about loot isn\'t implemented yet, but suddenly it will be and then you\'ll be sorry!</span>', {yes: {click: function() {Devo.Game.flee(); }}, no: {click: function() {Devo.Main.Helpers.Dialog.dismiss();}}});return false;">Leave game</button>
				<?php else: ?>
					<button class="button button-silver card-picker" onclick="Devo.Game.destroyGame();Devo.Main.loadAdventureUI('part', <?php echo $game->getPartId(); ?>);">Try later</button>
				<?php endif; ?>
				<input type="submit" value="<?php echo ($game->isScenario()) ? 'Start quest' : 'Play game'; ?>" class="button button-green play-button card-picker" disabled>
			</div>
			<br style="clear: both;">
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
<?php if ($csp_user->isPickCardsTutorialEnabled()): ?>
	<script>
		Devo.Tutorial.Stories.pickcards = {
			1: {
				message: "<h3>Game on</h3>Finally! You're ready to play your first game! To help you get started quickly, this tutorial will guide you through the basics. We'll start with picking cards for your game.",
				messageSize: 'large',
				button: 'Next'
			},
			2: {
				message: '<h3>Game on</h3>When playing a game, you will want to pick cards that go well together. Some cards have actions to generate gold, some have melee attacks, some have ranged attacks, etc.<br><br>Setting up a good game hand is essential to win the game, and mastering picking your cards is key.',
				messageSize: 'large',
				button: "Next"
			},
			3: {
				message: "<h3>Picking cards</h3>Before the game starts, you will be presented with the 'Pick cards' screen. That is the screen you're currently looking at.",
				messageSize: 'medium',
				button: 'Next'
			},
			4: {
				highlight: {element: 'pickcards-summary', blocked: true},
				message: '<h3>Picking cards</h3>On this screen you can see how many cards you must pick to be able to play.<br><br>In custom multiplayer games and in adventure mode, this may change depending on the game settings or the current adventure quest.',
				messageSize: 'medium',
				messagePosition: 'below',
				button: 'Got it'
			},
			5: {
				highlight: {element: 'pickcards-filter-container', blocked: true},
				message: '<h3>Picking cards</h3>To help you pick cards, there are card filters available. This lets you switch between picking creature cards and item cards, and also shows you how many cards are left to pick.<br><br>You can switch between creature cards and item cards as you please - the selection will be kept when you switch back and forth.',
				messageSize: 'medium',
				messagePosition: 'below',
				button: 'Can I try?'
			},
			6: {
				highlight: {element: 'pickcards-filter-container', blocked: false, seethrough: true},
				message: "<h3>Picking cards</h3>Sure, you can try!<br><br><strong>Try clicking the different card filters and watch the available cards change.</strong>",
				messageSize: 'medium',
				messagePosition: 'below',
				button: "I'm done now"
			},
			7: {
				highlight: {element: 'pickcards-shelf', blocked: true},
				message: "<h3>Picking cards</h3>Picking cards for your game is just as easy. Click a card once to select it, click it again to unselect it.<br><br>Note that you can only select cards from one faction per game (as well as any world cards) - if you try to select a card from different factions, the previously selected creature cards will be unselected.",
				messageSize: 'large',
				messagePosition: 'above',
				button: "Sure"
			},
			8: {
				highlight: {element: 'pickcards-shelf', blocked: false},
				message: "<h3>Picking cards</h3><br><strong>Try selecting and unselecting a couple of cards</strong>",
				messageSize: 'small',
				messagePosition: 'above',
				button: "That was easy",
				cb: function(td) {
					$('ui').hide();
				}
			},
			9: {
				message: "<h3>Picking cards</h3>When you look at your cards, they have different attacks. Some attacks needs to be 'powered' by item cards.<br><br><strong>For example:</strong> to use an attack called 'Sword slash', you will need to equip that card with a sword item card. Also, ranged attacks such as arrow shots are useless unless the card is equipped with one or more arrows!<br><br>To make sure you have the correct item cards, hover over the attacks of any selected cards and read the description.<br><br>The description will tell you if it needs any item cards to be enabled.",
				messageSize: 'large',
				button: "That makes sense",
				cb: function(td) {
					$('ui').show();
				}
			},
			10: {
				message: "<h3>Picking cards</h3>If any of your attacks needs item cards to be enabled, look through your item cards and see if you have an item of that type.<br><br>Some item cards are also stronger than others - a wooden sword is weaker than a metal sword, and equipping a stronger item card can make a big difference!<br><br>Bringing the correct item cards into your game can be the difference between just winning and just losing a game!",
				messageSize: 'large',
				button: "Sure"
			},
			11: {
				highlight: {element: 'play-game-container-top', blocked: true},
				message: "<h3>Game on!</h3>Now, pick your cards and press the 'Play game' button to start.",
				messageSize: 'small',
				messagePosition: 'below',
				button: "I will do it!"
			},
			12: {
				message: "<h1>Have fun!</h1>That was it.<br><br>Don't hesitate to ask someone if you're stuck. Remember, the lobby is always just a click away.",
				messageSize: 'medium',
				button: 'Done!'
			}
		};
		Devo.Tutorial.start('pickcards');
	</script>
<?php endif; ?>
