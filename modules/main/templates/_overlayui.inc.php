<?php 

	use application\entities\Game;

?>
<div id="ui" style="display: none;">
	<?php include_component('lobby/chatroom'); ?>
	<?php include_template('main/gameinvites'); ?>
	<div class="profile_menu" id="profile-menu-strip">
		<img id="main-menu-badge" class="badge" src="/images/ui_bottom_center_small.png" onclick="Devo.Main.showMenu();">
		<div style="background-image: url('/images/avatars/<?php echo $csp_user->getAvatar(); ?>')" class="avatar mine" id="avatar-player" onclick="Devo.Main.Profile.show(<?php echo $csp_user->getId(); ?>);"></div>
		<div style="display: none;" class="avatar opponent" id="avatar-opponent"></div>
		<div class="strip">
			<ul id="profile_menu_strip">
				<li id="show-menu-button" onclick="Devo.Main.showMenu();" class="ui_button menu-button">Menu</li>
				<li id="play-quickmatch-button" onclick="Devo.Main.Helpers.popup(this);" class="ui_button quickmatch-button">Play a game</li>
				<div class="popup-menu" style="bottom: 25px; left: 85px; right: auto;">
					<ul>
						<li><a href="javascript:void(0);" onclick="Devo.Main.Helpers.Backdrop.show('<?php echo make_url('get_backdrop_partial', array('key' => 'invitefriend')); ?>');Devo.Main.Helpers.popup($('play-quickmatch-button'));return false;">Invite a friend</a></li>
						<li><a href="javascript:void(0);" onclick="Devo.Play.quickmatch();Devo.Main.Helpers.popup($('play-quickmatch-button'));return false;">Play a random opponent</a></li>
						<li><a href="javascript:void(0);" onclick="Devo.Main.loadAdventureUI();Devo.Main.Helpers.popup($('play-quickmatch-button'));return false;">Singleplayer adventure</a></li>
					</ul>
				</div>
				<li id="chat_1_toggler" class="ui_button" onclick="Devo.Game.toggleChat(1);">Lobby<span class="notify"> *</span></li>
				<li onclick="Devo.Game.toggleEvents();" class="ui_button toggle-events-button" id="game-events-button">Game events</li>
			</ul>
		</div>
	</div>
	<form id="chat_rooms_joined" action="<?php echo make_url('ask'); ?>" method="post"></form>
</div>
