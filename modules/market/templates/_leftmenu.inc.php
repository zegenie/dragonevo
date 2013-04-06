<div class="content left" id="left-menu-container">
	<div class="menu-left" id="market-menu">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<h1 id="user-gold" data-amount="<?php echo $csp_user->getGold(); ?>">
			<span id="user-gold-amount" class="gold"><?php echo $csp_user->getGold(); ?></span><br>
			Gold
			<div class="tooltip from-left">
				Profile gold<br>
				This is the gold you've accumulated when playing matches.<br>
				<br>
				Later you will also be able to buy more gold, but this is not implemented yet.
			</div>
		</h1>
		<h1>Market shortcuts</h1>
		<ul>
			<?php if ($csp_user->hasCharacter()): ?>
				<?php if ($csp_user->isAdmin()): ?>
					<li><strong><?php echo link_tag(make_url('admin'), 'Admin CP', array('target' => '_new')); ?></strong></li>
				<?php endif; ?>
				<li>&nbsp;</li>
				<li><a href="javascript:void(0);" onclick="Devo.Main.loadMarketFrontpage();" class="<?php if (isset($section) && $section == 'frontpage') echo 'selected'; ?>">Market frontpage</a></li>
				<li><a href="javascript:void(0);" onclick="Devo.Main.loadMarketBuy();" class="<?php if (isset($section) && $section == 'buy') echo 'selected'; ?>">Buy cards</a></li>
				<li><a href="javascript:void(0);" onclick="Devo.Main.loadMarketSell();" class="<?php if (isset($section) && $section == 'sell') echo 'selected'; ?>">Sell cards</a></li>
				<li>&nbsp;</li>
				<li><a href="javascript:void(0);" onclick="Devo.Main.loadProfileCards();">My cards</a></li>
			<?php else: ?>
				<li><a href="javascript:void(0);" onclick="Devo.Main.loadProfile();">Character setup</a></li>
			<?php endif; ?>
		</ul>
	</div>
</div>
