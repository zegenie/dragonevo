<?php 

	$csp_response->setTitle('Play Dragon Evo:TCG');
	include_template('main/overlayui');

?>
<div id="quickmatch_overlay" class="fullpage_backdrop dark" style="display: none;">
	<div class="fullpage_backdrop_content">
		<div id="finding_opponent">
			<?php echo image_tag('/images/spinner.png'); ?><br>
			<?php echo __('Please wait, finding opponent ...'); ?>
			<br style="clear: both;">
			<div style="float: right; margin: 20px; clear: both;">
				<button class="button button-standard" id="cancel_quickmatch_button" onclick="Devo.Play.cancelQuickmatch();" style="opacity: 0;">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div id="settings-overlay" class="fullpage_backdrop dark" style="display: none;">
	<div id="settings_backdrop_content" class="fullpage_backdrop_content">
		<div class="swirl-dialog summary">
			<img src="/images/swirl_top_right.png" class="swirl top-right">
			<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
			<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
			<img src="/images/swirl_top_left.png" class="swirl top-left">
			<h1>Options</h1>
			<form method="post" onsubmit="DETCG.saveOptions();return false;" id="options_form">
				<input type="hidden" name="topic" value="savesettings">
				<dl>
					<dt><label for="options_background_music">Background music</label></dt>
					<dd>
						<input type="radio" value="1" <?php if ($csp_user->isGameMusicEnabled()) echo ' checked'; ?> name="music_enabled" id="options_background_music_enabled"><label for="options_background_music_enabled">Yes</label>&nbsp;
						<input type="radio" value="0" <?php if (!$csp_user->isGameMusicEnabled()) echo ' checked'; ?> name="music_enabled" id="options_background_music_disabled"><label for="options_background_music_disabled">No</label>
					</dd>
					<dt><label for="options_system_chat_messages">System chat messages</label></dt>
					<dd>
						<input type="radio" value="1" <?php if ($csp_user->isSystemChatMessagesEnabled()) echo ' checked'; ?> name="system_chat_messages_enabled" id="options_system_chat_messages_enabled"><label for="options_system_chat_messages_enabled">Yes</label>&nbsp;
						<input type="radio" value="0" <?php if (!$csp_user->isSystemChatMessagesEnabled()) echo ' checked'; ?> name="system_chat_messages_enabled" id="options_system_chat_messages_disabled"><label for="options_system_chat_messages_disabled">No</label><br>
						<div class="faded_out">Show join/leave messages in game chat</div>
					</dd>
				</dl>
				<br style="clear: both;">
				<div style="text-align: center;">
					<a href="#" onclick="Devo.Main.saveSettings();" class="button button-green"><img id="options_waiting" src="images/spinning_16.gif" style="display: none; margin: 3px 5px 0 0; float: left;">Save</a>
					<a href="#" onclick="$('settings-overlay').fade();" class="button button-silver">Cancel</a>
				</div>
			</form>
		</div>
	</div>
	<div style="background-color: #000; width: 100%; height: 100%; position: absolute; top: 0; left: 0; margin: 0; padding: 0; z-index: 999;" class="semi_transparent"> </div>
