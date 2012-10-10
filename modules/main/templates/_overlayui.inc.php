<?php 

	use application\entities\Game;

?>
<div id="ui" style="display: none;">
	<?php include_component('lobby/chatroom'); ?>
	<?php include_template('main/gameinvites'); ?>
	<div class="profile_menu" id="profile-menu-strip">
		<div style="background-image: url('/images/avatars/<?php echo $csp_user->getAvatar(); ?>')" class="avatar mine" id="avatar-player"></div>
		<div style="display: none;" class="avatar opponent" id="avatar-opponent"></div>
		<div class="strip">
			<div id="profile_menu_buttons" class="button-group">
				<button onclick="Devo.Main.showMenu();" class="button button-standard">Menu</button>
			</div>
			<ul id="profile_menu_strip">
				<li id="chat_1_toggler" onclick="Devo.Game.toggleChat(1);">Lobby<span class="notify"> *</span></li>
			</ul>
		</div>
	</div>
	<form id="chat_rooms_joined" action="<?php echo make_url('ask'); ?>" method="post"></form>
</div>
