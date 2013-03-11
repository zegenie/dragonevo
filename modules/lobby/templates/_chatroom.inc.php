<div class="border-dialog chat_room_container<?php if (!$csp_user->isSystemChatMessagesEnabled()) echo ' no_system_chat'; ?>" id="chat_<?php echo $room->getId(); ?>_container" style="display: none;" data-room-id="<?php echo $room->getId(); ?>">
	<img class="border top-left" src="/images/ui_border_corner_top_left.png">
	<img class="border top-right" src="/images/ui_border_corner_top_right.png">
	<img class="border bottom-right" src="/images/ui_border_corner_bottom_right.png">
	<img class="border bottom-left" src="/images/ui_border_corner_bottom_left.png">
	<div class="border stretch top"></div>
	<div class="border stretch right"></div>
	<div class="border stretch bottom"></div>
	<div class="border stretch left"></div>
	<div class="background-underlay"></div>
	<div class="dialog-content">
		<div class="chat_room" id="chat_room_<?php echo $room->getId(); ?>_container">
			<div class="users_header<?php if ($room->getId() > 1) echo ' game-chat'; ?>"><span id="chat_room_<?php echo $room->getId(); ?>_num_users">-</span> user(s) online (<span id="chat_room_<?php echo $room->getId(); ?>_num_ingame_users">-</span> in games):</div>
			<div class="chat_room_loading" id="chat_room_<?php echo $room->getId(); ?>_loading" style="display: none;"><img src="/images/spinning_30.gif"></div>
			<div class="chat_room_users<?php if ($room->getId() > 1) echo ' game-chat'; ?>" id="chat_room_<?php echo $room->getId(); ?>_users"><div id="chat_room_<?php echo $room->getId(); ?>_users_loading" data-user-id="0">Loading ...</div></div>
			<div class="chat_room_lines" id="chat_room_<?php echo $room->getId(); ?>_lines"></div>
		</div>
		<div id="chat_room_<?php echo $room->getId(); ?>_form_container" class="chat_room_form_container">
			<form class="chat_input" action="<?php echo make_url('room_say', array('room_id' => $room->getId())); ?>" onsubmit="Devo.Chat.say(this);return false;" id="chat_room_<?php echo $room->getId(); ?>_form" style="position: relative; margin-top: 2px;">
				<input type="text" name="text" autocomplete="off" id="chat_room_<?php echo $room->getId(); ?>_input">
				<input type="submit" value="Say" style="float: right;" id="chat_room_<?php echo $room->getId(); ?>_say_button" class="button button-standard">
				<img src="/images/spinning_16.gif" style="display: none;" id="chat_room_<?php echo $room->getId(); ?>_indicator">
			</form>
		</div>
	</div>
</div>
