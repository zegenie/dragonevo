<div id="buy-popup" class="buy-popup fullpage_backdrop dark" style="display: none;">
	<div class="backdrop_box large">
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
	<div class="backdrop_box large">
		<h1>Buy card</h1>
		<p id="buy-complete-description">
			You can find the card in your collection.
		</p>
		<div id="buy-gold-container">
			<div id="user-gold-buy" class="user-gold" data-amount="<?php echo $csp_user->getGold(); ?>">
				<img src="/images/gold.png">
				<div id="user-gold-amount-buy" class="gold"><?php echo $csp_user->getGold(); ?></div>
			</div>
		</div>
		<div class="buy-buttons">
			<a class="button button-silver buy-button" href="javascript:void(0);" onclick="Devo.Market.dismissBuyComplete();">OK, great!</a>
			<a class="button button-silver dontbuy-button" href="javascript:void(0);" onclick="Devo.Main.loadProfileCards();">Go to collection</a>
		</div>
		<div id="buy-indicator" style="display: none;">
			<img src="/images/spinning_20.gif">
		</div>
	</div>
</div>
