<?php

	$csp_response->setTitle('Lobby');
	$csp_response->addStylesheet('/css/animate.css');
	$faction_names = array('resistance' => 'Hologev', 'neutrals' => 'Highwinds', 'rutai' => 'Rutai');

?>
<div class="content">
	<?php include_template('lobby/gameinvites'); ?>
	<div class="lobby_game_actions">
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
	<?php include_template('main/profilemenu'); ?>
	<form id="chat_rooms_joined" action="<?php echo make_url('ask'); ?>" method="post"></form>
	<br style="clear: both;">
</div>
<script>
	Devo.Core.Events.listen('devo:core:initialized', function(options) {
		Devo.Main.initializeLobby();
	});
</script>