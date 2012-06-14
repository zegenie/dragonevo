<?php

	use application\entities\GameEvent;

?>
<?php if ($event instanceof GameEvent): ?>

	<div id="event_<?php echo $event->getId(); ?>_container">
		<time pubdate="">[<?php echo date('H:i:s', $event->getCreatedAt()); ?>]</time>&nbsp;
		<?php

		$data = json_decode($event->getEventData(), true);
		$is_current_player = ($data['player_id'] == $csp_user->getId());
		switch ($event->getEventType()) {
			case GameEvent::TYPE_PLAYER_CHANGE:
				if ($is_current_player) {
					echo "It is now your turn";
				} else {
					echo "It is now {$data['player_name']}'s turn";
				}
				break;
			case GameEvent::TYPE_PHASE_CHANGE:
				switch ($data['old_phase']) {
					case application\entities\Game::PHASE_REPLENISH:
						if ($is_current_player) {
							echo "You are now moving cards";
						} else {
							echo "{$data['player_name']} is now moving cards";
						}
						break;
					case application\entities\Game::PHASE_MOVE:
						if ($is_current_player) {
							echo "You are now performing actions";
						} else {
							echo "{$data['player_name']} is now performing actions";
						}
						break;
					case application\entities\Game::PHASE_ACTION:
						if ($is_current_player) {
							echo "You are now finishing your turn";
						} else {
							echo "{$data['player_name']} is now finishing his/her turn";
						}
						break;
					case application\entities\Game::PHASE_RESOLUTION:
						if ($is_current_player) {
							echo "Your turn ended";
						} else {
							echo "{$data['player_name']}'s turn ended";
						}
						break;
				}
				break;
			case GameEvent::TYPE_GAME_CREATED:
				echo "The game was created";
				break;
			case GameEvent::TYPE_INVITATION_ACCEPTED:
				if ($is_current_player) {
					echo "You accepted the game invitation";
				} else {
					echo "{$data['player_name']} accepted the game invitation";
				}
				break;
			case GameEvent::TYPE_CARD_MOVED_ONTO_SLOT:
				if ($is_current_player) {
					echo "You moved {$data['card_name']} onto slot {$data['slot']}";
				} else {
					if ($data['in_play']) {
						echo "{$data['player_name']} moved {$data['card_name']} onto slot {$data['slot']}";
					} else {
						echo "{$data['player_name']} moved a card onto slot {$data['slot']}";
					}
				}
				break;
			case application\entities\GameEvent::TYPE_REPLENISH:
				if ($is_current_player) {
					echo "Your resources replenishes!";
				} else {
					echo "{$data['player_name']} is replenishing his/her resources!";
				}
				break;
			default:
				echo $event->getEventType();
		}

		?>
	</div>
<?php endif; ?>