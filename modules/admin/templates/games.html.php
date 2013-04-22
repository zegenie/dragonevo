<?php 
	
	$csp_response->setTitle('Manage games'); 
	$faction_names = array('resistance' => 'Hologev', 'neutrals' => 'Highwinds', 'rutai' => 'Rutai');
	
?>
<div class="content left">
	<?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right cotw-admin">
	<h1>
		Manage <?php echo ($mode == \application\entities\Game::STATE_ONGOING) ? 'ongoing' : 'finished'; ?> <?php
		
			switch ($type) {
				case 'multiplayer':
					echo 'multiplayer';
					break;
				case 'scenario':
					echo 'scenario';
					break;
				case 'training':
					echo 'training';
					break;
			}
			
		?> games (<?php echo count($games); ?>)
	</h1>
	<a href="/admin">&laquo;&nbsp;Back to admin frontpage</a><br>
	<form action="<?php echo make_url('admin_say'); ?>" id="games_form">
		<ul class="admin_list">
			<?php foreach ($games as $game): ?>
				<?php if ($game instanceof \application\entities\Game): ?>
					<li>
						<img src="/images/spinning_16.gif" style="display: none;" class="indicator" id="game_<?php echo $game->getId(); ?>_indicator">
						<div class="button-group">
							<a href="javascript:void(0);" id="user_<?php echo $game->getId(); ?>_button" class="button button-silver button-icon first last" onclick="Devo.Main.Helpers.popup(this);"><img src="/images/settings_small.png"></a>
							<div class="popup-menu">
								<ul>
									<li><a href="#" onclick="Devo.Main.Helpers.Message.error('Not implemented', 'Not implemented yet');">Show/monitor events</a></li>
									<li><a href="#" onclick="Devo.Main.Helpers.Message.error('Not implemented', 'Not implemented yet');">Show/monitor chat</a></li>
									<li><a href="#" onclick="Devo.Main.Helpers.Message.error('Not implemented', 'Not implemented yet');">Show game details</a></li>
									<li><a href="/play#!game/<?php echo $game->getId(); ?>">Watch game</a></li>
								</ul>
							</div>
						</div>
						<strong>
							<?php if ($game->isPvP()): ?>
								<?php echo $game->getPlayer()->getUsername(); ?> vs <?php echo $game->getOpponent()->getUsername(); ?>
							<?php elseif ($game->isScenario()): ?>
								Single player: <?php echo $game->getPlayer()->getUsername(); ?> - <?php echo $game->getPart()->getName(); ?>
							<?php else: ?>
								Training game: <?php echo $game->getPlayer()->getUsername(); ?> (<?php

									switch ($game->getOpponent()->getLevel())
									{
										case \application\entities\User::AI_EASY:
											echo 'easy';
											break;
										case \application\entities\User::AI_NORMAL:
											echo 'normal';
											break;
										case \application\entities\User::AI_HARD:
											echo 'hard';
											break;
									}

								?>)
							<?php endif; ?>
						</strong><br>
						started <?php echo date('d-m-Y, H:i', $game->getCreatedAt()); ?>
						<?php if ($mode == \application\entities\Game::STATE_COMPLETED): ?>
							, finished <?php echo date('d-m-Y, H:i', $game->getEndedAt()); ?> (<?php echo $game->getTurnNumber(); ?> turns)
						<?php else: ?>
							, current turn: <?php echo $game->getTurnNumber(); ?>
						<?php endif; ?>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</form>
</div>