</div>
<div id="gamemenu-container" style="display: none;" class="fullpage_backdrop dark">
	<a href="javascript:void(0);" onclick="Devo.Core.toggleFullscreen();" id="toggle-fullscreen-button" class="button button-silver button-icon" style="display: none;">Toggle fullscreen</a>
	<div id="play-menu" class="swirl-dialog<?php /* if (isset($game)): ?> ingame<?php endif; */ ?>">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<div style="position: relative;">
			<a class="devo-box" href="<?php echo make_url('home'); ?>">
				DRAGON EVO<br>
				<span class="slogan">the online action card game</span>
			</a>
		</div>
		<div class="avatar" style="background-image: url('/images/avatars/avatar_3.png');"></div>
		<div id="play-menu-main">
			<div id="play-menu-setup" <?php if ($csp_user->hasCharacter() && $csp_user->hasCards()): ?>style="display: none;"<?php endif; ?>>
				<button class="button button-green multiplayer settings" onclick="Devo.Main.loadProfile();" id="show-profile-button">Setup my profile</button>
				<button class="button button-silver settings" onclick="$('settings-overlay').toggle();">Game settings</button>
			</div>
			<div id="play-menu-generic" <?php if (!$csp_user->hasCharacter() || !$csp_user->hasCards()): ?>style="display: none;"<?php endif; ?>>
				<button class="button button-lightblue multiplayer" id="toggle-playmenu-button" onclick="$('play-menu-main').toggle();$('play-menu-play').toggle();">Multiplayer</button>
				<button class="button button-green" onclick="Devo.Main.loadLobby();$('gamemenu-container').hide();" id="enter-lobby-button">Enter the lobby</button>
				<button class="button button-silver singleplayer" onclick="$('play-menu-main').toggle();$('play-menu-single').toggle();">Single player</button>
				<button class="button button-silver training" onclick="$('play-menu-main').toggle();$('play-menu-train').toggle();">Training</button>
				<button class="button button-silver settings" onclick="$('settings-overlay').toggle();">Game settings</button>
				<button class="button button-silver settings" onclick="Devo.Main.loadProfile();" id="show-profile-button">My profile</button>
				<button class="button button-silver" style="display: none;" onclick="$('gamemenu-container').toggle();" id="close-menu-button">Close menu</button>
			</div>
			<div id="play-menu-ingame" style="display: none;">
				<button class="button button-green" onclick="$('gamemenu-container').toggle();">Resume game</button>
				<button class="button button-silver settings" onclick="$('settings-overlay').toggle();">Settings</button>
				<button class="button button-silver" onclick="Devo.Game.destroyGame();">Go to the lobby</a>
				<button class="button button-silver exit" onclick="Devo.Main.Helpers.Dialog.show('Flee the battle?', 'Quitting the game means you lose, the opponent is awarded battlepoints and XP, and you\'re left with nothing! Not even loot!<br><span class=\'faded_out\'>Actually, the part about loot isn\'t implemented yet, but suddenly it will be and then you\'ll be sorry!</span>', {yes: {click: function() {Devo.Game.flee(); }}, no: {click: function() {Devo.Main.Helpers.Dialog.dismiss();}}});" id="leave-game-button">Leave game</button>
			</div>
			<a href="<?php echo make_url('home'); ?>" class="button button-silver exit">Exit</a>
		</div>
		<div id="play-menu-play" style="display: none;">
			<button class="button button-standard quickmatch" id="quickmatch_button" onclick="Devo.Play.quickmatch();$('gamemenu-container').toggle();">Play quickmatch</button>
			<button class="button button-lightblue custom_game disabled" onclick="Devo.Main.Helpers.Message.success('Not implemented yet', 'This feature has not yet been implemented');" disabled>Challenge a friend</button>
			<button class="button button-lightblue play_friend disabled" onclick="Devo.Main.Helpers.Message.success('Not implemented yet', 'This feature has not yet been implemented');" disabled>Custom game</button>
			<button class="button button-silver back" onclick="$('play-menu-play').toggle();$('play-menu-main').toggle();">&laquo;&nbsp;Back</button>
		</div>
		<div id="play-menu-single" style="display: none;">
			<button class="button button-lightblue play_story disabled" onclick="Devo.Main.Helpers.Message.success('Not implemented yet', 'This feature has not yet been implemented');" disabled>Play story</button>
			<button class="button button-lightblue single_quest disabled" onclick="Devo.Main.Helpers.Message.success('Not implemented yet', 'This feature has not yet been implemented');" disabled>Single quest</button>
			<button class="button button-silver back" onclick="$('play-menu-single').toggle();$('play-menu-main').toggle();">&laquo;&nbsp;Back</button>
		</div>
		<div id="play-menu-train" style="display: none;">
			<a href="javascript:void(0);" onclick="Devo.Play.training(1);" class="button button-silver">Easy training</a>
			<a href="javascript:void(0);" onclick="Devo.Play.training(2);" class="button button-silver">Skilled training</a>
			<a href="javascript:void(0);" onclick="Devo.Play.training(3);" class="button button-silver">Expert training</a>
			<button class="button button-silver back" onclick="$('play-menu-train').toggle();$('play-menu-main').toggle();">&laquo;&nbsp;Back</button>
		</div>
		<br style="clear: both;">
		<div id="play-version">
			<a href="<?php echo make_url('changelog'); ?>">Version alpha-<?php echo $csp_response->getVersion(); ?></a><br>
			&copy; Magical Pictures / zegenie studios
		</div>
	</div>
</div>
<div id="game-content-container">
</div>
<script>
	Devo.Core.Events.listen('devo:core:initialized', function(options) {
		$('fullpage_backdrop').hide();
		if (Devo.Core.detectFullScreenSupport()) {
			$('toggle-fullscreen-button').appear();
		}
		Devo.Main.showMenu();
	});
</script>