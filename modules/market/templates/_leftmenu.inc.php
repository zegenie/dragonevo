<div class="content left" id="left-menu-container">
	<div class="menu-left">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<h1>Market shortcuts</h1>
		<ul>
			<?php if ($csp_user->hasCharacter()): ?>
				<?php if ($csp_user->isAdmin()): ?>
					<li><strong><?php echo link_tag(make_url('admin'), 'Admin CP', array('target' => '_new')); ?></strong></li>
				<?php endif; ?>
				<li>&nbsp;</li>
				<li><a href="javascript:void(0);" onclick="Devo.Main.loadMarketUI();">Market frontpage</a></li>
				<li><a href="javascript:void(0);" onclick="Devo.Main.loadProfileCards();">My cards</a></li>
			<?php else: ?>
				<li><a href="javascript:void(0);" onclick="Devo.Main.loadProfile();">Character setup</a></li>
			<?php endif; ?>
		</ul>
	</div>
</div>
