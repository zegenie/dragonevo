<div class="chat_room">
	<?php if ($room->getId() > 1): ?>
		<header>
			<subject><?php echo $room->getTopic(); ?></subject>
		</header>
	<?php endif; ?>
	<div class="users_header"><span id="chat_room_<?php echo $room->getId(); ?>_num_users">-</span> user(s) here, <span id="chat_room_<?php echo $room->getId(); ?>_num_ingame_users">-</span> in games:</div>
	<div class="chat_room_loading" id="chat_room_<?php echo $room->getId(); ?>_loading" style="display: none;"><img src="/images/spinning_30.gif"></div>
	<div class="chat_room_users" id="chat_room_<?php echo $room->getId(); ?>_users"><div id="chat_room_<?php echo $room->getId(); ?>_users_loading" data-user-id="0">Loading ...</div></div>
	<div class="chat_room_lines" id="chat_room_<?php echo $room->getId(); ?>_lines"></div>
</div>
<div id="chat_room_<?php echo $room->getId(); ?>_form_container" class="chat_room_form_container">
	<form class="chat_input" action="<?php echo make_url('room_say', array('room_id' => $room->getId())); ?>" onsubmit="Devo.Chat.say(this);return false;" id="chat_room_<?php echo $room->getId(); ?>_form" style="position: relative; margin-top: 5px;">
		<input type="text" name="text" autocomplete="off" id="chat_room_<?php echo $room->getId(); ?>_input">
		<input type="submit" value="Say" style="float: right;" id="chat_room_<?php echo $room->getId(); ?>_say_button" class="button button-standard">
		<img src="/images/spinning_16.gif" style="display: none;" id="chat_room_<?php echo $room->getId(); ?>_indicator">
	</form>
</div>
<script>
	Devo.Core.Events.listen('devo:core:initialized', function(options) {
		Devo.Chat.joinRoom(<?php echo $room->getId(); ?>);
	});
</script>