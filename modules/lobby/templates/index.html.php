<?php

	$csp_response->setTitle('Lobby');
	$csp_response->addStylesheet('/css/animate.css');
	$faction_names = array('resistance' => 'Hologev', 'neutrals' => 'Highwinds', 'rutai' => 'Rutai');

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
	<div id="devo-logo">
		<a class="devo-box" href="<?php echo make_url('home'); ?>">
			DRAGON EVO<br>
			<span class="slogan">the online action card game</span>
		</a>
	</div>
	<?php include_template('lobby/gameinvites'); ?>
	<?php include_template('main/profilemenu'); ?>
	<?php /* <div class="lobby_game_actions">
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
	</div> */ ?>
	<form id="chat_rooms_joined" action="<?php echo make_url('ask'); ?>" method="post"></form>
	<div class="lobby_chat swirl-dialog" id="lobby_chat">
		<?php include_component('lobby/chatroom'); ?>
	</div>
	<br style="clear: both;">
</div>
<script>
	Devo.Core.Events.listen('devo:core:initialized', function(options) {
		Devo.Main.initializeLobby();
	});
</script>