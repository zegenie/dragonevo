<?php 

	use application\entities\Game;
	include_template('main/gamemenu', compact('game') + array('mode' => 'ingame'));

?>
<div class="lobby_chat swirl-dialog" id="lobby_chat" style="<?php if (isset($game)) echo 'display: none;'; ?>">
	<?php include_component('lobby/chatroom'); ?>
</div>
<?php if (isset($game) && $game->hasCards()): ?>
	<div class="ingame_menu">
		<div id="game_menu_buttons" style="<?php if (!$game->isUserInGame()): ?> display: none;<?php endif; ?>">
			<a href="javascript:void(0);" id="end-phase-2-button" class="turn-button button button-standard<?php if (($game->getTurnNumber() > 2 && $game->getCurrentPlayerId() != $csp_user->getId()) || !$game->canUserMove($csp_user->getId())) echo ' disabled'; ?>" style="<?php if (!$game->canUserMove($csp_user->getId()) && $game->getTurnNumber() > 2): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="<?php if ($game->canUserMove($csp_user->getId()) || $game->getTurnNumber() > 2): ?>display: none;<?php endif; ?>"><span class="place-cards-content"<?php if ($game->getTurnNumber() > 2): ?> style="display: none;"<?php endif; ?>><?php echo ($game->canUserMove($csp_user->getId())) ? 'Finished placing cards' : 'Waiting for opponent'; ?></span><span class="end-phase-content"<?php if ($game->getTurnNumber() <= 2): ?> style="display: none;"<?php endif; ?>>End movement</span></a>
			<a href="javascript:void(0);" id="end-phase-3-button" class="turn-button button button-standard<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" style="<?php if ($game->getTurnNumber() <= 2 || $game->getCurrentPlayerId() != $csp_user->getId() || $game->getCurrentPhase() != Game::PHASE_ACTION): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End actions</a>
			<a href="javascript:void(0);" id="end-phase-4-button" class="turn-button button button-standard<?php if ($game->getCurrentPlayerId() != $csp_user->getId()) echo ' disabled'; ?>" style="<?php if ($game->getTurnNumber() <= 2 || ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() != Game::PHASE_RESOLUTION)): ?>display: none;<?php endif; ?>" onclick="Devo.Game.endPhase(this);"><img src="/images/spinning_16.gif" style="display: none;">End turn</a>
		</div>
		<div id="phase-3-actions" style="<?php if ($game->getTurnNumber() <= 2 || ($game->getCurrentPlayerId() != $csp_user->getId() || $game->getCurrentPhase() != Game::PHASE_ACTION)): ?>display: none;<?php endif; ?>">Actions remaining: <span id="phase-3-actions-remaining"><?php echo ($game->getCurrentPlayerId() == $csp_user->getId() && $game->getCurrentPhase() == Game::PHASE_ACTION) ? $game->getCurrentPlayerActions() : 0; ?></span></div>
		<div id="game-countdown" style="display: none;">
			<div class="countdown_content"></div>
		</div>
		<a href="javascript:void(0);" id="toggle-hand-button"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?> class="toggle-button button button-standard" onclick="Devo.Game.toggleHand();">Cards</a>
		<a href="javascript:void(0);" id="toggle-potions-button"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?> class="toggle-button button button-standard" onclick="Devo.Game.togglePotions();">Potions</a>
		<a href="javascript:void(0);" id="toggle-events-button"<?php if (!$game->isUserInGame()): ?> style="display: none;"<?php endif; ?> class="toggle-button button button-standard" onclick="Devo.Game.toggleEvents();">Events</a>
	</div>
<?php endif; ?>
<div class="profile_menu<?php if (isset($game)) echo ' in-game'; ?>">
	<div style="background: url('/images/avatars/avatar_4.png') no-repeat top left; background-size: cover;" class="avatar mine<?php if (isset($game) && $game->getCurrentPlayer() instanceof application\entities\User && $game->getCurrentPlayer()->getId() == $csp_user->getId()) echo ' current-turn'; ?>" id="avatar-player-<?php echo (isset($game)) ? $game->getUserPlayer()->getId() : $csp_user->getId(); ?>"></div>
	<?php if (isset($game)): ?>
		<div style="background: url('/images/avatars/avatar_1.png') no-repeat top left; background-size: cover;" class="avatar opponent<?php if ($game->getCurrentPlayer() instanceof application\entities\User && $game->getCurrentPlayer()->getId() == $game->getUserOpponent()->getId()) echo ' current-turn'; ?>" id="avatar-player-<?php echo $game->getUserOpponent()->getId(); ?>">
		</div>
	<?php endif; ?>
	<div class="strip">
		<div id="profile_menu_buttons" class="button-group">
			<button onclick="$('gamemenu-container').toggle();" class="button button-standard">Menu</button>
		</div>
		<ul id="profile_menu_strip">
			<li id="lobby_chat_toggler" class="<?php if (isset($game)) echo 'ingame '; ?>" <?php if (isset($game)): ?> onclick="Devo.Game.toggleLobbyChat();"<?php endif; ?>>Lobby<span class="notify"> *</span></li>
		</ul>
	</div>
	<?php /* if ($csp_user->hasCharacter()): ?>
		<h1><a href="<?php echo make_url('profile'); ?>"><?php echo $csp_user->getCharacterName(); ?></a></h1>
		<div class="summary">Level <?php echo $csp_user->getLevel(); ?> <?php echo $csp_user->getRaceName(); ?></div>
	<?php else: ?>
		<img src="/images/avatars/default.png" class="avatar">
		<h1><a href="<?php echo make_url('profile'); ?>">Unknown user</a></h1>
		<div class="summary">Level 1</div>
	<?php endif; */ ?>
</div>
