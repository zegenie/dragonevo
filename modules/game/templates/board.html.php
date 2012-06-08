<?php if ($game instanceof application\entities\Game): ?>
	<?php

		$csp_response->setTitle('Game board ~ game vs. '.$game->getUserOpponent()->getUsername());
		$csp_response->addStylesheet('/css/animate.css');
		$csp_response->addJavascript('/js/jquery-1.7.2.min.js');

	?>
	<script>
		jQuery.noConflict();
	</script>
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
			<div id="player-<?php echo $game->getPlayer()->getId(); ?>-turn" class="animated" style="<?php if ($game->getCurrentPlayerId() != $game->getPlayer()->getId()) echo 'display: none;'; ?>">It is <?php echo $game->getPlayer()->getUsername(); ?>'s turn</div>
			<div id="player-<?php echo $game->getOpponent()->getId(); ?>-turn" class="animated" style="<?php if ($game->getCurrentPlayerId() != $game->getOpponent()->getId()) echo 'display: none;'; ?>">It is <?php echo $game->getOpponent()->getUsername(); ?>'s turn</div>
		</div>
		<div style="position: absolute; top: 5px; right: 5px;">
			<a href="javascript:void(0);" id="toggle-hand-button" class="button button-orange" onclick="Devo.Game.toggleHand();">Show my hand</a>
			<a href="javascript:void(0);" id="toggle-events-button" class="button button-orange" onclick="Devo.Game.toggleEvents();">Show events</a>
			<a href="javascript:void(0);" id="end-turn-button" class="button button-green<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" onclick="Devo.Game.endTurn(this);"><img src="/images/spinning_16.gif" style="display: none;">End turn</a>
		</div>
	</div>
	<div id="game-table">
		<div id="opponent-slots-container" class="card-slots-container">
			<ul id="opponent-slots" class="card-slots">
				<li id="opponent-slot-1" class="card-slot opponent"><?php include_template('game/card', array('card' => $game->getUserOpponentCardSlot(1))); ?></li>
				<li id="opponent-slot-2" class="card-slot opponent"><?php include_template('game/card', array('card' => $game->getUserOpponentCardSlot(2))); ?></li>
				<li id="opponent-slot-3" class="card-slot opponent"><?php include_template('game/card', array('card' => $game->getUserOpponentCardSlot(3))); ?></li>
				<li id="opponent-slot-4" class="card-slot opponent"><?php include_template('game/card', array('card' => $game->getUserOpponentCardSlot(4))); ?></li>
				<li id="opponent-slot-5" class="card-slot opponent"><?php include_template('game/card', array('card' => $game->getUserOpponentCardSlot(5))); ?></li>
			</ul>
		</div>
		<div id="play-area">
			<div id="event-slot" class="card-slot"></div>
		</div>
		<div id="player-slots-container" class="card-slots-container">
			<ul id="player-slots" class="card-slots">
				<li id="player-slot-1" class="card-slot player"><?php include_template('game/card', array('card' => $game->getUserPlayerCardSlot(1))); ?></li>
				<li id="player-slot-2" class="card-slot player"><?php include_template('game/card', array('card' => $game->getUserPlayerCardSlot(2))); ?></li>
				<li id="player-slot-3" class="card-slot player"><?php include_template('game/card', array('card' => $game->getUserPlayerCardSlot(3))); ?></li>
				<li id="player-slot-4" class="card-slot player"><?php include_template('game/card', array('card' => $game->getUserPlayerCardSlot(4))); ?></li>
				<li id="player-slot-5" class="card-slot player"><?php include_template('game/card', array('card' => $game->getUserPlayerCardSlot(5))); ?></li>
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
				movable: <?php echo ($game->getCurrentPlayerId() != $csp_user->getId()) ? 'true' : 'false'; ?>
				});
			});
	</script>
<?php else: ?>
	<div style="color: #FFF; text-align: center; width: 500px; margin: 150px 0 0 -250px; font-size: 1.5em; font-family: 'Amaranth'; left: 50%; position: absolute;">This game doesn't exist</div>
<?php endif; ?>
