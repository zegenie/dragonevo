<div class="chat_room">
	<header><?php echo $room->getTopic(); ?></header>
	<div class="chat_room_lines" id="chat_room_<?php echo $room->getId(); ?>_lines"></div>
</div>
<form class="chat_input" action="<?php echo make_url('say', array('room_id' => $room->getId())); ?>" onsubmit="Devo.Chat.say(this);return false;" id="chat_room_<?php echo $room->getId(); ?>_form" style="position: relative;">
	<input type="text" style="width: 650px;" name="text">
	<img src="/images/spinning_16.gif" style="position: absolute; z-index: 100; left: 637px; top: 4px;" id="chat_room_<?php echo $room->getId(); ?>_indicator">
	<input type="submit" value="Say" style="width: 50px;" class="button button-standard">
</form>