<?php $csp_response->setTitle('Profile summary'); ?>
<?php if (!$csp_user->hasCharacter()): ?>
	<?php include_template('main/profilecharactersetup'); ?>
<?php elseif (!$csp_user->hasCards()): ?>
	<?php include_template('main/profiledecksetup'); ?>
<?php else: ?>
	<div class="content left">
		<?php include_template('main/profileleftmenu'); ?>
	</div>
	<div class="content right profile">
		<h1><?php echo $intro; ?>, <?php echo $csp_user->getName(); ?>!</h1>
		<div id="user_level">
			<strong class="level">Level <?php echo $csp_user->getLevel(); ?></strong><br>
			<strong class="xp"><?php echo $csp_user->getXp(); ?>&nbsp;<abbr title="eXperience Points">XP</abbr></strong><br>
			<?php if (!$csp_user->canLevelUp()): ?>
				<a href="#" class="button button-orange" style="margin: 10px auto;">Level up!</a>
			<?php else: ?>
				Next level at <strong><?php echo $csp_user->getNextLevelXp(); ?>XP</strong>
			<?php endif; ?>
		</div>
		<ul class="statistics">
			<?php if (!$games_played): ?>
				<li>You have not played any games yet!</li>
			<?php else: ?>
				<li>Out of <b><?php echo $games_played; ?></b> games played, you have won <b><?php echo $games_won; ?></b> &ndash; that is <?php echo ($pct_won < 75) ? (($pct_won < 30) ? 'only' : 'about') : ' a whopping'; ?> <b><?php echo $pct_won; ?>%</b><?php echo ($pct_won < 75) ? '...' : '!'; ?><br></li>
			<?php endif; ?>
		</ul>
		<br style="clear: both;">
		<h3>Ongoing games</h3>
		<form id="my_ongoing_games_form">
			<ul id="my_ongoing_games" class="my_games" style="margin-top: 0;">
				<?php if (count($games)): ?>
					<?php foreach ($games as $game): ?>
						<?php include_template('lobby/game', compact('game')); ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<li class="faded_out" id="my_ongoing_games_none"<?php if (count($games)): ?> style="display: none;"<?php endif; ?>>You are not currently playing any games</li>
			</ul>
		</form>
	</div>
<?php endif; ?>