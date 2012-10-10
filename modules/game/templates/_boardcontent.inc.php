<?php

	use \application\entities\Game;

?>
<?php if ($game instanceof Game && ($csp_user->isAdmin() || in_array($csp_user->getId(), array($game->getPlayer()->getId(), $game->getOpponentId())))): ?>
	<?php

		$csp_response->setTitle("Game board ~ game vs. {$game->getUserOpponent()->getUsername()}");
		$csp_response->addStylesheet('/css/animate.css');

	?>
	<div id="board-container">
		<div id="phase-1-overlay" class="fullpage_backdrop dark" style="display: none;"><a href="javascript:void(0);" id="end-phase-1-button" class="turn-button button button-green<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End replenishment phase</a></div>
		<div id="gameover-overlay" class="fullpage_backdrop dark" style="<?php if (!$game->isGameOver()): ?>display: none;<?php endif; ?>">
			<div class="fullpage_backdrop_content">
				<div class="swirl-dialog summary">
					<img src="/images/swirl_top_right.png" class="swirl top-right">
					<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
					<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
					<img src="/images/swirl_top_left.png" class="swirl top-left">
					<h1>Game over</h1>
					<div id="winning_player_<?php echo $game->getPlayer()->getId(); ?>" class="winning" style="<?php if ($game->getWinningPlayerId() != $game->getPlayer()->getId()) echo 'display: none;'; ?>"><?php echo ($game->getPlayer()->getId() == $csp_user->getId()) ? 'You won!' : $game->getPlayer()->getUsername() . ' won!'; ?></div>
					<div id="winning_player_<?php echo $game->getOpponentId(); ?>" class="winning" style="<?php if ($game->getWinningPlayerId() != $game->getOpponentId()) echo 'display: none;'; ?>"><?php echo ($game->getOpponentId() == $csp_user->getId()) ? 'You won!' : $game->getOpponent()->getUsername() . ' won!'; ?></div>
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
						<div class="button-container">
							<button class="button button-silver" onclick="Devo.Game.destroyGame();">Go to the lobby</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="game-menu">
			<div id="game-opponent">
				<div class="game-name">
					<?php if (!$game->isScenario()): ?>
						<span id="player-<?php echo $game->getPlayer()->getId(); ?>-name" class="<?php if ($game->isUserOffline($game->getPlayer()->getId())) echo ' offline'; ?>">
							<?php echo $game->getPlayer()->getCharactername(); ?>
							<span class="tooltip from-above">The player is currently offline</span>
						</span>
						<span class="versus_versus">versus</span>
						<span id="player-<?php echo $game->getOpponentId(); ?>-name" class="<?php if (!$game->getOpponent()->isAI() && $game->isUserOffline($game->getOpponentId())) echo ' offline'; ?>">
							<?php echo $game->getOpponent()->getCharactername(); ?>
							<?php if (!$game->getOpponent()->isAI()): ?>
								<span class="tooltip from-above">The player is currently offline</span>
							<?php endif; ?>
						</span>
					<?php else: ?>
						<?php echo $game->getName(); ?>
					<?php endif; ?>
				</div>
				<?php if ($game->isScenario()): ?>
					<div class="tooltip from-above">Scenario description goes here</div>
				<?php endif; ?>
			</div>
			<div id="turn-info">
				<div id="place_cards" class="animated" style="<?php if ($game->getTurnNumber() > 2 || !$game->isUserInGame()) echo 'display: none;'; ?>">Place your cards</div>
				<div id="player-<?php echo $game->getPlayer()->getId(); ?>-turn" class="turn-info animated" style="<?php if ($game->getCurrentPlayerId() != $game->getPlayer()->getId() || $game->getTurnNumber() <= 2) echo 'display: none;'; ?>"><?php echo ($csp_user->getId() == $game->getPlayer()->getId()) ? "It is your turn" : "It is {$game->getPlayer()->getCharactername()}'s turn"; ?></div>
				<div id="player-<?php echo $game->getOpponentId(); ?>-turn" class="turn-info animated<?php if ($game->isUserOffline($game->getOpponentId())) echo ' faded'; ?>" style="<?php if ($game->getCurrentPlayerId() != $game->getOpponentId() || $game->getTurnNumber() <= 2) echo 'display: none;'; ?>"><?php echo ($csp_user->getId() == $game->getOpponentId()) ? "It is your turn" : "It is {$game->getOpponent()->getCharactername()}'s turn"; ?></div>
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
								<?php include_template('game/card', array('card' => $game->getUserOpponentCardSlot($cc), 'mode' => 'medium', 'ingame' => true)); ?>
								<div id="opponent-slot-<?php echo $cc; ?>-item-slot-1"
									class="card-slot item-slot opponent slot-<?php echo $cc; ?>"
									data-slot-no="<?php echo $cc; ?>"
									data-card-id="<?php echo $game->getUserOpponentCardSlotPowerupCard1Id($cc); ?>">
										<?php include_template('game/card', array('card' => $game->getUserOpponentCardSlotPowerupCard1($cc), 'mode' => 'medium', 'ingame' => true)); ?>
								</div>
								<div id="opponent-slot-<?php echo $cc; ?>-item-slot-2"
									class="card-slot item-slot opponent slot-<?php echo $cc; ?>"
									data-slot-no="<?php echo $cc; ?>"
									data-card-id="<?php echo $game->getUserOpponentCardSlotPowerupCard2Id($cc); ?>">
										<?php include_template('game/card', array('card' => $game->getUserOpponentCardSlotPowerupCard2($cc), 'mode' => 'medium', 'ingame' => true)); ?>
								</div>
							</li>
						<?php endfor; ?>
					</ul>
				</div>
				<div id="play-area">
					<div id="event-slot" class="card-slot"></div>
					<div id="game-gold" class="game-gold" data-amount="<?php echo $game->getUserPlayerGold(); ?>">
						<img src="/images/gold.png">
						<div id="game-gold-amount" class="gold"><?php echo $game->getUserPlayerGold(); ?></div>
					</div>
				</div>
				<div id="player-slots-container" class="card-slots-container">
					<ul id="player-slots" class="card-slots">
						<?php for ($cc = 1; $cc <= 5; $cc++): ?>
							<li id="player-slot-<?php echo $cc; ?>"
								class="card-slot creature-slot player slot-<?php echo $cc; ?>"
								data-slot-no="<?php echo $cc; ?>"
								data-card-id="<?php echo $game->getUserPlayerCardSlotId($cc); ?>">
								<?php include_template('game/card', array('card' => $game->getUserPlayerCardSlot($cc), 'mode' => 'medium', 'ingame' => true)); ?>
								<div id="player-slot-<?php echo $cc; ?>-item-slot-1"
									class="card-slot item-slot player slot-<?php echo $cc; ?>"
									data-slot-no="<?php echo $cc; ?>"
									data-card-id="<?php echo $game->getUserPlayerCardSlotPowerupCard1Id($cc); ?>">
										<?php include_template('game/card', array('card' => $game->getUserPlayerCardSlotPowerupCard1($cc), 'mode' => 'medium', 'ingame' => true)); ?>
								</div>
								<div id="player-slot-<?php echo $cc; ?>-item-slot-2"
									class="card-slot item-slot player slot-<?php echo $cc; ?>"
									data-slot-no="<?php echo $cc; ?>"
									data-card-id="<?php echo $game->getUserPlayerCardSlotPowerupCard2Id($cc); ?>">
										<?php include_template('game/card', array('card' => $game->getUserPlayerCardSlotPowerupCard2($cc), 'mode' => 'medium', 'ingame' => true)); ?>
								</div>
							</li>
						<?php endfor; ?>
					</ul>
				</div>
			</div>
		</div>
		<div id="player_stuff" onclick="Devo.Game.toggleHand();"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?>>
			<?php if ($game->isUserInGame()) include_component('game/playerhand', compact('game')); ?>
		</div>
		<div id="player_potions"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?>>
			<h5>Potions</h5>
			<?php if ($game->isUserInGame()) include_component('game/playerpotions', compact('game')); ?>
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