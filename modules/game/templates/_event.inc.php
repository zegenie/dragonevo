<?php

	use application\entities\GameEvent;

?>
<?php if ($event instanceof GameEvent): ?>
	<div id="event_<?php echo $event->getId(); ?>_container">
		<?php if (!in_array($event->getEventType(), array(GameEvent::TYPE_END_ATTACK))): ?>
			<?php $today = (date('dmy', $event->getCreatedAt()) == date('dmy')); ?>
			<time pubdate="">[<?php if ($today) echo 'Today, '; ?><?php echo date(!$today ? 'd.m - H:i:s' : 'H:i:s', $event->getCreatedAt()); ?>]</time>&nbsp;
			<?php

			$data = json_decode($event->getEventData(), true);
			$is_current_player = ($data['player_id'] == $csp_user->getId());
			switch ($event->getEventType()) {
				case GameEvent::TYPE_RESTORE_HEALTH:
					//echo "{$data['attacked_card_name']} restores {$data['hp']['diff']} HP from {$data['attacking_card_name']}";
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
					if (array_key_exists('part_id', $data) && $data['part_id']) {
						echo "Opponent is thinking ...";
					} else {
						echo "{$data['player_name']} is thinking ...";
					}
					break;
				case GameEvent::TYPE_PLAYER_CHANGE:
                    echo "It is now {$data['player_name']}'s turn";
					break;
				case GameEvent::TYPE_PHASE_CHANGE:
					switch ($data['old_phase']) {
						case application\entities\Game::PHASE_REPLENISH:
                            echo "{$data['player_name']} is now moving cards";
							break;
						case application\entities\Game::PHASE_MOVE:
                            echo "{$data['player_name']} is now performing actions";
							break;
						case application\entities\Game::PHASE_ACTION:
                            echo "{$data['player_name']} is now finishing their turn";
							break;
						case application\entities\Game::PHASE_RESOLUTION:
                            echo "{$data['player_name']}'s turn ended";
							break;
					}
					break;
				case GameEvent::TYPE_GAME_CREATED:
					echo "The game was created";
					break;
				case GameEvent::TYPE_GAME_OVER:
					echo "The game has ended";
					break;
				case GameEvent::TYPE_INVITATION_ACCEPTED:
                    echo "{$data['player_name']} accepted the game invitation";
					break;
				case GameEvent::TYPE_CARD_MOVED_ONTO_SLOT:
                    echo "{$data['player_name']} moved {$data['card_name']} onto slot {$data['slot']}";
					break;
				case GameEvent::TYPE_CARD_MOVED_OFF_SLOT:
                    echo "{$data['player_name']} moved {$data['card_name']} off slot {$data['slot']}";
					break;
				case GameEvent::TYPE_CARD_REMOVED:
					echo "{$data['card_name']} is eliminated!";
					break;
				case GameEvent::TYPE_ATTACK:
					if (array_key_exists('class', $data) && $data['class'] == 'potion') {
						echo "{$data['attacked_card_name']} drinks {$data['attacking_card_name']} potion";
					} else {
                        echo "Your {$data['attacking_card_name']} attacks {$data['attacked_card_name']}";
					}
					break;
				case GameEvent::TYPE_END_ATTACK:
					echo "{$data['attacking_card_name']}'s attack on {$data['attacked_card_name']} ends";
					break;
				case GameEvent::TYPE_STEAL_MAGIC:
                    echo "{$data['attacking_card_name']} steals {$data['amount']['diff']} EP from your {$data['attacked_card_name']}!";
					break;
				case GameEvent::TYPE_STEAL_GOLD:
                    echo "{$data['attacking_card_name']} steals {$data['amount']['diff']} gold from you!";
					break;
				case GameEvent::TYPE_STEAL_GOLD_FAILED:
                    echo "{$data['attacking_card_name']} attempted to steal gold from you but failed!";
					break;
				case GameEvent::TYPE_GENERATE_GOLD:
                    echo "{$data['attacking_card_name']} generates {$data['amount']['diff']} gold from {$data['attack_name']}!";
					break;
				case GameEvent::TYPE_DAMAGE:
					if ($data['damage_type'] == 'effect') {
						echo "{$data['attack_name']} causes {$data['attacked_card_name']} to lose {$data['hp']['diff']} HP";
					} else {
						echo "{$data['attacked_card_name']} loses {$data['hp']['diff']} HP";
					}
					break;
				case application\entities\GameEvent::TYPE_REPLENISH:
                    echo "{$data['player_name']} is replenishing their resources!";
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
		<?php endif; ?>
	</div>
<?php endif; ?>
