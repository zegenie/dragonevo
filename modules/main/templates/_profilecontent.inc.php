<?php 

	$csp_response->setTitle('Profile summary');

?>
<?php if (!$csp_user->hasCharacter()): ?>
	<?php include_template('main/profilecharactersetup'); ?>
<?php elseif (!$csp_user->hasCards()): ?>
	<?php include_template('main/profiledecksetup'); ?>
<?php else: ?>
	<?php include_template('main/profileleftmenu'); ?>
	<div id="levelup-overlay" class="fullpage_backdrop dark" style="display: none;">
		<div class="fullpage_backdrop_content">
			<div class="swirl-dialog">
				<img src="/images/swirl_top_right.png" class="swirl top-right">
				<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
				<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
				<img src="/images/swirl_top_left.png" class="swirl top-left">
				<h1>Level up</h1>
				<div style="text-align: left;" class="info">
					When you earn XP you can choose to spend it on levelling up your character, training skill(s) or levelling up your cards and / or attacks.<br>
					<br>
					<h6>Levelling up your character</h6>
					Levelling up your character allows you to train new skills, and unlocks many new card attacks and abilities.<br>
					<br>
					<h6>Training skills</h6>
					Any skills you train will apply in-game to all cards with specific treats, but can only be trained when you reach certain levels and they do not modify any card or attack's properties or value. This means that your less powerful cards may be stronger in-game, but their value will not increase.<br>
					<br>
					<h6>Upgrading cards and attacks</h6>
					Spending your XP on a card or its attacks will permanently increase that card or attack's abilities (such as min- and max damage for its attacks, health for the card). This will increase that card's value so you will get more back when you sell it or trade it with other players.
					<br>
					<div style="text-align: center; margin-top: 20px;">
						<a href="javascript:void(0);" onclick="Devo.Main.loadProfileSkills();" class="button button-orange" style="margin: 10px auto;">Show skills overview</a>
						<a href="javascript:void(0);" onclick="Devo.Main.loadProfileCards();" class="button button-orange" style="margin: 10px auto;">Show my cards</a>
						<br>
						<div id="levelup-profile-button-container" style="<?php if (!$csp_user->canLevelUp()): ?>display: none;<?php endif; ?>">
							or
							<br>
							<a href="javascript:void(0);" onclick="Devo.Main.levelUpProfile();" class="button button-orange" style="margin: 10px auto;">Level up my character</a>
						</div>
						<div id="no-levelup-profile-button-container" style="<?php if ($csp_user->canLevelUp()): ?>display: none;<?php endif; ?>">
							Next profile level-up costs <strong><span class="next-level-xp"><?php echo $csp_user->getNextLevelXp(); ?></span>XP</strong>
						</div>
					</div>
					<a href="javascript:void(0);" onclick="$('levelup-overlay').hide()" style="float: right; margin: 10px;">Cancel</a>
					<br style="clear: both;">
				</div>
			</div>
		</div>
	</div>
	<div class="content profile summary" id="profile-container">
		<h1><?php echo $intro; ?>, <?php echo $csp_user->getName(); ?>!</h1>
		<?php include_template('main/profiledetailstop'); ?>
		<div id="user_level">
			<a href="javascript:void(0);" onclick="$('levelup-overlay').show();" class="button button-orange" style="float: right; margin: 10px 10px 20px 20px; font-size: 1.2em !important; padding: 10px 15px !important;">Spend XP!</a>
			<div style="margin-top: 23px; white-space: nowrap; font-size: 1.1em;">
				Next profile level-up costs <strong><span class="next-level-xp"><?php echo $csp_user->getNextLevelXp(); ?></span>XP</strong><br>
			</div>
		</div>
		<ul class="statistics">
			<?php if (!$games_played): ?>
				<li>You have not played any games yet!</li>
			<?php else: ?>
				<li>Out of <b><?php echo $games_played; ?></b> games played, you have won <b><?php echo $games_won; ?></b> &ndash; that is <?php echo ($pct_won < 75) ? (($pct_won < 30) ? 'only' : 'about') : ' a whopping'; ?> <b><?php echo $pct_won; ?>%</b><?php echo ($pct_won < 75) ? '...' : '!'; ?><br></li>
			<?php endif; ?>
		</ul>
		<br style="clear: both;">
		<br style="clear: both;">
		<br style="clear: both;">
		<?php // include_component('main/mygames'); ?>
	</div>
<?php endif; ?>
