<?php foreach ($userfriends as $userfriend): ?>
	<?php if ($userfriend->isAccepted() || $userfriend->getUserId() == $csp_user->getId()): ?>
		<li id="userfriend_<?php echo $userfriend->getId(); ?>" data-user-id="<?php echo $userfriend->getFriend()->getId(); ?>" data-userfriend-id="<?php echo $userfriend->getId(); ?>" class="userfriend-list-item">
			<img src="/images/user-offline.png" class="offline-icon" title="User is offline" style="width: 12px; margin: 5px 5px -2px 0;">
			<img src="/images/user-online.png" class="online-icon" title="User is online" style="width: 12px; margin: 5px 5px -2px 0;">
			<a href="javascript:void(0);" onclick="Devo.Main.Profile.show(<?php echo $userfriend->getFriend()->getId(); ?>);"><?php echo $userfriend->getFriend()->getCharacterName(); ?></a>
		</li>
	<?php endif; ?>
<?php endforeach; ?>
