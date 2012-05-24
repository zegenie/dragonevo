<?php

	$csp_response->setTitle('Lobby');
	$csp_response->addStylesheet('/css/animate.css');

?>
<div class="content">
	<?php include_template('lobby/gameinvites'); ?>
	<div class="profile_header">
		<img src="/images/avatars/<?php echo $csp_user->getAvatar(); ?>" class="avatar">
		<h1><?php echo $csp_user->getName(); ?></h1>
		<div class="summary">Level <?php echo $csp_user->getLevel(); ?></div>
	</div>
	<div class="lobby_game_actions">
		<button class="button button-standard quickmatch" onclick="Devo.Main.Helpers.Message.success('Ooops!', 'It would be cool if this button worked, now, wouldn\'t it!');">Play quickmatch</button>
		<button class="button button-lightblue play_story" onclick="Devo.Main.Helpers.Message.success('Ooops!', 'Yeah, this doesn\'t work either');">Play story</button>
		<button class="button button-lightblue single_quest" onclick="Devo.Main.Helpers.Message.success('Ooops!', 'Really, you thought this would work?');">Single quest</button>
	</div>
	<form id="chat_rooms_joined" action="<?php echo make_url('ask'); ?>" method="post">
	</form>
	<div class="lobby_chat" id="lobby_chat">
		<?php include_component('lobby/chatroom'); ?>
	</div>
	<br style="clear: both;">
</div>