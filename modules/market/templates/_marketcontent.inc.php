<?php include_template('market/leftmenu'); ?>
<div id="buy-popup" class="buy-popup fullpage_backdrop dark" style="display: none;">
	<div class="swirl-dialog">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<h1>Buy card</h1>
		<p id="market-buy-disclaimer">
			Keep in mind that when you buy a card, you will not receive an exact copy of the card you see in the market but you will get a copy of this card for your collection.<br>
			Your copy will have randomized traits such as HP, DMP, magic, number of (and specific available) attacks. In turn, this may make your card more valuable or less valuable than the item you're looking at.<br>
			<br>
			<strong>Do you want to buy this card for <span id="buy-popup-cost"></span> gold?</strong>
		</p>
		<div class="buy-buttons">
			<a class="button button-green buy-button" href="javascript:void(0);" onclick="Devo.Market.buy();">Yes, buy this card</a>
			<a class="button button-silver dontbuy-button" href="javascript:void(0);" onclick="Devo.Market.dontBuy();">No</a>
		</div>
		<div id="buy-indicator" style="display: none;">
			<img src="/images/spinning_20.gif">
		</div>
	</div>
</div>
<div id="buy-complete" class="buy-popup fullpage_backdrop dark" style="display: none;">
	<div class="swirl-dialog">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<h1>Buy card</h1>
		<p id="buy-complete-description">
			You can find the card in your collection.
		</p>
		<div class="buy-buttons">
			<a class="button button-silver buy-button" href="javascript:void(0);" onclick="Devo.Market.dismissBuyComplete();">OK, great!</a>
			<a class="button button-silver dontbuy-button" href="javascript:void(0);" onclick="Devo.Main.loadProfileCards();">Go to collection</a>
		</div>
		<div id="buy-indicator" style="display: none;">
			<img src="/images/spinning_20.gif">
		</div>
	</div>
</div>
<div class="content market left" id="market-container" style="width: 985px; height: auto; overflow-y: auto;">
	<div id="user-gold" class="user-gold" data-amount="<?php echo $csp_user->getGold(); ?>">
		<img src="/images/gold.png">
		<div id="user-gold-amount" class="gold"><?php echo $csp_user->getGold(); ?></div>
	</div>
	<h2 style="margin-bottom: 10px;">
		Market
	</h2>
	<div class="button-group shelf-filter" style="position: relative;">
		<button class="button button-silver" data-selected-filter="creature" id="card-category-button" onclick="Devo.Main.Helpers.popup(this);">Creature cards<span>&#9660;</span></button>
		<div class="popup-menu" id="card-category-popup" style="left: 0; right: auto; width: 350px; z-index: 10;">
			<ul>
				<li><a href="javascript:void(0);" data-filter="creature" onclick="Devo.Main.filterCardsCategory('creature');">Creature cards</a></li>
				<li><a href="javascript:void(0);" data-filter="potion_item" onclick="Devo.Main.filterCardsCategory('potion_item');">Potion cards</a></li>
				<li><a href="javascript:void(0);" data-filter="equippable_item" onclick="Devo.Main.filterCardsCategory('equippable_item');">Item cards</a></li>
			</ul>
		</div>
		<button class="button button-silver last" id="card-race-button" onclick="Devo.Main.Helpers.popup(this);"></button>
		<div class="popup-menu" id="card-race-popup" style="left: 0; right: auto; width: 350px; z-index: 10;">
			<ul>
				<?php foreach ($factions as $faction => $description): ?>
					<li><a href="javascript:void(0);" data-filter="<?php echo $faction; ?>" onclick="Devo.Main.filterCardsRace('<?php echo $faction; ?>');"><?php echo $description; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<br style="clear: both;">
	<div class="shelf" id="cards-shelf">
		<ul>
			<?php foreach ($allcards as $cards): ?>
				<?php foreach ($cards as $card): ?>
					<li style="display: none;">
						<div onclick="Devo.Main.showCardDetails('<?php echo $card->getUniqueId(); ?>');" style="cursor: pointer;">
							<?php include_template('game/card', array('card' => $card, 'mode' => 'medium', 'ingame' => false)); ?>
						</div>
						<?php include_template('main/carddetails', compact('card')); ?>
					</li>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</ul>
		<br style="clear: both;">
	</div>
</div>
<script>
	Devo.Main._default_race_filter = undefined;
	Devo.Main.filterCardsCategory('creature');
	Devo.Main.filterCardsRace('neutrals');
</script>