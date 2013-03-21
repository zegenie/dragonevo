<?php

	$userfriends = $csp_user->getUserFriends();

?>
<div class="content left" id="left-menu-container">
	<div class="menu-left">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<h1>Profile shortcuts</h1>
		<ul>
			<?php if ($csp_user->hasCharacter()): ?>
				<?php if ($csp_user->isAdmin()): ?>
					<li><strong><?php echo link_tag(make_url('admin'), 'Admin CP', array('target' => '_new')); ?></strong></li>
				<?php endif; ?>
				<li>&nbsp;</li>
				<li><a href="#!profile">Profile summary</a></li>
				<li><a href="#!profile/skills">My skills</a></li>
				<?php if ($csp_user->hasCards()): ?>
					<li><a href="#!profile/cards">My cards</a></li>
					<li><a href="#!market">Get more cards!</a></li>
				<?php endif; ?>
				<li>&nbsp;</li>
				<li><a href="javascript:void(0);" onclick="$('settings-overlay').toggle();">Settings</a></li>
				<li><a href="javascript:void(0);" onclick="$('invite_email').toggle();">Invite a friend</a></li>
			<?php else: ?>
				<li><a href="#!profile">Character setup</a></li>
			<?php endif; ?>
			<li id="invite_email" style="display: none;">
				<form method="post" onsubmit="Devo.Main.Profile.inviteUser();return false;">
					<input type="text" name="invite_email" id="invite_email_input" style="width: 160px; margin-right: 2px;"><input type="submit" id="invite_email_button" class="button button-standard" value="Invite">
				</form>
			</li>
		</ul>
		<h1 style="margin-top: 25px;">Friends</h1>
		<div id="friends-list-container">
			<ul id="online-friends">
			</ul>
			<ul id="offline-friends">
				<?php include_template('main/userfriends', compact('userfriends')); ?>
			</ul>
			<ul id="friend-requests">
				<?php include_template('main/friendrequests', compact('userfriends')); ?>
			</ul>
			<ul id="no-friends">
				<?php if (!count($userfriends)): ?>
					<li class="faded_out">
						You don't have any friends.
						<?php $encouragements = array('Sad face.', 'Awww.', 'Make some!', "Who needs 'em!", 'Pity.', 'Such a disgrace.', 'Oh well.', "There's always youtube.", 'All alone in a dangerous world.'); ?>
						<?php echo $encouragements[array_rand($encouragements)]; ?>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>
