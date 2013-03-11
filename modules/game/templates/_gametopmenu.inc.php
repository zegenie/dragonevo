<?php

	use \application\entities\Game;

?>
<div class="ingame_menu" id="ingame-menu-top">
	<div id="game_menu_buttons" style="<?php if (!$game->isUserInGame()): ?> display: none;<?php endif; ?>">
		<a href="javascript:void(0);" id="end-phase-2-button" class="turn-button button <?php if (($game->getTurnNumber() > 2 && $game->getCurrentPlayerId() != $csp_user->getId()) || !$game->canUserMove($csp_user->getId())) echo ' disabled'; ?>" style="<?php if (!$game->canUserMove($csp_user->getId()) && $game->getTurnNumber() > 2): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="<?php if ($game->canUserMove($csp_user->getId()) || $game->getTurnNumber() > 2): ?>display: none;<?php endif; ?>"><span class="place-cards-content"<?php if ($game->getTurnNumber() > 2): ?> style="display: none;"<?php endif; ?>><?php echo ($game->canUserMove($csp_user->getId())) ? 'Cards placed' : 'Waiting'; ?></span><span class="end-phase-content"<?php if ($game->getTurnNumber() <= 2): ?> style="display: none;"<?php endif; ?>>End movement</span></a>
		<a href="javascript:void(0);" id="end-phase-3-button" class="turn-button button <?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" style="<?php if ($game->getTurnNumber() <= 2 || $game->getCurrentPlayerId() != $csp_user->getId() || $game->getCurrentPhase() != Game::PHASE_ACTION): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End actions</a>
		<a href="javascript:void(0);" id="end-phase-4-button" class="turn-button button <?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" style="<?php if ($game->getTurnNumber() <= 2 || ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() != Game::PHASE_RESOLUTION)): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End turn</a>
	</div>
	<div id="phase-3-actions" style="<?php if ($game->getTurnNumber() <= 2 || ($game->getCurrentPlayerId() != $csp_user->getId() || $game->getCurrentPhase() != Game::PHASE_ACTION)): ?>display: none;<?php endif; ?>">Actions remaining: <span id="phase-3-actions-remaining"><?php echo ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() == Game::PHASE_ACTION) ? $game->getCurrentPlayerActions() : 0; ?></span></div>
	<div id="game-countdown" style="display: none;">
		<div class="countdown_content"></div>
	</div>
	<a href="javascript:void(0);" id="toggle-hand-button"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?>>Cards</a>
	<a href="javascript:void(0);" id="toggle-potions-button"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?>>Potions</a>
</div>
