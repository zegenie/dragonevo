<div class="profile_menu">
	<div style="background: url('/images/avatars/<?php echo $csp_user->getAvatar(); ?>') no-repeat top left;" class="avatar mine"></div>
	<div class="strip">
		<ul id="profile_menu_strip">
			<li id="lobby_chat_toggler">Lobby</li>
			
		</ul>
	</div>
	<?php /* if ($csp_user->hasCharacter()): ?>
		<h1><a href="<?php echo make_url('profile'); ?>"><?php echo $csp_user->getCharacterName(); ?></a></h1>
		<div class="summary">Level <?php echo $csp_user->getLevel(); ?> <?php echo $csp_user->getRaceName(); ?></div>
	<?php else: ?>
		<img src="/images/avatars/default.png" class="avatar">
		<h1><a href="<?php echo make_url('profile'); ?>">Unknown user</a></h1>
		<div class="summary">Level 1</div>
	<?php endif; */ ?>
</div>
