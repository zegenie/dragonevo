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
			case GameEvent::TYPE_RESTORE_HEALTH:
				echo "{$data['attacked_card_name']} restores {$data['hp']['diff']} HP from {$data['attacking_card_name']}";
				break;
			case GameEvent::TYPE_RESTORE_ENERGY:
				echo "{$data['attacked_card_name']} restores {$data['ep']['diff']} EP from {$data['attacking_card_name']}";
				break;
			case GameEvent::TYPE_PLAYER_OFFLINE:
				echo "{$data['changed_player_name']} went offline";
				break;
			case GameEvent::TYPE_PLAYER_ONLINE:
				echo "{$data['changed_player_name']} is now online";
				break;
			case GameEvent::TYPE_THINKING:
				echo "{$data['player_name']} is thinking ...";
				break;
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
							echo "{$data['player_name']} is now finishing their turn";
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
			case GameEvent::TYPE_GAME_CREATED:
				echo "The game has ended";
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
			case GameEvent::TYPE_CARD_MOVED_OFF_SLOT:
				if ($is_current_player) {
					echo "You moved {$data['card_name']} off slot {$data['slot']}";
				} else {
					echo "{$data['player_name']} moved {$data['card_name']} off slot {$data['slot']}";
				}
				break;
			case GameEvent::TYPE_CARD_REMOVED:
				echo "{$data['card_name']} is eliminated!";
				break;
			case GameEvent::TYPE_ATTACK:
				if ($is_current_player) {
					echo "Your {$data['attacking_card_name']} attacks {$data['attacked_card_name']}";
				} else {
					echo "Your {$data['attacked_card_name']} is attacked by {$data['attacking_card_name']}";
				}
				break;
			case GameEvent::TYPE_STEAL_MAGIC:
				if ($is_current_player) {
					echo "Your {$data['attacking_card_name']} steals {$data['amount']['diff']} EP from {$data['attacked_card_name']}!";
				} else {
					echo "{$data['attacking_card_name']} steals {$data['amount']['diff']} EP from your {$data['attacked_card_name']}!";
				}
				break;
			case GameEvent::TYPE_STEAL_GOLD:
				if ($is_current_player) {
					echo "Your {$data['attacking_card_name']} steals {$data['amount']['diff']} gold!";
				} else {
					echo "{$data['attacking_card_name']} steals {$data['amount']['diff']} gold from you!";
				}
				break;
			case GameEvent::TYPE_GENERATE_GOLD:
				if ($is_current_player) {
					echo "Your {$data['attacking_card_name']} generates {$data['amount']['diff']} gold from {$data['attack_name']}!";
				} else {
					echo "{$data['attacking_card_name']} generates {$data['amount']['diff']} gold from {$data['attack_name']}!";
				}
				break;
			case GameEvent::TYPE_DAMAGE:
				if ($data['damage_type'] == 'effect') {
					echo "{$data['attack_name']} causes {$data['attacked_card_name']} to lose {$data['hp']['diff']} HP";
				} else {
					echo "{$data['attacked_card_name']} loses {$data['hp']['diff']} HP";
				}
				break;
			case application\entities\GameEvent::TYPE_REPLENISH:
				if ($is_current_player) {
					echo "Your resources replenishes!";
				} else {
					echo "{$data['player_name']} is replenishing their resources!";
				}
				break;
			case GameEvent::TYPE_APPLY_EFFECT:
				switch ($data['effect']) {
					case application\entities\ModifierEffect::TYPE_AIR:
						echo "{$data['attacked_card_name']} is affected by air magic for {$data['duration']} turn(s)!";
						break;
					case application\entities\ModifierEffect::TYPE_DARK:
						echo "{$data['attacked_card_name']} is affected by dark magic for {$data['duration']} turn(s)!";
						break;
					case application\entities\ModifierEffect::TYPE_FIRE:
						echo "{$data['attacked_card_name']} has caught on fire for {$data['duration']} turn(s)!";
						break;
					case application\entities\ModifierEffect::TYPE_FREEZE:
						echo "{$data['attacked_card_name']} is frozen for {$data['duration']} turn(s)!";
						break;
					case application\entities\ModifierEffect::TYPE_POISON:
						echo "{$data['attacked_card_name']} has been poisoned for {$data['duration']} turn(s)!";
						break;
					case application\entities\ModifierEffect::TYPE_STUN:
						echo "{$data['attacked_card_name']} has been stunned for {$data['duration']} turn(s)!";
						break;
				}
				break;
			case GameEvent::TYPE_REMOVE_EFFECT:
				switch ($data['effect']) {
					case application\entities\ModifierEffect::TYPE_AIR:
						echo "{$data['attacked_card_name']} is no longer affected by air magic!";
						break;
					case application\entities\ModifierEffect::TYPE_DARK:
						echo "{$data['attacked_card_name']} is no longer affected by dark magic!";
						break;
					case application\entities\ModifierEffect::TYPE_FIRE:
						echo "{$data['attacked_card_name']} is no longer caught on fire!";
						break;
					case application\entities\ModifierEffect::TYPE_FREEZE:
						echo "{$data['attacked_card_name']} is no longer frozen!";
						break;
					case application\entities\ModifierEffect::TYPE_POISON:
						echo "{$data['attacked_card_name']} is no longer poisoned!";
						break;
					case application\entities\ModifierEffect::TYPE_STUN:
						echo "{$data['attacked_card_name']} is no longer stunned!";
						break;
				}
				break;
			default:
				echo $event->getEventType();
		}

		?>
	</div>
<?php endif; ?>