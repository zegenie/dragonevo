<?php foreach ($userfriends as $userfriend): ?>
	<?php if (!$userfriend->isAccepted() && $userfriend->getUserId() != $csp_user->getId()): ?>
		<li id="userfriend_<?php echo $userfriend->getId(); ?>" data-userfriend-id="<?php echo $userfriend->getId(); ?>" class="userfriend-list-item">
			<img src="/images/user-offline.png" title="Online status not available yet" style="width: 12px; margin: 5px 5px -2px 0;">
			<a href="javascript:void(0);" onclick="Devo.Main.Profile.show(<?php echo $userfriend->getFriend()->getId(); ?>);"><?php echo $userfriend->getFriend()->getCharacterName(); ?></a>
			<button style="position: absolute; bottom: 6px; right: -10px;" onclick="Devo.Main.Profile.removeFriend(<?php echo $userfriend->getId(); ?>, this);"><img src="/images/spinning_16.gif" style="display: none;">No</button>
			<button style="position: absolute; bottom: 6px; right: 25px; width: 28px;" onclick="Devo.Main.Profile.addFriend(<?php echo $userfriend->getFriend()->getId(); ?>, this);"><img src="/images/spinning_16.gif" style="display: none;">Yes</button>
			<div style="font-size: 0.8em; padding: 10px 0 0 0;">wants to be friends</div>
		</li>
	<?php endif; ?>
<?php endforeach; ?>