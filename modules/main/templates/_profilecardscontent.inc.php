<?php $csp_response->setTitle(__('Dragon Evo - The Card Game')); ?>
<?php include_template('main/profileleftmenu'); ?>
<div id="levelup-popup" class="buy-popup levelup-popup fullpage_backdrop dark" style="display: none;">
	<div class="backdrop_box large">
		<h1>Level up card</h1>
		<p id="levelup-disclaimer">
			Leveling up this card will permanently increase its properties as indicated below. Please choose which parts of this card you want to level up.
		</p>
		<br style="clear: both;">
		<ul class="levelup-buttons">
			<li>
				<a id="levelup-both-button" class="button button-lightblue buy-button" href="javascript:void(0);" onclick="if ($(this).hasClassName('disabled')) return; Devo.Main.Profile.levelUp('both');">Entire card</a>
				<div class="levelup-cost">
					<span id="levelup-cost-both"></span>XP<br>
					Upgrades the cards base HP and EP, as well as all its attacks
				</div>
			</li>
			<li>
				<a id="levelup-attacks-button" class="button button-lightblue buy-button" href="javascript:void(0);" onclick="if ($(this).hasClassName('disabled')) return; Devo.Main.Profile.levelUp('attacks');">Only attacks</a>
				<div class="levelup-cost">
					<span id="levelup-cost-attacks"></span>XP<br>
					Upgrades all the card's attacks
				</div>
			</li>
			<li>
				<a id="levelup-card-button" class="button button-lightblue buy-button" href="javascript:void(0);" onclick="if ($(this).hasClassName('disabled')) return; Devo.Main.Profile.levelUp('card');">Only base card</a>
				<div class="levelup-cost">
					<span id="levelup-cost-card"></span>XP<br>
					Upgrades the cards base HP and EP
				</div>
			</li>
			<li>
				<a class="button button-silver dontbuy-button" href="javascript:void(0);" onclick="Devo.Main.Profile.dontLevelUp();">Don't level up anything</a>
			</li>
		</ul>
		<div class="levelup-complete">
			<a class="button button-orange buy-button" href="javascript:void(0);" onclick="Devo.Main.Profile.dontLevelUp();">Done!</a><br>
		</div>
		<div id="levelup-indicator" style="display: none;">
			<img src="/images/spinning_20.gif">
		</div>
	</div>
</div>
<div id="sell-popup" class="buy-popup fullpage_backdrop dark" style="display: none;">
	<div class="backdrop_box large">
		<h1>Sell card</h1>
		<p id="sell-disclaimer">
			If you sell this card, you will receive a gold amount, and the card will be removed from your deck.<br>
			<u>There is no way to recover a sold card!</u><br>
			<br>
			<strong>Do you want to sell this card for <span id="sell-popup-cost"></span> gold?</strong>
		</p>
		<div class="buy-buttons">
			<a class="button button-green buy-button" href="javascript:void(0);" onclick="Devo.Market.sell();">Yes, sell this card</a>
			<a class="button button-silver dontbuy-button" href="javascript:void(0);" onclick="$('sell-popup').hide();">No</a>
		</div>
		<div id="sell-indicator" style="display: none;">
			<img src="/images/spinning_20.gif">
		</div>
	</div>
</div>
<div id="sell-complete" class="buy-popup fullpage_backdrop dark" style="display: none;">
	<div class="backdrop_box large">
		<h1>An exchange of gold has happened</h1>
		<p id="sell-complete-description">
			Thank you for doing business with us! We will totally not use your card against you, ever.
		</p>
		<div class="buy-buttons">
			<a class="button button-silver buy-button" href="javascript:void(0);" onclick="Devo.Market.dismissSellComplete();">OK, great!</a>
		</div>
	</div>
</div>
<div class="content left" id="profile-cards-container">
	<?php include_template('main/profiledetailstop'); ?>
	<h2 style="margin-bottom: 10px;">
		My card collection<br>
		<span id="top-shelf-menu-container" style="display: none; font-weight: normal; font-size: 0.7em;"><a href="javascript:void(0);" onclick="Devo.Main.loadProfile();">&laquo; Back to profile</a></span>
	</h2>
	<p>
		These are your cards, collected throughout the game, including your starter pack cards.
	</p>
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
		<button class="button button-silver last" id="card-itemclass-button" onclick="Devo.Main.Helpers.popup(this);return false;"></button>
		<div class="popup-menu" id="card-itemclass-popup" style="left: 0; right: auto; width: 350px; z-index: 10;">
			<ul>
				<?php foreach ($itemclasses as $itemclass => $description): ?>
					<li><a href="javascript:void(0);" data-filter="<?php echo $itemclass; ?>" onclick="Devo.Main.filterCardsItemClass('<?php echo $itemclass; ?>');"><?php echo $description; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<br style="clear: both;">
	<div class="shelf" id="cards-shelf">
		<?php if (count($cards)): ?>
			<ul>
				<?php foreach ($cards as $card): ?>
					<li <?php if (!($card->getCardType() == \application\entities\Card::TYPE_CREATURE)): ?>style="display: none;"<?php endif; ?>>
						<div onclick="Devo.Main.showCardDetails('<?php echo $card->getUniqueId(); ?>', true);" style="cursor: pointer;" id="card_<?php echo $card->getUniqueId(); ?>_container">
							<?php include_template('game/card', array('card' => $card, 'mode' => 'medium', 'ingame' => false)); ?>
						</div>
						<?php include_template('main/carddetails', compact('card')); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<div class="no_cards" style="position: absolute; font-size: 2em; font-weight: normal; color: rgba(200, 200, 200, 0.8); top: 100px; width: 500px; text-align: center; left: 50%; margin-left: -250px; z-index: 200;">You don't have any cards yet</div>
			<ul>
				<?php for ($cc = 0; $cc < 5; $cc++): ?>
					<li><div class="card medium flipped faded"></div></li>
				<?php endfor; ?>
			</ul>
		<?php endif; ?>
		<br style="clear: both;">
	</div>
</div>
<script>
	var first = true;
	$$('.card.creature').each(function(card) {
		if (first) {
			Devo.Main._default_race_filter = card.dataset.faction;
			first = false;
		}
	});
	Devo.Main.filterCardsCategory('creature');
</script>