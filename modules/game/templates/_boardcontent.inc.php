<?php

	use \application\entities\Game;

?>
<?php if ($game instanceof Game && ($csp_user->isAdmin() || in_array($csp_user->getId(), array($game->getPlayer()->getId(), $game->getOpponentId())))): ?>
	<div id="board-container" class="<?php if (!$csp_user->isLowGraphicsEnabled()) echo 'effect-3d'; ?>">
		<div id="gameover-overlay" class="fullpage_backdrop dark" style="<?php if (!$game->isGameOver()): ?>display: none;<?php endif; ?>">
			<div class="fullpage_backdrop_content">
				<div class="backdrop_box medium">
					<h1>Game over</h1>
					<div class="box_content">
						<div id="winning_player_<?php echo $game->getPlayer()->getId(); ?>" class="winning" style="<?php if ($game->getWinningPlayerId() != $game->getPlayer()->getId()) echo 'display: none;'; ?>"><?php echo ($game->getPlayer()->getId() == $csp_user->getId()) ? 'You won!' : $game->getPlayer()->getCharactername() . ' won!'; ?></div>
						<div id="winning_player_<?php echo $game->getOpponentId(); ?>" class="winning" style="<?php if ($game->getWinningPlayerId() != $game->getOpponentId()) echo 'display: none;'; ?>"><?php echo ($game->getOpponentId() == $csp_user->getId()) ? 'You won!' : $game->getOpponent()->getCharactername() . ' won!'; ?></div>
						<div style="text-align: left;">
							<h6>Statistics</h6>
							<div id="game_statistics_indicator" style="<?php if ($game->isGameOver()): ?>display: none;<?php endif; ?>">
								<img src="/images/spinning_16.gif" style="margin-right: 5px; margin-top: 3px; margin-bottom: -3px;">Loading statistics, please wait
							</div>
							<div<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?>>
								<div id="game_statistics" style="<?php if (!$game->isGameOver()): ?>display: none;<?php endif; ?>">
									<strong>Damage inflicted:</strong>&nbsp;<span id="statistics_hp"><?php echo $statistics['hp']; ?></span>HP<br>
									<strong>Cards killed:</strong>&nbsp;<span id="statistics_cards"><?php echo $statistics['cards']; ?></span><br>
									<strong>XP earned:</strong>&nbsp;<span id="statistics_xp"><?php echo $statistics['xp']; ?></span><br>
									<strong>Gold payout:</strong>&nbsp;<span id="statistics_gold"><?php echo $statistics['gold']; ?></span>
								</div>
							</div>
							<div class="button-container" id="goto-buttons-container"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?>>
								<button class="ui_button" onclick="Devo.Game.destroyGame();Devo.Main.loadLobbyUI();" id="goto-lobby-button"<?php if ($game->isScenario()): ?> style="display: none;"<?php endif; ?>>Go to the lobby</a>
								<button class="ui_button" onclick="<?php if ($game->isScenario()): ?>Devo.Game.destroyGame();Devo.Main.loadAdventureUI('part', <?php echo $game->getPartId(); ?>);<?php endif; ?>" id="goto-adventure-button"<?php if (!$game->isScenario()): ?> style="display: none;"<?php endif; ?>>Back to map</a>
								<button class="ui_button" onclick="Devo.Game.destroyGame();Devo.Main.loadMarketFrontpage();">Buy better cards</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="game-menu">
			<div id="game-opponent">
				<div class="game-name">
					<?php if (!$game->isScenario()): ?>
						<span id="player-<?php echo $game->getPlayer()->getId(); ?>-name" data-character-name="<?php echo $game->getPlayer()->getCharactername(); ?>">
							<?php echo $game->getPlayer()->getCharactername(); ?>
							<span class="tooltip from-above">The player is currently offline</span>
						</span>
						<span class="versus_versus">versus</span>
						<span id="player-<?php echo $game->getOpponentId(); ?>-name" data-character-name="<?php echo $game->getOpponent()->getCharactername(); ?>">
							<?php echo $game->getOpponent()->getCharactername(); ?>
							<?php if (!$game->getOpponent()->isAI()): ?>
								<span class="tooltip from-above">The player is currently offline</span>
							<?php endif; ?>
						</span>
					<?php else: ?>
						<?php echo $game->getPart()->getName(); ?>
					<?php endif; ?>
				</div>
				<?php if ($game->isScenario()): ?>
					<div class="tooltip from-above"><?php echo $game->getPart()->getExcerpt(); ?></div>
				<?php endif; ?>
			</div>
			<div id="turn-info">
				<div id="place_cards" class="animated" style="<?php if ($game->isUserPlayerReady() || !$game->isUserInGame()) echo 'display: none;'; ?>">Place your cards</div>
				<div id="player-<?php echo $game->getPlayer()->getId(); ?>-turn" class="turn-info animated" style="<?php if ($game->getCurrentPlayerId() != $game->getPlayer()->getId() || !$game->isUserPlayerReady()) echo 'display: none;'; ?>"><?php echo ($csp_user->getId() == $game->getPlayer()->getId()) ? "It is your turn" : "It is {$game->getPlayer()->getCharactername()}'s turn"; ?></div>
				<div id="player-<?php echo $game->getOpponentId(); ?>-turn" class="turn-info animated<?php if ($game->isUserOffline($game->getOpponentId())) echo ' faded'; ?>" style="<?php if ($game->getCurrentPlayerId() != $game->getOpponentId() || !$game->isUserPlayerReady()) echo 'display: none;'; ?>"><?php echo ($csp_user->getId() == $game->getOpponentId()) ? "It is your turn" : "It is {$game->getOpponent()->getCharactername()}'s turn"; ?></div>
			</div>
			<div id="last-event" class="animated"></div>
		</div>
		<div id="game-table-container">
			<div id="game-table">
				<div id="opponent-slots-container" class="card-slots-container">
					<ul id="opponent-slots" class="card-slots">
						<?php for ($cc = 5; $cc >= 1; $cc--): ?>
							<li id="opponent-slot-<?php echo $cc; ?>"
								class="card-slot creature-slot opponent slot-<?php echo $cc; ?>"
								data-slot-no="<?php echo $cc; ?>"
								data-card-id="<?php echo $game->getUserOpponentCardSlotId($cc); ?>">
                                <div id="opponent-slot-<?php echo $cc; ?>-loader" class="card_loading cssloader"><img src="/images/spinner.png"></div>
                                <?php include_template('game/card', array('card' => $game->getUserOpponentCardSlot($cc), 'mode' => 'medium', 'ingame' => true)); ?>
								<div id="opponent-slot-<?php echo $cc; ?>-item-slot-1"
									class="card-slot item-slot opponent slot-<?php echo $cc; ?>"
									data-slot-no="<?php echo $cc; ?>"
									data-card-id="<?php echo $game->getUserOpponentCardSlotPowerupCard1Id($cc); ?>">
										<?php include_template('game/card', array('card' => $game->getUserOpponentCardSlotPowerupCard1($cc), 'mode' => 'medium', 'ingame' => true)); ?>
										<div class="card_loading cssloader"><img src="/images/spinner.png"></div>
								</div>
								<div id="opponent-slot-<?php echo $cc; ?>-item-slot-2"
									class="card-slot item-slot opponent slot-<?php echo $cc; ?>"
									data-slot-no="<?php echo $cc; ?>"
									data-card-id="<?php echo $game->getUserOpponentCardSlotPowerupCard2Id($cc); ?>">
										<?php include_template('game/card', array('card' => $game->getUserOpponentCardSlotPowerupCard2($cc), 'mode' => 'medium', 'ingame' => true)); ?>
										<div class="card_loading cssloader"><img src="/images/spinner.png"></div>
								</div>
							</li>
						<?php endfor; ?>
					</ul>
				</div>
				<div id="board-cover" style="display: none;"></div>
				<div id="play-area">
					<div id="clicktocancel">Press here to not move the card</div>
					<div id="event-slot" class="card-slot"></div>
					<div id="game-gold" class="game-gold" data-amount="<?php echo $game->getUserPlayerGold(); ?>">
						<img src="/images/gold.png">
						<div id="game-gold-amount" class="game-gold-amount"><?php echo $game->getUserPlayerGold(); ?></div>
					</div>
					<div id="game-gold-opponent" class="game-gold opponent" data-amount="<?php echo $game->getUserOpponentGold(); ?>">
						<img src="/images/gold.png">
						<div id="game-gold-amount-opponent" class="game-gold-amount"><?php echo $game->getUserOpponentGold(); ?></div>
					</div>
					<div id="sword-clash" style="display: none;">
						<img src="/images/swordclash.png">
					</div>
				</div>
				<div id="player-slots-container" class="card-slots-container">
					<ul id="player-slots" class="card-slots">
						<?php for ($cc = 1; $cc <= 5; $cc++): ?>
							<li id="player-slot-<?php echo $cc; ?>"
								class="card-slot creature-slot player slot-<?php echo $cc; ?>"
								data-slot-no="<?php echo $cc; ?>"
								data-card-id="<?php echo $game->getUserPlayerCardSlotId($cc); ?>">
                                <div id="player-slot-<?php echo $cc; ?>-loader" class="card_loading cssloader"><img src="/images/spinner.png"></div>
								<?php include_template('game/card', array('card' => $game->getUserPlayerCardSlot($cc), 'mode' => 'medium', 'ingame' => true)); ?>
								<div id="player-slot-<?php echo $cc; ?>-item-slot-1"
									class="card-slot item-slot item-slot-1 player slot-<?php echo $cc; ?>"
									data-slot-no="<?php echo $cc; ?>"
									data-item-slot-no="1"
									data-card-id="<?php echo $game->getUserPlayerCardSlotPowerupCard1Id($cc); ?>">
										<?php include_template('game/card', array('card' => $game->getUserPlayerCardSlotPowerupCard1($cc), 'mode' => 'medium', 'ingame' => true)); ?>
                                        <div class="card_loading cssloader"><img src="/images/spinner.png"></div>
								</div>
								<div id="player-slot-<?php echo $cc; ?>-item-slot-2"
									class="card-slot item-slot item-slot-2 player slot-<?php echo $cc; ?>"
									data-slot-no="<?php echo $cc; ?>"
									data-item-slot-no="2"
									data-card-id="<?php echo $game->getUserPlayerCardSlotPowerupCard2Id($cc); ?>">
										<?php include_template('game/card', array('card' => $game->getUserPlayerCardSlotPowerupCard2($cc), 'mode' => 'medium', 'ingame' => true)); ?>
                                        <div class="card_loading cssloader"><img src="/images/spinner.png"></div>
								</div>
							</li>
						<?php endfor; ?>
					</ul>
				</div>
			</div>
		</div>
		<div id="player_stuff" <?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?> class="<?php if (!$game->isUserPlayerReady() && !$csp_user->isBoardTutorialEnabled()) echo 'visible'; ?>">
			<?php if ($game->isUserInGame()) include_component('game/playerhand', compact('game')); ?>
		</div>
		<div id="player_potions"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?>>
			<?php if ($game->getAllowPotions()): ?>
				<h5>Potions</h5>
				<?php if ($game->isUserInGame()) include_component('game/playerpotions', compact('game')); ?>
			<?php endif; ?>
		</div>
		<div id="game_events" class="animated fadeOut" onclick="Devo.Game.toggleEvents();">
			<div id="game_event_contents">
				<?php foreach ($game->getEvents() as $event_id => $event): ?>
					<?php include_template('game/event', compact('event')); ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php else: ?>
	<?php

		$csp_response->setTitle("Game board");

	?>
	<div style="color: #FFF; text-align: center; width: 500px; margin: 150px 0 0 -250px; font-size: 1.5em; font-family: 'Amaranth'; left: 50%; position: absolute;">This game doesn't exist<br><span style="font-weight: normal; font-size: 0.7em;">or you don't have access to see it</span></div>
