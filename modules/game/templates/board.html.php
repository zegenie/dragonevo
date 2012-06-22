<?php

	use \application\entities\Game;

?>
<?php if ($game instanceof Game && in_array($csp_user->getId(), array($game->getPlayer()->getId(), $game->getOpponent()->getId()))): ?>
	<?php

		$csp_response->setTitle('Game board ~ game vs. '.$game->getUserOpponent()->getUsername());
		$csp_response->addStylesheet('/css/animate.css');
		//$csp_response->addJavascript('/js/jquery-1.7.2.min.js');

	?>
	<div id="phase-1-overlay" class="fullpage_backdrop" style="<?php if ($game->getCurrentPlayerId() != $csp_user->getId() || $game->getCurrentPhase() != Game::PHASE_REPLENISH): ?>display: none;<?php endif; ?>">
		<div id="fullpage_backdrop_content" class="fullpage_backdrop_content">
			<div class="summary">
				<h5>Gold</h5>
				<div class="game-gold">
					<img src="/images/gold.png">
					<div class="gold" id="replenish_gold_summary"><?php echo $game->getUserPlayerGold(); ?></div>
				</div>
				<div class="button-container">
					<a href="javascript:void(0);" id="end-phase-1-button" class="turn-button button button-green<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End replenishment phase</a>
				</div>
			</div>
		</div>
	</div>
	<div id="gameover-overlay" class="fullpage_backdrop" style="<?php if (!$game->isGameOver()): ?>display: none;<?php endif; ?>">
		<div id="fullpage_backdrop_content" class="fullpage_backdrop_content">
			<div class="summary">
				<h5>Game over</h5>
				<div id="winning_player_<?php echo $game->getPlayer()->getId(); ?>" class="winning" style="<?php if ($game->getWinningPlayerId() != $game->getPlayer()->getId()) echo 'display: none;'; ?>"><?php echo ($game->getPlayer()->getId() == $csp_user->getId()) ? 'You won!' : $game->getPlayer()->getUsername() . ' won!'; ?></div>
				<div id="winning_player_<?php echo $game->getOpponent()->getId(); ?>" class="winning" style="<?php if ($game->getWinningPlayerId() != $game->getOpponent()->getId()) echo 'display: none;'; ?>"><?php echo ($game->getOpponent()->getId() == $csp_user->getId()) ? 'You won!' : $game->getOpponent()->getUsername() . ' won!'; ?></div>
				<div style="text-align: left;">
					<h6>Statistics</h6>
					<div id="game_statistics_indicator" style="<?php if ($game->isGameOver()): ?>display: none;<?php endif; ?>">>
						<img src="/images/spinning_30.gif" style="margin-right: 5px;">Loading statistics, please wait
					</div>
					<div id="game_statistics" style="<?php if (!$game->isGameOver()): ?>display: none;<?php endif; ?>">
						<strong>Damage inflicted:</strong>&nbsp;<span id="statistics_hp"><?php echo $statistics['hp']; ?></span>HP<br>
						<strong>Cards killed:</strong>&nbsp;<span id="statistics_cards"><?php echo $statistics['cards']; ?></span>
					</div>
					<div class="button-container">
						<a href="<?php echo make_url('lobby'); ?>" class="button button-standard">End game</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="game-menu">
		<div id="game-opponent">
			<div class="game-name">
				<?php if ($game->isPvP()): ?>
					<?php echo $game->getPlayer()->getUsername(); ?>
					<span class="versus_versus">versus</span>
					<?php echo $game->getOpponent()->getUsername(); ?>
				<?php else: ?>
					<?php echo $game->getName(); ?>
				<?php endif; ?>
			</div>
			<?php if (!$game->isPvp()): ?>
				<div class="tooltip from-above">Scenario description goes here</div>
			<?php endif; ?>
		</div>
		<div id="turn-info">
			<div id="player-<?php echo $game->getPlayer()->getId(); ?>-turn" class="animated" style="<?php if ($game->getCurrentPlayerId() != $game->getPlayer()->getId()) echo 'display: none;'; ?>"><?php echo ($csp_user->getId() == $game->getPlayer()->getId()) ? "It is your turn" : "It is {$game->getPlayer()->getUsername()}'s turn"; ?></div>
			<div id="player-<?php echo $game->getOpponent()->getId(); ?>-turn" class="animated" style="<?php if ($game->getCurrentPlayerId() != $game->getOpponent()->getId()) echo 'display: none;'; ?>"><?php echo ($csp_user->getId() == $game->getOpponent()->getId()) ? "It is your turn" : "It is {$game->getOpponent()->getUsername()}'s turn"; ?></div>
		</div>
		<div id="last-event" class="animated"></div>
		<div style="position: absolute; top: 5px; right: 5px;" class="button_group">
			<a href="javascript:void(0);" id="toggle-hand-button" class="toggle-button button button-orange" onclick="Devo.Game.toggleHand();">Show my hand</a>
			<a href="javascript:void(0);" id="toggle-events-button" class="toggle-button button button-orange" onclick="Devo.Game.toggleEvents();">Show events</a>
		</div>
		<div style="position: absolute; top: 32px; right: 5px;">
			<div id="phase-3-actions" style="<?php if ($game->getCurrentPlayerId() != $csp_user->getId() || $game->getCurrentPhase() != Game::PHASE_ACTION): ?>display: none;<?php endif; ?>">Actions remaining: <span id="phase-3-actions-remaining"><?php echo ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() == Game::PHASE_ACTION) ? $game->getCurrentPlayerActions() : 0; ?></span></div>
			<a href="javascript:void(0);" id="end-phase-2-button" class="turn-button button button-green<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" style="<?php if ($game->getCurrentPlayerId() != $csp_user->getId() || $game->getCurrentPhase() != Game::PHASE_MOVE): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End movement phase</a>
			<a href="javascript:void(0);" id="end-phase-3-button" class="turn-button button button-green<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" style="<?php if ($game->getCurrentPlayerId() != $csp_user->getId() || $game->getCurrentPhase() != Game::PHASE_ACTION): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End actions phase</a>
			<a href="javascript:void(0);" id="end-phase-4-button" class="turn-button button button-green<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" style="<?php if ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() != Game::PHASE_RESOLUTION): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End turn</a>
			<div id="game-countdown" style="display: none;">
				<div class="countdown_content"></div>
			</div>
		</div>
	</div>
	<div id="game-table">
		<div id="opponent-slots-container" class="card-slots-container">
			<ul id="opponent-slots" class="card-slots">
				<?php for ($cc = 5; $cc >= 1; $cc--): ?>
					<li id="opponent-slot-<?php echo $cc; ?>"
						class="card-slot opponent"
						data-slot-no="<?php echo $cc; ?>"
						data-card-id="<?php echo $game->getUserOpponentCardSlotId($cc); ?>"
						data-powerup-slot1-card-id="<?php echo $game->getUserOpponentCardSlotPowerupCard1Id($cc); ?>"
						data-powerup-slot2-card-id="<?php echo $game->getUserOpponentCardSlotPowerupCard2Id($cc); ?>">
							<?php include_template('game/card', array('card' => $game->getUserOpponentCardSlot($cc), 'mode' => 'medium')); ?>
							<?php include_template('game/card', array('card' => $game->getUserOpponentCardSlotPowerupCard1($cc), 'mode' => 'medium')); ?>
							<?php include_template('game/card', array('card' => $game->getUserOpponentCardSlotPowerupCard2($cc), 'mode' => 'medium')); ?>
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
						class="card-slot player"
						data-slot-no="<?php echo $cc; ?>"
						data-card-id="<?php echo $game->getUserPlayerCardSlotId($cc); ?>"
						data-powerup-slot1-card-id="<?php echo $game->getUserPlayerCardSlotPowerupCard1Id($cc); ?>"
						data-powerup-slot2-card-id="<?php echo $game->getUserPlayerCardSlotPowerupCard2Id($cc); ?>">
							<?php include_template('game/card', array('card' => $game->getUserPlayerCardSlot($cc), 'mode' => 'medium')); ?>
							<?php include_template('game/card', array('card' => $game->getUserPlayerCardSlotPowerupCard1($cc), 'mode' => 'medium')); ?>
							<?php include_template('game/card', array('card' => $game->getUserPlayerCardSlotPowerupCard2($cc), 'mode' => 'medium')); ?>
					</li>
				<?php endfor; ?>
			</ul>
		</div>
	</div>
	<div id="player_stuff" onclick="Devo.Game.toggleHand();">
		<?php include_component('game/playerhand', compact('game')); ?>
	</div>
	<form id="chat_rooms_joined" action="<?php echo make_url('ask'); ?>" method="post">
	</form>
	<div id="game_chat" onmouseover="window.setTimeout(function() { $('chat_room_<?php echo $game->getChatRoom()->getId(); ?>_input').focus(); })" onmouseout="window.setTimeout(function() { $('chat_room_<?php echo $game->getChatRoom()->getId(); ?>_lines').scrollTop = $('chat_room_<?php echo $game->getChatRoom()->getId(); ?>_lines').scrollHeight; }, 1500);">
		<?php include_component('lobby/chatroom', array('room' => $game->getChatRoom())); ?>
	</div>
	<div id="game_events" class="animated fadeOut">
		<div id="game_event_contents">
			<?php foreach ($game->getEvents() as $event_id => $event): ?>
				<?php include_template('game/event', compact('event')); ?>
			<?php endforeach; ?>
		</div>
	</div>
	<script>
		Devo.Core.Events.listen('devo:core:initialized', function(options) {
			Devo.Game.initialize({
				game_id: <?php echo $game->getId(); ?>,
				latest_event_id: <?php echo $event_id; ?>,
				movable: <?php echo ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() == Game::PHASE_MOVE) ? 'true' : 'false'; ?>,
				actions: <?php echo ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() == Game::PHASE_ACTION) ? 'true' : 'false'; ?>,
				actions_remaining: <?php echo ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() == Game::PHASE_ACTION) ? $game->getCurrentPlayerActions() : 0; ?>
				});
			});
	</script>
<?php else: ?>
	<div style="color: #FFF; text-align: center; width: 500px; margin: 150px 0 0 -250px; font-size: 1.5em; font-family: 'Amaranth'; left: 50%; position: absolute;">This game doesn't exist<br><span style="font-weight: normal; font-size: 0.7em;">or you don't have access to see it</span></div>
<?php endif; ?>