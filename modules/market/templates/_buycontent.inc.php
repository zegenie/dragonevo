<?php include_template('market/leftmenu', array('section' => 'buy')); ?>
<?php include_template('market/buyoverlay'); ?>
<div class="content market left" id="market-container-buy" style="width: 985px; height: auto; overflow: visible;">
	<h2 style="margin-bottom: 10px;">
		Market
	</h2>
	<div class="button-group shelf-filter" style="position: relative;">
		<button class="button button-silver" data-selected-filter="creature" id="card-category-button" onclick="Devo.Main.Helpers.popup(this);">Creature cards<span>&#9660;</span></button>
		<div class="popup-menu" id="card-category-popup" style="left: 0; right: auto; width: 350px; z-index: 10;">
			<ul>
				<li><a href="javascript:void(0);" data-filter="creature" onclick="Devo.Main.filterCardsCategory('creature');">Creature cards</a></li>
				<li><a href="javascript:void(0);" data-filter="equippable_item" onclick="Devo.Main.filterCardsCategory('equippable_item');">Item cards</a></li>
				<li><a href="javascript:void(0);" data-filter="potion_item" onclick="Devo.Main.filterCardsCategory('potion_item');">Potion cards</a></li>
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
		<div id="shelf-loading" class="cssloader"><img src="/images/spinner.png"></div>
		<br style="clear: both;">
	</div>
</div>