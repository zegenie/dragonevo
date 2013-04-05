<?php include_template('market/leftmenu', array('section' => 'frontpage')); ?>
<?php include_template('market/buyoverlay'); ?>
<div class="content market left" id="market-container" style="width: 985px; height: auto; overflow-y: auto;">
	<h1 style="margin-bottom: 10px;">
		Market frontpage
	</h1>
	<div class="shelf" id="cards-shelf">
		<ul>
			<?php foreach ($allcards as $cards): ?>
				<?php foreach ($cards as $card): ?>
					<li>
						<div onclick="Devo.Main.showCardDetails('<?php echo $card->getUniqueId(); ?>');" style="cursor: pointer;">
							<?php include_template('game/card', array('card' => $card, 'ingame' => false)); ?>
						</div>
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