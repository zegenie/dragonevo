<?php

	$csp_response->setTitle('Lobby');
	$csp_response->addStylesheet('/css/animate.css');

?>
<div id="quickmatch_overlay" class="fullpage_backdrop" style="display: none;">
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
<div class="content">
	<?php include_template('lobby/gameinvites'); ?>
	<div class="profile_header">
		<img src="/images/avatars/<?php echo $csp_user->getAvatar(); ?>" class="avatar">
		<h1><?php echo $csp_user->getName(); ?></h1>
		<div class="summary">Level <?php echo $csp_user->getLevel(); ?></div>
	</div>
	<div class="lobby_game_actions">
		<button class="button button-standard quickmatch" id="quickmatch_button" onclick="Devo.Play.quickmatch();"><div class="tooltip">Battle it out against a randomly chosen opponent!</div>Play quickmatch</button>
		<button class="button button-lightblue play_story disabled" onclick="Devo.Main.Helpers.Message.success('Not implemented yet', 'This feature has not yet been implemented');" disabled><div class="tooltip">Start or continue your journey through the Dragon Evo story!<br><br>Not implemented yet!</div>Play story</button>
		<button class="button button-lightblue single_quest disabled" onclick="Devo.Main.Helpers.Message.success('Not implemented yet', 'This feature has not yet been implemented');" disabled><div class="tooltip">Replay any of your completed quest from story mode!<br><br>Not implemented yet!</div>Single quest</button>
		<br style="clear: both;">
		<h3>My ongoing games</h3>
		<form id="my_ongoing_games_form">
			<ul id="my_ongoing_games" class="my_games">
				<?php if (count($games)): ?>
					<?php foreach ($games as $game): ?>
						<?php include_template('lobby/game', compact('game')); ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<li class="faded_out" id="my_ongoing_games_none"<?php if (count($games)): ?> style="display: none;"<?php endif; ?>>You are not currently playing any games</li>
			</ul>
		</form>
	</div>
	<form id="chat_rooms_joined" action="<?php echo make_url('ask'); ?>" method="post">
	</form>
	<div class="lobby_chat" id="lobby_chat">
		<?php include_component('lobby/chatroom'); ?>
	</div>
	<br style="clear: both;">
</div>
<script>
	Devo.Core.Events.listen('devo:core:initialized', function(options) {
		Devo.Main.initializeLobby();
	});
</script>