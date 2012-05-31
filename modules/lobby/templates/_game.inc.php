<li id="game_<?php echo $game->getId(); ?>_list">
	<input type="hidden" name="games[<?php echo $game->getId(); ?>]" value="<?php echo $game->getId(); ?>">
	<div class="tooltip">
		<div class="game_tooltip_versus">
		<?php echo $game->getPlayer()->getUsername(); ?>&nbsp;<span class="game_tooltip_versus_versus">vs.</span>&nbsp;<?php echo $game->getOpponent()->getUsername(); ?>
		</div>
		<div class="game_tooltip_turn">
			<span id="game_<?php echo $game->getId(); ?>_player_turn"<?php if (!$game->isInvitationConfirmed() || !$game->isPlayerTurn()): ?> style="display: none;"<?php endif; ?>>It is <?php echo $game->getPlayer()->getUsername(); ?>'s turn</span>
			<span id="game_<?php echo $game->getId(); ?>_opponent_turn"<?php if (!$game->isInvitationConfirmed() || !$game->isOpponentTurn()): ?> style="display: none;"<?php endif; ?>>It is <?php echo $game->getOpponent()->getUsername(); ?>'s turn</span>
			<span id="game_<?php echo $game->getId(); ?>_invitation_unconfirmed"<?php if ($game->isInvitationConfirmed()): ?> style="display: none;"<?php endif; ?>>Not ready to start the game - still waiting for <?php echo $game->getOpponent()->getUsername(); ?> to accept the invitation</span>
		</div>
	</div>
	<button class="button button-standard<?php if (!$game->isInvitationConfirmed()) echo ' disabled'; ?>"<?php if (!$game->isInvitationConfirmed()) echo ' disabled'; ?> onclick="return false;">Play</button>
	<div class="versus_player">
		versus<br>
		<?php echo ($game->getPlayer()->getId() == $csp_user->getId()) ? $game->getOpponent()->getUsername() : $game->getPlayer()->getUsername(); ?>
	</div>
</li>