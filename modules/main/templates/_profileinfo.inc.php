<?php

	$is_accepted_friends = $csp_user->isAcceptedFriends($user);
	$is_friends = $csp_user->isFriends($user);

?>
<div class="backdrop_box medium userinfo-<?php echo $user->getId(); ?><?php if ($is_friends) echo ' user-friends'; ?>" id="userprofile_popup" style="overflow: hidden;">
	<div style="position: absolute; bottom: 0; right: 0; border-radius: 360px 0 0 0; background: url('/images/avatars/<?php echo $user->getAvatar(); ?>') no-repeat left bottom; z-index: 1; width: 360px; height: 360px;"></div>
	<div id="backdrop_detail_content" style="z-index: 100; position: relative;">
		<h3><?php echo $user->getCharactername(); ?> (<?php echo $user->getUsername(); ?>)</h3>
		<p>
			Level <?php echo $user->getLevel(); ?> <?php echo $user->getRaceName(); ?>
		</p>
		<div class="buttons button-group">
			<button class="ui_button" onclick="Devo.Play.invite(<?php echo $user->getId(); ?>, this);"><img src="/images/spinning_16.gif" style="display: none;">Challenge</button>
			<button class="ui_button addfriend" onclick="Devo.Main.Profile.addFriend(<?php echo $user->getId(); ?>, this);"><img src="/images/spinning_16.gif" style="display: none;">Add friend</button>
			<button class="ui_button removefriend" onclick="Devo.Main.Profile.removeFriend(<?php echo $user->getId(); ?>, this, true);"><img src="/images/spinning_16.gif" style="display: none;">Unfriend</button>
		</div>
	</div>
	<div class="backdrop_detail_footer" style="z-index: 100; position: relative;">
		<a href="javascript:void(0);" class="ui_button" onclick="Devo.Main.Helpers.Backdrop.reset();$('fullpage_backdrop_content').update('');">Close</a>
	</div>
</div>
