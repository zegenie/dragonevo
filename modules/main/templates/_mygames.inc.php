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
