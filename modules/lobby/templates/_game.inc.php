<li>
	versus <?php echo ($game->getPlayer()->getId() == $csp_user->getId()) ? $game->getOpponent()->getUsername() : $game->getPlayer()->getUsername(); ?>
</li>