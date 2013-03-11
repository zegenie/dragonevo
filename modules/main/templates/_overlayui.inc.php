<?php 

	use application\entities\Game;

?>
<div id="ui" style="display: none;">
	<?php include_component('lobby/chatroom'); ?>
	<?php include_template('main/gameinvites'); ?>
	<div class="profile_menu" id="profile-menu-strip">
		<img id="main-menu-badge" class="badge" src="/images/ui_bottom_center_small.png" onclick="Devo.Main.showMenu();">
		<div style="background-image: url('/images/avatars/<?php echo $csp_user->getAvatar(); ?>')" class="avatar mine" id="avatar-player"></div>
		<div style="display: none;" class="avatar opponent" id="avatar-opponent"></div>
		<div class="strip">
			<ul id="profile_menu_strip">
				<li id="show-menu-button" onclick="Devo.Main.showMenu();" class="ui_button menu-button">Menu</li>
				<li id="play-quickmatch-button" onclick="Devo.Play.quickmatch();" class="ui_button quickmatch-button">Play quickmatch</li>
				<li id="chat_1_toggler" class="ui_button" onclick="Devo.Game.toggleChat(1);">Lobby<span class="notify"> *</span></li>
				<li onclick="Devo.Game.toggleEvents();" class="ui_button toggle-events-button" id="game-events-button">Game events</li>
			</ul>
		</div>
	</div>
	<form id="chat_rooms_joined" action="<?php echo make_url('ask'); ?>" method="post"></form>
</div>
