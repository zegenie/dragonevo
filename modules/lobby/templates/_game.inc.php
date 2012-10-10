<li id="game_<?php echo $game->getId(); ?>_list">
	<input type="hidden" name="games[<?php echo $game->getId(); ?>]" value="<?php echo $game->getId(); ?>">
	<div class="tooltip">
		<div class="game_tooltip_versus">
			<?php echo $game->getPlayer()->getUsername(); ?>&nbsp;<span class="game_tooltip_versus_versus">vs.</span>&nbsp;<?php echo $game->getOpponent()->getUsername(); ?>
		</div>
		<div class="game_tooltip_turn">
			<span id="game_<?php echo $game->getId(); ?>_player_turn"<?php if (!$game->isInvitationConfirmed() || !$game->isPlayerTurn()): ?> style="display: none;"<?php endif; ?>>It is <?php echo $game->getPlayer()->getUsername(); ?>'s turn</span>
			<span id="game_<?php echo $game->getId(); ?>_opponent_turn"<?php if (!$game->isInvitationConfirmed() || !$game->isOpponentTurn()): ?> style="display: none;"<?php endif; ?>>It is <?php echo $game->getOpponent()->getUsername(); ?>'s turn</span>
			<span id="game_<?php echo $game->getId(); ?>_invitation_unconfirmed"<?php if ($game->isInvitationConfirmed() && !$game->isInvitationRejected()): ?> style="display: none;"<?php endif; ?>>Not ready to start the game - still waiting for <?php echo $game->getOpponent()->getUsername(); ?> to accept the invitation</span>
			<span id="game_<?php echo $game->getId(); ?>_invitation_rejected"<?php if (!$game->isInvitationRejected()): ?> style="display: none;"<?php endif; ?>><?php echo $game->getOpponent()->getUsername(); ?> rejected the invitation</span>
		</div>
	</div>
	<button class="button button-standard button-play<?php if (!$game->isInvitationConfirmed()) echo ' disabled'; ?>" onclick="if (!$(this).hasClassName('disabled')) { Devo.Game.initializeGame(<?php echo $game->getId(); ?>);}return false;">Play</button>
	<button class="button button-standard button-cancel" onclick="Devo.Play.cancelGame(<?php echo $game->getId(); ?>);return false;" style="<?php if ($game->isInvitationConfirmed()) echo 'display: none;'; ?>"><img src="/images/spinning_16.gif" style="display: none;">Cancel</button>
	<button class="button button-standard button-ok" onclick="Devo.Play.cancelGame(<?php echo $game->getId(); ?>);return false;" style="<?php if ($game->isInvitationConfirmed()) echo 'display: none;'; ?>"><img src="/images/spinning_16.gif" style="display: none;">OK</button>
	<div class="versus_player">
		<?php if ($game->getOpponent()->isAI()) echo 'Training '; ?>versus<br>
		<?php echo $game->getUserOpponent()->getCharactername(); ?>
	</div>
</li>