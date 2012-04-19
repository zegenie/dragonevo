<?php $csp_response->setTitle('Profile summary'); ?>
<div class="content">
	<?php if ($banner_message): ?>
		<div class="message_banner">
			<?php 
			
				switch ($banner_message) {
					case 'starter_pack_generated':
						echo "Your starter pack has been generated!";
						break;
					default:
						echo $banner_message;
						break;
				}
			
			?>
		</div>
	<?php endif; ?>
	<?php if (!$csp_user->hasCharacter()): ?>
	<h3>Set up your character</h3>
	<div class="character_setup">
		<form action="<?php echo make_url('profile'); ?>" method="post">
			<input type="hidden" name="character_setup" value="1">
			<input type="hidden" name="step" value="1">
			Before you continue, you must set up your game character!<br>
			<br>
			<?php if (isset($charactername_error) && $charactername_error): ?>
				<div style="color: red; font-size: 15px; font-weight: bold; padding: 5px 0;">You must choose a character name!</div>
			<?php endif; ?>
			<label for="character_name_input">Please enter your character's name</label>
			<input type="text" name="character_name" id="character_name_input" value="<?php echo $csp_user->getCharacterName(); ?>">
			<input type="submit" value="Continue &raquo;">
		</form>
	</div>
	<?php elseif (!$csp_user->hasCards()): ?>
		<h3>Get your starting deck</h3>
		<div class="character_setup">
			Now, get your starter pack. Without it, you have no cards to play with!<br>
			<br>
			<?php foreach (array('resistance', 'neutrals', 'rutai') as $faction): ?>
				<div style="float: left; width: 310px;">
					<form action="" method="post">
						<input type="hidden" name="character_setup" value="1">
						<input type="hidden" name="step" value="2">
						<input type="hidden" name="faction" value="<?php echo $faction; ?>">
						<ul class="cards stacked">
							<li class="card flipped"></li>
							<li class="card flipped"></li>
							<li class="card flipped"></li>
							<li class="card flipped"></li>
							<li class="card flipped"></li>
							<li class="card flipped"></li>
							<li class="card flipped"></li>
						</ul>
						<br style="clear: both;">
						<div style="width: 250px; margin-top: 20px;">
						</div>
						<input type="submit" value="Pick <?php echo $faction; ?> starter pack" style="margin-top: 20px;">
					</form>
				</div>
			<?php endforeach; ?>
			<br style="clear: both;">
		</div>
	<?php else: ?>
		<div class="profile-intro"><?php echo $intro; ?>, <?php echo $csp_user->getName(); ?>!</div>
		<div id="change_password_container" class="rounded_box shadowed_box lightyellow borderless">
			<form method="post" accept-charset="utf-8">
				<input type="hidden" name="change_password" value="1">
				<span id="change_password_inputs" style="display: none;">
					<label for="old_pwd">Current password:</label>
					<input type="password" value="" name="current_password" style="font-size: 15px; font-weight: normal; padding: 4px; width: 150px;" id="old_pwd">
					<label for="new_pwd_1">New password:</label>
					<input type="password" value="" name="new_password_1" style="font-size: 15px; font-weight: normal; padding: 4px; width: 150px;" id="new_pwd_1">
					<label for="new_pwd_2">(again):</label>
					<input type="password" value="" name="new_password_2" style="font-size: 15px; font-weight: normal; padding: 4px; width: 150px;" id="new_pwd_2">
				</span>
				<input type="submit" value="Change password" onclick="if ($('old_pwd').getValue() != '' && $('new_pwd_1').getValue() != '' && $('new_pwd_2').getValue() != '') { return true; } else { $('change_password_inputs').toggle(); if($('change_password_inputs').visible()) { $('old_pwd').focus(); } return false; }">
			</form>
		</div>
		<?php if (isset($pwd_error)): ?>
			<div style="color: red; font-size: 15px; font-weight: bold; padding: 5px 0;"><?php echo $pwd_error; ?></div>
		<?php elseif (isset($password_changed)): ?>
			<div style="color: olive; font-size: 15px; font-weight: bold; padding: 5px 0;">Password changed successfully!</div>
		<?php endif; ?>
		<div id="user_level">
			You're at level <b><?php echo $csp_user->getLevel(); ?></b><br>
			With only <b><?php echo $csp_user->getNextLevelXp() - $csp_user->getXp(); ?></b> more <abbr title="eXperience Points">XP</abbr> you'll reach <b>level <?php echo $csp_user->getLevel() + 1; ?></b>
		</div>
		<ul class="statistics">
			<?php if (!$games_played): ?>
				<li>You have not played any games yet!</li>
			<?php else: ?>
				<li>Out of <b><?php echo $games_played; ?></b> games played, you have won <b><?php echo $games_won; ?></b> &ndash; that is <?php echo ($pct_won < 75) ? 'only' : ' a whopping'; ?> <b><?php echo $pct_won; ?>%</b><?php echo ($pct_won < 75) ? '...' : '!'; ?><br></li>
				<li>You have moved your cards <b><?php echo $num_cardmoves; ?> times</b> on the game board</li>
			<?php endif; ?>
		</ul>
		<div id="user_battlepoints">
			You currently have <span class="bp">0</span> battlepoints!<br>
			You earn battlepoints when you play games - winning them earns you even more! Battlepoints can be spent buying card packs, levelling up your existing cards and/or levelling up your card attacks!
			Levelling up cards and attacks makes them more powerful - attacks deal more damage and cards have more health and magic!
		</div>
		<div id="user_invites">
			<span class="<?php if (!$csp_user->getInvites()) echo 'faded'; ?>">You have <?php echo $csp_user->getInvites(); ?> invite(s) to hand out</span>
			<?php if (isset($invite_sent)): ?>
				<div style="color: olive; font-size: 15px; font-weight: bold; padding: 5px 0;">Invite sent to <?php echo $invite_sent; ?>!</div>
			<?php endif; ?>
			<?php if ($csp_user->getInvites()): ?>
				<form method="post" style="margin-top: 5px;">
					<input type="submit" value="Send invite!" style="padding: 2px; font-size: 15px; font-weight: bold; float: right; margin-top: -5px;">
					<label for="invite_email_input">Send an invite to</label>
					<input type="text" id="invite_email_input" name="invite_email" style="width: 300px; font-size: 15px; margin-right: 10px;">
					<span class="faded">Enter an email address here, and we'll send an invite!</span>
				</form>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
<?php if ($message): ?>
	<script type="text/javascript">
		document.observe('dom:loaded', function() {
			Devo.Main.Helpers.Message.success('', '<?php echo $message; ?>');
		});
	</script>
<?php endif; ?>
<?php if ($error): ?>
	<script type="text/javascript">
		document.observe('dom:loaded', function() {
			Devo.Main.Helpers.Message.error('', '<?php echo $error; ?>');
		});
	</script>
<?php endif; ?>
