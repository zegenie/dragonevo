<div id="card_<?php echo $card->getUniqueId(); ?>_details" class="card_details" style="display: none;">
	<div class="card_details_description">
		<h3><?php echo $card->getName(); ?></h3>
		<?php include_template('game/card', array('card' => $card, 'mode' => 'normal', 'ingame' => false, 'clone' => true)); ?>
		<p><?php echo nl2br($card->getLongDescription()); ?></p>
	</div>
	<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
		<div class="card_details_attacks">
			<h3>Attacks</h3>
			<?php foreach ($card->getAttacks() as $attack): ?>
				<h6><?php echo $attack->getName(); ?></h6>
				<p><?php echo $attack->getDescription(); ?></p>
				<div class="cardattack_damage"><?php include_template('game/cardattackdamage', compact('attack')); ?></div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<br style="clear: both;">
	<div class="card_details_actions">
		<h5>Actions</h5>
		<?php if ($card->getCardState() == application\entities\Card::STATE_TEMPLATE): ?>
			<a href="javascript:void(0);" onclick="Devo.Market.toggleBuy('<?php echo $card->getUniqueId(); ?>');" class="buy-card" id="buy_card_<?php echo $card->getUniqueId(); ?>"><img src="/images/glyph_sell.png">Buy card</a>
		<?php else: ?>
			<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
				<a href="javascript:void(0);" onclick="Devo.Main.Profile.toggleLevelup('<?php echo $card->getUniqueId(); ?>');" class="levelup-card" id="levelup_card_<?php echo $card->getUniqueId(); ?>"><img src="/images/glyph_levelup_green.png">Level up!</a>
			<?php endif; ?>
			<a href="javascript:void(0);" onclick="Devo.Market.toggleSell('<?php echo $card->getUniqueId(); ?>');" class="sell-card" id="sell_card_<?php echo $card->getUniqueId(); ?>"><img src="/images/glyph_sell.png">Sell card</a>
			<a href="javascript:void(0);" onclick="Devo.Main.Helpers.Message.success('This functionality is not implemented yet');" class="auction-card" id="auction_card_<?php echo $card->getUniqueId(); ?>"><img src="/images/glyph_auction.png">Put up for auction</a>
		<?php endif; ?>
		<a href="javascript:void(0);" onclick="Devo.Main.Helpers.Message.success('This functionality is not implemented yet');"><img src="/images/glyph_fullscreen.png">Look at card</a>
	</div>
	<br style="clear: both;">
</div>
