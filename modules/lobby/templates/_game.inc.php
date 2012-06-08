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
	<a class="button button-standard button-play<?php if (!$game->isInvitationConfirmed()) echo ' disabled'; ?>" href="<?php echo make_url('board', array('game_id' => $game->getId())); ?>" onclick="return !($(this).hasClassName('disabled'));">Play</a>
	<?php if (!$game->isInvitationConfirmed()): ?>
		<button class="button button-standard button-cancel" onclick="Devo.Play.cancelGame(<?php echo $game->getId(); ?>);return false;"><img src="/images/spinning_16.gif" style="display: none;">Cancel</button>
		<button class="button button-standard button-ok" onclick="Devo.Play.cancelGame(<?php echo $game->getId(); ?>);return false;"><img src="/images/spinning_16.gif" style="display: none;">OK</button>
	<?php endif; ?>
	<div class="versus_player">
		versus<br>
		<?php echo $game->getUserOpponent()->getUsername(); ?>
	</div>
</li>