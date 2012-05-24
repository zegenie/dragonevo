<div class="chat_room">
	<header><?php echo $room->getTopic(); ?></header>
	<div class="chat_room_loading" id="chat_room_<?php echo $room->getId(); ?>_loading"><img src="/images/spinning_30.gif"></div>
	<div class="chat_room_lines" id="chat_room_<?php echo $room->getId(); ?>_lines"></div>
</div>
<form class="chat_input" action="<?php echo make_url('say', array('room_id' => $room->getId())); ?>" onsubmit="Devo.Chat.say(this);return false;" id="chat_room_<?php echo $room->getId(); ?>_form" style="position: relative; margin-top: 5px;">
	<input type="text" style="width: 650px;" name="text">
	<img src="/images/spinning_16.gif" style="position: absolute; z-index: 100; left: 637px; top: 4px; display: none;" id="chat_room_<?php echo $room->getId(); ?>_indicator">
	<input type="submit" value="Say" style="width: 50px; float: right;" class="button button-standard">
</form>
<script>
	document.observe('dom:loaded', function() {
		Devo.Chat.joinRoom(<?php echo $room->getId(); ?>);
	});
</script>