<div class="backdrop_box medium" id="invitefriends_popup">
	<div id="backdrop_detail_content" class="rounded_top login_content">
		<h2>Invite friend to a game</h2>
		<div class="content">
			<p>
				Click the "Invite" button next to your friend's name to invite him / her to a game.<br>
				If they're online, they'll see the invitation pop up - if not, they'll get a nicely formatted invitation email! Superb!
			</p>
		</div>
		<br style="clear: both;">
		<ul style="max-height: 300px; overflow: auto; margin-bottom: 20px; font-size: 1.2em;">
			<?php $cc = 0; ?>
			<?php foreach ($userfriends as $userfriend): ?>
				<?php if (!$userfriend->isAccepted()) continue; ?>
				<?php $cc++; ?>
				<?php $online = ($userfriend->getFriend()->getLastSeen() >= time() - 180); ?>
				<li>
					<a href="javascript:void(0);" style="margin-right: 5px;" onclick="Devo.Play.invite(<?php echo $userfriend->getFriend()->getId(); ?>, this);return false;" class="ui_button"><img src="/images/spinning_16.gif" style="display: none;">Invite</a>
					<img src="/images/<?php echo (!$online) ? 'user-offline.png' : 'user-online.png'; ?>" title="<?php echo (!$online) ? 'The user is offline' : 'The user is online'; ?>" style="width: 12px; margin: 5px 5px -2px 0;">
					<?php echo $userfriend->getFriend()->getCharacterName(); ?>
				</li>
			<?php endforeach; ?>
			<?php if ($cc == 0): ?>
				<li class="faded_out">You have no friends to invite! Noone to crush! Your name will not be remembered!</li>
			<?php endif; ?>
		</ul>
		<h4>...or, invite by email</h4>
		<form method="post" onsubmit="Devo.Main.Profile.inviteUserGame();return false;" style="margin: 5px;">
			<label for="invite_game_email_input">Email address</label><input type="text" name="invite_email" id="invite_game_email_input" style="width: 160px; margin-right: 2px;"><input type="submit" id="invite_game_email_button" class="button button-standard" value="Invite">
		</form>
		<br style="clear: both;">
	</div>
	<div class="backdrop_detail_footer">
		<a href="javascript:void(0);" onclick="Devo.Main.Helpers.Backdrop.reset();">Close</a>
	</div>
</div>
