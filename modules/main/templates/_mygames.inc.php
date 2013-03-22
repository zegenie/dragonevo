<div id="my_invitations_container">
	<h3>Game invites</h3>
	<ul class="my_games" id="game_invites">
		<?php foreach ($game_invites as $invite): ?>
			<li id="game_invite_<?php echo $invite->getId(); ?>">
				<button class="ui_button button-accept" onclick="Devo.Play.acceptInvite(<?php echo $invite->getId(); ?>, $(this));"><img src="/images/spinning_16.gif" style="display: none;">Accept</button>
				<button class="ui_button button-reject" onclick="Devo.Play.rejectInvite(<?php echo $invite->getId(); ?>, $(this));"><img src="/images/spinning_16.gif" style="display: none;">Reject</button>
				<div class="versus_player">
					versus<br>
					<span class="player_name"><?php echo $invite->getFromPlayer()->getCharactername(); ?></span>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<div id="no_invites" style="<?php if (count($game_invites) > 0) echo 'display: none;'; ?>" class="faded_out">Noone has invited you yet</div>
</div>
<br>
<div id="my_ongoing_games_container">
	<h3>My ongoing games</h3>
	<ul id="my_ongoing_games" class="my_games">
		<?php if (count($games)): ?>
			<?php foreach ($games as $game): ?>
				<?php include_template('lobby/game', compact('game')); ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<li class="faded_out" id="my_ongoing_games_none"<?php if (count($games)): ?> style="display: none;"<?php endif; ?>>You are not currently playing any games</li>
	</ul>
</div>
<br>
