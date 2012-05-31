<div class="menu-left">
	<img src="/images/swirl_top_right.png" class="swirl top-right">
	<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
	<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
	<img src="/images/swirl_top_left.png" class="swirl top-left">
	<h1>Profile shortcuts</h1>
	<ul>
		<?php if ($csp_user->hasCharacter()): ?>
			<?php if ($csp_user->isAdmin()): ?>
				<li><strong><?php echo link_tag(make_url('admin'), 'Admin CP'); ?></strong></li>
			<?php endif; ?>
			<li>&nbsp;</li>
			<li>
				<a href="<?php echo make_url('profile'); ?>">Profile summary</a>
			</li>
			<?php if ($csp_user->hasCards()): ?>
				<li>
					<a href="<?php echo make_url('cards'); ?>">My cards</a>
				</li>
			<?php endif; ?>
		<?php else: ?>
			<li>
				<a href="<?php echo make_url('profile'); ?>">Character setup</a>
			</li>
		<?php endif; ?>
	</ul>
</div>