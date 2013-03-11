<li id="game_<?php echo $game->getId(); ?>_list">
	<input type="hidden" name="games[<?php echo $game->getId(); ?>]" value="<?php echo $game->getId(); ?>">
	<div class="tooltip">
		<div class="game_tooltip_versus">
			<?php echo $game->getPlayer()->getCharactername(); ?>&nbsp;<span class="game_tooltip_versus_versus">vs.</span>&nbsp;<?php echo $game->getOpponent()->getCharactername(); ?>
		</div>
		<div class="game_tooltip_turn">
			<span id="game_<?php echo $game->getId(); ?>_player_turn"<?php if (!$game->isInvitationConfirmed() || !$game->isPlayerTurn() || $game->getTurnNumber() <= 2): ?> style="display: none;"<?php endif; ?>>It is <?php echo ($game->getPlayer()->getId() == $csp_user->getId()) ? 'your' : $game->getPlayer()->getCharactername()."'s"; ?> turn</span>
			<span id="game_<?php echo $game->getId(); ?>_opponent_turn"<?php if (!$game->isInvitationConfirmed() || !$game->isOpponentTurn() || $game->getTurnNumber() <= 2): ?> style="display: none;"<?php endif; ?>>It is <?php echo ($game->getOpponent()->getId() == $csp_user->getId()) ? 'your' : $game->getOpponent()->getCharactername()."'s"; ?> turn</span>
			<span id="game_<?php echo $game->getId(); ?>_invitation_unconfirmed"<?php if ($game->isInvitationConfirmed() && !$game->isInvitationRejected()): ?> style="display: none;"<?php endif; ?>>Not ready to start the game - still waiting for <?php echo $game->getOpponent()->getCharactername(); ?> to accept the invitation</span>
			<span id="game_<?php echo $game->getId(); ?>_invitation_rejected"<?php if (!$game->isInvitationRejected()): ?> style="display: none;"<?php endif; ?>><?php echo $game->getOpponent()->getCharactername(); ?> rejected the invitation</span>
		</div>
		<div class="game_tooltip_info" id="game_<?php echo $game->getId(); ?>_pickandplace" style="<?php if ($game->getTurnNumber() > 2 || !$game->isInvitationConfirmed()) echo 'display: none;'; ?>">Pick and place cards</div>
		<div class="game_tooltip_info" id="game_<?php echo $game->getId(); ?>_info" style="<?php if ($game->getTurnNumber() <= 2 || !$game->isInvitationConfirmed()) echo 'display: none;'; ?>">
			<span id="game_<?php echo $game->getId(); ?>_phase_pre" style="<?php if ($game->getTurnNumber() > 2) echo 'display: none;'; ?>">Pick and place cards</span>
			Turn: <span id="game_<?php echo $game->getId(); ?>_turn_number"><?php echo $game->getTurnNumber(); ?></span> - <span id="game_<?php echo $game->getId(); ?>_phase_2" style="<?php if ($game->getCurrentPhase() != 2) echo 'display: none;'; ?>">movement phase</span><span id="game_<?php echo $game->getId(); ?>_phase_3" style="<?php if ($game->getCurrentPhase() != 3) echo 'display: none;'; ?>">actions phase</span><span id="game_<?php echo $game->getId(); ?>_phase_4" style="<?php if ($game->getCurrentPhase() != 4) echo 'display: none;'; ?>">cleanup phase</span><br>
		</div>
	</div>
	<button class="ui_button button-play<?php if (!$game->isInvitationConfirmed()) echo ' disabled'; ?>" onclick="if (!$(this).hasClassName('disabled')) { Devo.Game.initializeGame(<?php echo $game->getId(); ?>);}return false;">Play</button>
	<button class="ui_button button-cancel" onclick="Devo.Play.cancelGame(<?php echo $game->getId(); ?>);return false;" style="<?php if ($game->isInvitationConfirmed()) echo 'display: none;'; ?>"><img src="/images/spinning_16.gif" style="display: none;">Cancel</button>
	<button class="ui_button button-ok" onclick="Devo.Play.cancelGame(<?php echo $game->getId(); ?>);return false;" style="<?php if ($game->isInvitationConfirmed()) echo 'display: none;'; ?>"><img src="/images/spinning_16.gif" style="display: none;">OK</button>
	<div class="versus_player">
		<?php if ($game->getOpponent()->isAI()) echo 'Training '; ?>versus<br>
		<?php echo $game->getUserOpponent()->getCharactername(); ?>
	</div>
</li>