<?php endif; ?>
<?php if ($csp_user->isBoardTutorialEnabled()): ?>
	<script>
		Devo.Tutorial.Stories.board = {
			1: {
				message: "<h3>The game board view</h3>You've picked your cards, and you've started a game!<br><br>To help you find your way around the board, this tutorial will guide you through the basic game mechanics.",
				messageSize: 'large',
				button: "Great, I'll need that"
			},
			2: {
				message: "<h3>The game board view</h3>By the way, the game plays best when in fullscreen.<br><br><strong>If you haven't already switched to fullscreen, press F11 to do so now.</strong>",
				messageSize: 'large',
				button: "Woot!"
			},
			3: {
				highlight: {element: 'game-menu', blocked: true},
				message: "<h3>The game board view</h3>At the top left, you have the opponent information. If you play vs. another player, that players name and their online status will show here.<br><br>If you're playing a quest, the quest name will show here, and you can hover it for more details about that quest.",
				messageSize: 'medium',
				messagePosition: 'right',
				button: 'Next'
			},
			4: {
				highlight: {element: 'game-menu', blocked: true},
				message: "<h3>The game board view</h3>As you play, all events will also be shown here.",
				messageSize: 'medium',
				messagePosition: 'right',
				button: 'What if I miss it?'
			},
			5: {
				highlight: {element: 'game-events-button', blocked: true},
				message: "<h3>The game board view</h3>Luckily, you can also look at all previous events by pressing the 'Game events' button, which brings up a list of all previous events.<br><br>This is also useful when you're coming back to a game after a break.",
				messageSize: 'medium',
				messagePosition: 'above',
				button: 'It certainly is'
			},
			6: {
				highlight: {element: 'game-table', blocked: true},
				message: "<h3>The game board view</h3>The main part of the game board interface is - you guessed it - the game board!",
				messageSize: 'large',
				messagePosition: 'center',
				button: "I like the wooden look."
			},
			7: {
				highlight: {element: 'opponent-slots-container', blocked: true},
				message: "<h3>The game board</h3>We like the wooden look, too!<br><br>On the game board you find the opponent card slots. This is where your opponent's cards will be placed as soon as they place cards in-game.<br><br>This is also where you pick cards when attacking.<br><br>More on attacking cards later.",
				messageSize: 'large',
				messagePosition: 'below',
				button: "What about MY cards?"
			},
			8: {
				highlight: {element: 'player-slots-container', blocked: true},
				message: "<h3>The game board</h3>Of course you will also find card slots for your own cards here.<br><br>When placing cards, you place them on one of the available card slots.<br><br>A card slot is available if there are no creature cards occupying it.<br>You can have up to 5 creature cards in play at any time, and you place your cards during the <strong class='tutorial-phase'>movement phase</strong>.",
				messageSize: 'large',
				messagePosition: 'above',
				button: "Next"
			},
			9: {
				highlight: {element: 'play-area', blocked: true},
				message: "<h3>The game board</h3>Smacked in the middle - like a buffer zone between your cards and your opponent's cards - is the 'Play area'.<br><br>This is where your gold values are shown (which you can click to steal or generate gold - more on that later), and also where any battles play out.",
				messageSize: 'large',
				messagePosition: 'above',
				button: "Ooooh, battles!"
			},
			10: {
				message: "<h3>The game board</h3>But before you can take part in any battles, you need to place your cards. Let's do that!",
				messageSize: 'medium',
				button: "Let's!"
			},
			11: {
				highlight: {element: 'ingame-menu-top', blocked: false, seethrough: true},
				message: "<h3>Game on!</h3>You can bring up your cards by pressing the 'Cards' button at the top. If you have any potions in play, you can click the 'Potions' button to bring them up instead.<br><br><strong>Try bringing up your cards now</strong>",
				messageSize: 'medium',
				messagePosition: 'below',
				cb: function(td) {
					$('game_menu_buttons').hide();
					$('toggle-hand-button').observe('click', function() {
						window.setTimeout(function() {
							Devo.Tutorial.playNextStep();
						}, 1000);
					});
				}
			},
			12: {
				highlight: {element: 'player_stuff', blocked: true},
				message: "<h3>The game board</h3>These are your cards. All the cards you picked in the previous step are shown here, ready for you to place (during the movement phase).<br><br>To place a card, drag it onto an available card slot. It will highlight white if it is available, and highlight red if it is unavailable.",
				messageSize: 'large',
				messagePosition: 'above',
				button: 'Let me place a card',
				cb: function(td) {
					$('game_menu_buttons').show();
					$('toggle-hand-button').stopObserving('click');
					$('toggle-hand-button').observe('click', Devo.Game.toggleHand);
				}
			},
			13: {
				highlight: {element: 'fullscreen-container', blocked: false, seethrough: true},
				message: "<strong>Place a creature card on an available card slot</strong>",
				messageSize: 'small',
				messagePosition: 'center',
				cb: function(td) {
					$('ui').hide();
					$('ingame-menu-top').hide();
					$$('.tutorial').each(Element.remove);
					$$('.card.item').each(Element.hide);
					new PeriodicalExecuter(function(pe) {
						if ($('player-slots').select('.card').size() > 0) {
							pe.stop();
							$$('.card.item').each(Element.show);
							window.setTimeout(function() {
								Devo.Tutorial.playNextStep();
							}, 500);
						}
					}, 1.2);
				}
			},
			14: {
				highlight: {element: 'player_stuff', blocked: true},
				message: "<h3>The game board</h3>Great stuff! Now, some of your creature cards will need to be equipped with item cards. Equipping a creature card with an item card is like equipping a character with a sword, an arrow, a bow, etc. and makes certain attacks more powerful, more special, and more.<br><br>To equip an item card, drag an item card from your hand onto an available item slot for your placed creature card.",
				messageSize: 'large',
				messagePosition: 'above',
				button: 'I wanna try that, too!'
			},
			15: {
				highlight: {element: 'fullscreen-container', blocked: false, seethrough: true},
				message: "Remember: the item slot is placed 'over' a creature card on your slots.<br><br><strong>Equip a character with an item card</strong>",
				messageSize: 'small',
				messagePosition: 'center',
				cb: function(td) {
					$$('.card.item').each(Element.show);
					$$('.tutorial').each(Element.remove);
					$('player_stuff').select('.card.creature').each(Element.hide);
					new PeriodicalExecuter(function(pe) {
						if ($('player-slots').select('.card.item').size() > 0) {
							pe.stop();
							$('ui').show();
							$('player_stuff').select('.card.creature').each(Element.show);
							$('ingame-menu-top').show();
							Devo.Game.toggleHand();
							Devo.Tutorial.playNextStep();
						}
					}, 1);
				}
			},
			16: {
				message: "<h3>The game board</h3><h6>You're already getting the hang of it!</h6>All cards are placed this way. Remember to look at your card's attacks to see which item card is most useful for your creature card.<br><br>You can see the item attack bonus at the bottom of the item card, such as <div style='display: inline-block; width: 60px; padding: 3px; border-radius: 5px; background-color: rgba(0, 0, 0, 0.1); text-align: center; margin: 0 5px; font-weight: bold;'><img src='/images/attack_melee.png'>+15%</div>, meaning the item gives a 15% attack bonus for melee attacks.<br><br>Some item cards - for example the 'Poisoned arrow' card - also has an effect bonus like <div style='display: inline-block; width: 60px; padding: 3px; border-radius: 5px; background-color: rgba(0, 0, 0, 0.1); text-align: center; margin: 0 5px; font-weight: bold;'><img src='/images/attack_poison.png'>+25%</div>. This means that if your attack already generates a poison effect it will be 25% more powerful, but if it doesn't already generate a poison effect it will receive a 25% chance of generating a poison effect when equipped with that item card.",
				messageSize: 'large',
				button: "It's only ... logical"
			},
			17: {
				highlight: {element: 'game_menu_buttons', blocked: true},
				message: "<h3>Playing</h3>A game of Dragon Evo:TCG consists of several rounds, alternating between each players. Each round consists of four phases, <strong>replenishment</strong>, <strong>movements</strong>, <strong>actions</strong> and <strong>resolution</strong>.<br><br>As soon as you are finished with one of these phases, you press the end phase-button highlighted above. It will say 'End movement', 'End actions' or 'End turn', depending on which phase you're currently in.",
				messageSize: 'large',
				messagePosition: 'below',
				button: "Tell me more"
			},
			18: {
				message: "<h3>Playing</h3><h6>Replenishment</h6>This is the first phase of your turn.<br><br>You don't do anything during this phase, but you get your gold depending on the gold income value of your cards in play (indicated by a gold coin with a number on it); damaged cards regain some health and regenerate some magic; and any effects such as fire, dark magic and similar are applied.<br><br>Because some effects cause damage, you may lose cards during the replenishment phase if they lose their last HP because of card effects.<br><br>Don't worry, you won't lose the game if your last card in play dies of an effect during the replenishment phase,<strong> but if you don't have any cards in play <u>at the beginning of your replenishment phase</u>, you lose the game.</strong><br><br>When the 'replenishment' phase is over, you automatically advance to the 'Movement' phase, without pressing any buttons or performing any actions.",
				messageSize: 'large',
				button: "What about the 'Movement phase', then?",
				cb: function(td) {
					[2,3,4].each(function(c) {
						$('end-phase-'+c+'-button').hide();
					});
				}
			},
			19: {
				highlight: {element: 'game_menu_buttons', blocked: true},
				message: "<h3>Playing</h3><h6>Movement</h6>This is the second phase of your turn, and the only phase where you're allowed to place cards onto the board.<br><br>Creature cards placed during this phase are only in play <strong>the next round</strong>, but item cards are put in play immediately after movement ends. This means you cannot attack with a card that has been put in play the same round.<br><br>You can place as many cards as there is room for, but you can only place cards on available card slots.<br><br>The first round - before you've both placed cards for the first time - the button will say 'Cards placed'. Place your cards, and then press this button when you're done.<br><br>If you don't place any cards before your first turn, <strong>you lose the game.</strong>",
				messageSize: 'large',
				messagePosition: 'below',
				button: "Then there is 'actions'?",
				cb: function(td) {
					[2,3,4].each(function(c) {
						(c == 2) ? $('end-phase-'+c+'-button').show() : $('end-phase-'+c+'-button').hide();
					});
				}
			},
			20: {
				highlight: {element: 'game_menu_buttons', blocked: true},
				message: "<h3>Playing</h3><h6>Yes, actions!</h6>This is the third phase of your turn, and the only phase where you're allowed to perform attacks or other actions.<br><br>Creature cards that are in play can perform any available action during this phase, assuming you have actions available.<br><br>Actions are listed on your cards and to perform one, you click the action you want to perform and then click the card you want to attack (in the case of an attack), your gold pile (in the case of 'forage' or 'mining' actions) or the opponents gold pile (in the case of 'steal' actions).<br><br>During this phase, there is an action counter below your 'End actions' button. As soon as you use your last action, your 'Actions' phase ends after 5 seconds.",
				messageSize: 'large',
				messagePosition: 'below',
				button: "Only the 'resolution phase' left, then?",
				cb: function(td) {
					[2,3,4].each(function(c) {
						(c == 3) ? $('end-phase-'+c+'-button').show() : $('end-phase-'+c+'-button').hide();
					});
				}
			},
			21: {
				highlight: {element: 'game_menu_buttons', blocked: true},
				message: "<h3>Playing</h3><h6>Resolution</h6>Resolution is kind of a 'breathing' phase. The 'resolution' phase lasts for 20 seconds, and then the opponent takes his/her turn.<br><br>It's not a phase you can really do anything in, unless you want to spend some potions before your turn ends.",
				messageSize: 'large',
				messagePosition: 'below',
				button: "Potions?!",
				cb: function(td) {
					[2,3,4].each(function(c) {
						(c == 4) ? $('end-phase-'+c+'-button').show() : $('end-phase-'+c+'-button').hide();
					});
				}
			},
			22: {
				highlight: {element: 'toggle-potions-button', blocked: true},
				message: "<h3>Potions</h3>Yes, potions!<br><br>Almost forgot about potions. Potions are special cards you can use to heal your cards, remove effects such as stun, freeze and a lot more.<br><br>Potions can be used at any time, even when it is not your turn, and if you're lucky or quick, you can heal your cards in-between your opponents attacks.<br><br>Having the right and enough potions can really shift the momentum in your favor!<br><br>To use a potion, click the potion card after opening the potions list (see that button above?), and then click the card you want to use it on.<br><br><strong>Easy, peasy!</strong>",
				messageSize: 'large',
				messagePosition: 'below',
				button: "Awesome!",
				cb: function(td) {
					[2,3,4].each(function(c) {
						(c == 2) ? $('end-phase-'+c+'-button').show() : $('end-phase-'+c+'-button').hide();
					});
				}
			},
			23: {
				message: "<h3>That's it</h3>That was a lot, but should have given you enough information to start playing.<br><br>If you're stuck, there's always the lobby just a button away. Don't hesitate to ask other players if you're ever stuck or have a question.<br><br><h6>Have fun playing!</h6>",
				messageSize: 'large',
				button: "I most certainly will!"
			}
		};
		Devo.Tutorial.start('board');
	</script>
<?php endif; ?>
