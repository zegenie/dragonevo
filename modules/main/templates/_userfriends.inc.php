<?php foreach ($userfriends as $userfriend): ?>
	<?php if ($userfriend->isAccepted() || $userfriend->getUserId() == $csp_user->getId()): ?>
		<li id="userfriend_<?php echo $userfriend->getId(); ?>" data-userfriend-id="<?php echo $userfriend->getId(); ?>" class="userfriend-list-item">
			<img src="/images/user-offline.png" title="Online status not available yet" style="width: 12px; margin: 5px 5px -2px 0;">
			<?php echo $userfriend->getFriend()->getCharacterName(); ?>
		</li>
	<?php endif; ?>
<?php endforeach; ?>
