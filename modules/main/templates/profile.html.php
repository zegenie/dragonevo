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
			You're at level <strong><?php echo $csp_user->getLevel(); ?></strong> - only <strong><?php echo $csp_user->getNextLevelXp() - $csp_user->getXp(); ?></strong> more <strong><abbr title="eXperience Points">XP</abbr></strong> and you'll reach <b>level <?php echo $csp_user->getLevel() + 1; ?></b>
		</div>
		<ul class="statistics">
			<?php if (!$games_played): ?>
				<li>You have not played any games yet!</li>
			<?php else: ?>
				<li>Out of <b><?php echo $games_played; ?></b> games played, you have won <b><?php echo $games_won; ?></b> &ndash; that is <?php echo ($pct_won < 75) ? 'only' : ' a whopping'; ?> <b><?php echo $pct_won; ?>%</b><?php echo ($pct_won < 75) ? '...' : '!'; ?><br></li>
				<li>You have moved your cards <b><?php echo $num_cardmoves; ?> times</b> on the game board</li>
			<?php endif; ?>
		</ul>
	</div>
<?php endif; ?>