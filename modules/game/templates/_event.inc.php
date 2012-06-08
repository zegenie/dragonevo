<?php

	use application\entities\GameEvent;

?>
<?php if ($event instanceof GameEvent): ?>
<div id="event_<?php echo $event->getId(); ?>_container">
	<time pubdate=""><?php echo date('H:i:s', $event->getCreatedAt()); ?></time>
	<?php

	$data = json_decode($event->getEventData(), true);
	switch ($event->getEventType()) {
		case GameEvent::TYPE_PLAYER_CHANGE:
			echo "It is now {$data['player_name']}'s turn";
			break;
		case GameEvent::TYPE_GAME_CREATED:
			echo "The game was created";
			break;
		case GameEvent::TYPE_INVITATION_ACCEPTED:
			echo "{$data['player_name']} accepted the game invitation";
			break;
	}

	?>
</div>
<?php endif; ?>