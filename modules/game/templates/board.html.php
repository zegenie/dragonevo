<?php

	use \application\entities\Game;

?>
<?php if ($game instanceof Game && ($csp_user->isAdmin() || in_array($csp_user->getId(), array($game->getPlayer()->getId(), $game->getOpponentId())))): ?>
	<?php

		$csp_response->setTitle("Game board ~ game vs. {$game->getUserOpponent()->getUsername()}");
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
				<div class="button-container"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?>>
					<a href="javascript:void(0);" id="end-phase-1-button" class="turn-button button button-green<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End replenishment phase</a>
				</div>
			</div>
		</div>
	</div>
	<div id="gameover-overlay" class="fullpage_backdrop" style="<?php if (!$game->isGameOver()): ?>display: none;<?php endif; ?>">
		<div class="fullpage_backdrop_content">
			<div class="summary">
				<h5>Game over</h5>
				<div id="winning_player_<?php echo $game->getPlayer()->getId(); ?>" class="winning" style="<?php if ($game->getWinningPlayerId() != $game->getPlayer()->getId()) echo 'display: none;'; ?>"><?php echo ($game->getPlayer()->getId() == $csp_user->getId()) ? 'You won!' : $game->getPlayer()->getUsername() . ' won!'; ?></div>
				<div id="winning_player_<?php echo $game->getOpponentId(); ?>" class="winning" style="<?php if ($game->getWinningPlayerId() != $game->getOpponentId()) echo 'display: none;'; ?>"><?php echo ($game->getOpponentId() == $csp_user->getId()) ? 'You won!' : $game->getOpponent()->getUsername() . ' won!'; ?></div>
				<div style="text-align: left;">
					<h6>Statistics</h6>
					<div id="game_statistics_indicator" style="<?php if ($game->isGameOver()): ?>display: none;<?php endif; ?>">
						<img src="/images/spinning_30.gif" style="margin-right: 5px;">Loading statistics, please wait
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
						<a href="<?php echo make_url('lobby'); ?>" class="button button-standard">Go to lobby</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="settings-overlay" class="fullpage_backdrop" style="display: none;">
		<div id="settings_backdrop_content" class="fullpage_backdrop_content">
			<div class="summary">
				<h5>Options</h5>
				<form method="post" onsubmit="DETCG.saveOptions();return false;" id="options_form">
					<input type="hidden" name="topic" value="savesettings">
					<dl>
						<dt><label for="options_background_music">Background music</label></dt>
						<dd>
							<input type="radio" value="1" <?php if ($csp_user->isGameMusicEnabled()) echo ' checked'; ?> name="music_enabled" id="options_background_music_enabled"><label for="options_background_music_enabled">Yes</label>&nbsp;
							<input type="radio" value="0" <?php if (!$csp_user->isGameMusicEnabled()) echo ' checked'; ?> name="music_enabled" id="options_background_music_disabled"><label for="options_background_music_disabled">No</label>
						</dd>
						<dt><label for="options_system_chat_messages">System chat messages</label></dt>
						<dd>
							<input type="radio" value="1" <?php if ($csp_user->isSystemChatMessagesEnabled()) echo ' checked'; ?> name="system_chat_messages_enabled" id="options_system_chat_messages_enabled"><label for="options_system_chat_messages_enabled">Yes</label>&nbsp;
							<input type="radio" value="0" <?php if (!$csp_user->isSystemChatMessagesEnabled()) echo ' checked'; ?> name="system_chat_messages_enabled" id="options_system_chat_messages_disabled"><label for="options_system_chat_messages_disabled">No</label><br>
							<div class="faded_out">Show join/leave messages in game chat</div>
						</dd>
					</dl>
					<br style="clear: both;">
					<div style="text-align: center;">
						<a href="#" onclick="Devo.Main.saveSettings();" class="button button-green"><img id="options_waiting" src="images/spinning_16.gif" style="display: none; margin: 3px 5px 0 0; float: left;">Save</a>
						<a href="#" onclick="$('settings-overlay').fade();" class="button button-silver">Cancel</a>
					</div>
				</form>
			</div>
		</div>
		<div style="background-color: #000; width: 100%; height: 100%; position: absolute; top: 0; left: 0; margin: 0; padding: 0; z-index: 999;" class="semi_transparent"> </div>
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
			<div id="player-<?php echo $game->getPlayer()->getId(); ?>-turn" class="animated" style="<?php if ($game->getCurrentPlayerId() != $game->getPlayer()->getId() || $game->getTurnNumber() <= 2) echo 'display: none;'; ?>"><?php echo ($csp_user->getId() == $game->getPlayer()->getId()) ? "It is your turn" : "It is {$game->getPlayer()->getCharactername()}'s turn"; ?></div>
			<div id="player-<?php echo $game->getOpponentId(); ?>-turn" class="animated<?php if ($game->isUserOffline($game->getOpponentId())) echo ' faded'; ?>" style="<?php if ($game->getCurrentPlayerId() != $game->getOpponentId() || $game->getTurnNumber() <= 2) echo 'display: none;'; ?>"><?php echo ($csp_user->getId() == $game->getOpponentId()) ? "It is your turn" : "It is {$game->getOpponent()->getCharactername()}'s turn"; ?></div>
		</div>
		<div id="last-event" class="animated"></div>
		<div style="position: absolute; top: 3px; right: 3px; overflow: visible;" class="button-group">
			<a href="javascript:void(0);" id="toggle-hand-button"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?> class="toggle-button button button-orange" onclick="Devo.Game.toggleHand();">Cards</a>
			<a href="javascript:void(0);" id="toggle-events-button"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?> class="toggle-button button button-orange" onclick="Devo.Game.toggleEvents();">Events</a>
			<a href="javascript:void(0);" id="toggle-events-button" class="button button-silver button-icon last" onclick="Devo.Main.Helpers.popup(this);"><img src="/images/settings_small.png"></a>
			<div class="popup-menu">
				<ul>
					<li><a href="javascript:void(0);" onclick="$('settings-overlay').appear();Devo.Main.Helpers.popup();">Game settings</a></li>
					<li><a href="javascript:void(0);" onclick="Devo.Main.Helpers.Dialog.show('Flee the battle?', 'Quitting the game means you lose, the opponent is awarded battlepoints and XP, and you\'re left with nothing! Not even loot!<br><span class=\'faded_out\'>Actually, the part about loot isn\'t implemented yet, but suddenly it will be and then you\'ll be sorry!</span>', {yes: {href: '<?php echo make_url('leave_game', array('game_id' => $game->getId())); ?>'}, no: {click: function() {Devo.Main.Helpers.Dialog.dismiss();}}});">Leave game</a></li>
					<li><a href="<?php echo make_url('lobby'); ?>">Go to lobby</a></li>
				</ul>
			</div>
		</div>
		<div style="position: absolute; top: 34px; right: 3px;<?php if (!$game->isUserInGame()): ?> display: none;<?php endif; ?>">
			<div id="phase-3-actions" style="<?php if ($game->getTurnNumber() <= 2 || ($game->getCurrentPlayerId() != $csp_user->getId() || $game->getCurrentPhase() != Game::PHASE_ACTION)): ?>display: none;<?php endif; ?>">Actions remaining: <span id="phase-3-actions-remaining"><?php echo ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() == Game::PHASE_ACTION) ? $game->getCurrentPlayerActions() : 0; ?></span></div>
			<a href="javascript:void(0);" id="end-phase-2-button" class="turn-button button button-green<?php if (($game->getTurnNumber() > 2 && $game->getCurrentPlayerId() != $csp_user->getId()) || !$game->canUserMove($csp_user->getId())) echo ' disabled'; ?>" style="<?php if (!$game->canUserMove($csp_user->getId()) && $game->getTurnNumber() > 2): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="<?php if ($game->canUserMove($csp_user->getId()) || $game->getTurnNumber() > 2): ?>display: none;<?php endif; ?>"><span class="place-cards-content"<?php if ($game->getTurnNumber() > 2): ?> style="display: none;"<?php endif; ?>><?php echo ($game->canUserMove($csp_user->getId())) ? 'Finished placing cards' : 'Waiting for opponent'; ?></span><span class="end-phase-content"<?php if ($game->getTurnNumber() <= 2): ?> style="display: none;"<?php endif; ?>>End movement</span></a>
			<a href="javascript:void(0);" id="end-phase-3-button" class="turn-button button button-green<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" style="<?php if ($game->getTurnNumber() <= 2 || $game->getCurrentPlayerId() != $csp_user->getId() || $game->getCurrentPhase() != Game::PHASE_ACTION): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End actions</a>
			<a href="javascript:void(0);" id="end-phase-4-button" class="turn-button button button-green<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" style="<?php if ($game->getTurnNumber() <= 2 || ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() != Game::PHASE_RESOLUTION)): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End turn</a>
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
	<div id="player_stuff" onclick="Devo.Game.toggleHand();"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?>>
		<?php if ($game->isUserInGame()) include_component('game/playerhand', compact('game')); ?>
	</div>
	<div id="player_potions"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?>>
		<h5>Potions</h5>
		<?php if ($game->isUserInGame()) include_component('game/playerpotions', compact('game')); ?>
	</div>
	<form id="chat_rooms_joined" action="<?php echo make_url('ask'); ?>" method="post">
	</form>
	<div id="game_chat" class="<?php if (!$csp_user->isSystemChatMessagesEnabled()) echo ' no_system_chat'; ?>" onmouseover="window.setTimeout(function() { $('chat_room_<?php echo $game->getChatRoom()->getId(); ?>_input').focus(); })" onmouseout="window.setTimeout(function() { $('chat_room_<?php echo $game->getChatRoom()->getId(); ?>_lines').scrollTop = $('chat_room_<?php echo $game->getChatRoom()->getId(); ?>_lines').scrollHeight; }, 1500);">
		<?php include_component('lobby/chatroom', array('room' => $game->getChatRoom())); ?>
	</div>
	<div id="game_events" class="animated fadeOut" onclick="Devo.Game.toggleEvents();">
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
				current_turn: <?php echo $game->getTurnNumber(); ?>,
				current_phase: <?php echo $game->getCurrentPhase(); ?>,
				current_player_id: <?php echo $game->getCurrentPlayerId(); ?>,
				movable: <?php echo ($game->canUserMove($csp_user->getId())) ? 'true' : 'false'; ?>,
				actions: <?php echo ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() == Game::PHASE_ACTION) ? 'true' : 'false'; ?>,
				music_enabled: <?php echo ($csp_user->isGameMusicEnabled()) ? 'true' : 'false'; ?>,
				actions_remaining: <?php echo ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() == Game::PHASE_ACTION) ? $game->getCurrentPlayerActions() : 0; ?>
				});
			});
	</script>
<?php else: ?>
	<?php

		$csp_response->setTitle("Game board");

	?>
	<div style="color: #FFF; text-align: center; width: 500px; margin: 150px 0 0 -250px; font-size: 1.5em; font-family: 'Amaranth'; left: 50%; position: absolute;">This game doesn't exist<br><span style="font-weight: normal; font-size: 0.7em;">or you don't have access to see it</span></div>
<?php endif; ?>