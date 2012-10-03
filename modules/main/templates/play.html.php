<?php 

	$csp_response->setTitle('Play Dragon Evo:TCG');
//	$faction_names = array('resistance' => 'Hologev', 'neutrals' => 'Highwinds', 'rutai' => 'Rutai');

?>
<a href="javascript:void(0);" onclick="Devo.Core.toggleFullscreen();" id="toggle-fullscreen-button" class="button button-silver button-icon" style="display: none;">Toggle fullscreen</a>
<div id="play-menu" class="swirl-dialog">
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
	<img src="/images/avatars/avatar_<?php echo rand(1,5); ?>.png" class="avatar">
	<div id="play-menu-main">
		<button class="button button-lightblue multiplayer" id="toggle-playmenu-button" onclick="$('play-menu-main').toggle();$('play-menu-play').toggle();"><div class="tooltip">Battle it out against random opponents or your friends!</div>Multiplayer</button>
		<a href="<?php echo make_url('lobby'); ?>" class="button button-green"><div class="tooltip">Join the action in the lobby, where all the other players hang out</div>Enter the lobby</a>
		<button class="button button-silver singleplayer" onclick="$('play-menu-main').toggle();$('play-menu-single').toggle();"><div class="tooltip">Play through the story, or repeat previous quests</div>Single player</button>
		<button class="button button-silver training" onclick="$('play-menu-main').toggle();$('play-menu-train').toggle();"><div class="tooltip">Practice your skills and techniques against an AI opponent</div>Training</button>
		<a href="<?php echo make_url('home'); ?>" class="button button-silver exit"><div class="tooltip">Leave the game<br><br>Sad face :(</div>Exit</a>
	</div>
	<div id="play-menu-play" style="display: none;">
		<button class="button button-standard quickmatch" id="quickmatch_button" onclick="Devo.Play.quickmatch();"><div class="tooltip">Battle it out against a randomly chosen opponent!</div>Play quickmatch</button>
		<button class="button button-lightblue custom_game disabled" onclick="Devo.Main.Helpers.Message.success('Not implemented yet', 'This feature has not yet been implemented');" disabled><div class="tooltip">Play a game against one of your friends!<br><br>Not implemented yet!</div>Challenge a friend</button>
		<button class="button button-lightblue play_friend disabled" onclick="Devo.Main.Helpers.Message.success('Not implemented yet', 'This feature has not yet been implemented');" disabled><div class="tooltip">Set up a game with custom settings!<br><br>Not implemented yet!</div>Custom game</button>
		<button class="button button-silver back" onclick="$('play-menu-play').toggle();$('play-menu-main').toggle();">&laquo;&nbsp;Back</button>
	</div>
	<div id="play-menu-single" style="display: none;">
		<button class="button button-lightblue play_story disabled" onclick="Devo.Main.Helpers.Message.success('Not implemented yet', 'This feature has not yet been implemented');" disabled><div class="tooltip">Start or continue your journey through the Dragon Evo story!<br><br>Not implemented yet!</div>Play story</button>
		<button class="button button-lightblue single_quest disabled" onclick="Devo.Main.Helpers.Message.success('Not implemented yet', 'This feature has not yet been implemented');" disabled><div class="tooltip">Replay any of your completed quest from story mode!<br><br>Not implemented yet!</div>Single quest</button>
		<button class="button button-silver back" onclick="$('play-menu-single').toggle();$('play-menu-main').toggle();">&laquo;&nbsp;Back</button>
	</div>
	<div id="play-menu-train" style="display: none;">
		<a href="<?php echo make_url('training', array('level' => 1)); ?>" class="button button-silver"><div class="tooltip">Training match vs. an easy opponent<br><br>Crush him like the tiny bug he is!</div>Easy training</a>
		<a href="<?php echo make_url('training', array('level' => 2)); ?>" class="button button-silver"><div class="tooltip">Training match vs. an skilled opponent<br><br>Tickle your greys!</div>Skilled training</a>
		<a href="<?php echo make_url('training', array('level' => 3)); ?>" class="button button-silver"><div class="tooltip">Training match vs. an expert opponent<br><br>You will be crushed again and again, and it will be painful.</div>Expert training</a>
		<button class="button button-silver back" onclick="$('play-menu-train').toggle();$('play-menu-main').toggle();">&laquo;&nbsp;Back</button>
	</div>
	<br style="clear: both;">
	<div id="play-version">
		Version 0.1.5.0<br>
		&copy; The Dragon Evo team
	</div>
</div>
<script>
	Devo.Core.Events.listen('devo:core:initialized', function(options) {
		$('fullpage_backdrop').hide();
		if (Devo.Core.detectFullScreenSupport()) {
			$('toggle-fullscreen-button').appear();
		}
	});
</script>