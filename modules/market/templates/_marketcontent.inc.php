<?php include_template('market/leftmenu', array('section' => 'frontpage')); ?>
<?php include_template('market/buyoverlay'); ?>
<div class="content market left" id="market-container" style="width: 985px; height: auto; overflow-y: auto;">
	<h1 style="margin-bottom: 10px;">
		Market frontpage
	</h1>
	<p style="margin-bottom: 20px;">
		Have a look at some of the cards showcased below. Not part of your everyday deck, but if you earn enough gold, they can be yours!
	</p>
	<h5>
		Showcase
	</h5>
	<div class="shelf showcase" id="cards-shelf">
		<ul>
			<?php $cc = 0; ?>
			<?php foreach ($showcasedcards as $card): ?>
				<?php if ($cc == 3) break; ?>
				<li>
					<div onclick="Devo.Main.Helpers.popup($(this));" style="cursor: pointer;">
						<?php include_template('game/card', array('card' => $card, 'mode' => 'normal', 'ingame' => false)); ?>
					</div>
					<div class="popup-menu below" style="width: 255px; right: auto; margin-top: 15px; left: <?php echo 60 + (305 * $cc); ?>px;">
						<ul>
							<li><a href="javascript:void(0);" onclick="Devo.Main.loadMarketBuy(<?php

									switch ($card->getCardType()) {
										case \application\entities\Card::TYPE_CREATURE:
											echo "{category: 'creature', race: '".$card->getFaction()."'}";
											break;
										case \application\entities\Card::TYPE_EQUIPPABLE_ITEM:
											echo "{category: 'equippable_item', itemclass: '".$card->getItemClass()."'}";
											break;
										case \application\entities\Card::TYPE_POTION_ITEM:
											echo "{category: 'potion_item', itemclass: '".$card->getItemClass()."'}";
											break;
									}

							?>);">Show card in market</a></li>
						</ul>
					</div>
				</li>
				<?php $cc++; ?>
			<?php endforeach; ?>
		</ul>
		<br style="clear: both;">
	</div>
</div>