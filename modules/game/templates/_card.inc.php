<?php if ($card instanceof application\entities\Card): ?>
	<?php $card_id = $card->getUniqueId(); ?>
	<div draggable="true" class="card <?php
			switch ($card->getCardType()) {
				case application\entities\Card::TYPE_CREATURE:
					echo 'creature';
					break;
				case application\entities\Card::TYPE_EVENT:
					echo 'event';
					break;
				case application\entities\Card::TYPE_POTION_ITEM:
					echo 'potion_item item';
					break;
				case application\entities\Card::TYPE_EQUIPPABLE_ITEM:
					echo 'equippable_item item';
					break;
			}
		?> <?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE) echo $card->getFaction(); ?><?php if (isset($mode)) echo " $mode"; ?><?php if (isset($selected) && $selected) echo " selected"; ?><?php if ($card->getSlot() != 0 && $card->isInPlay()) echo ' placed'; ?><?php if ($card->getSlot() != 0 && !$card->isInPlay() && $card->isOwned() && $card->getUser()->getId() != $csp_user->getId() && ((!isset($mode) || $mode != 'flipped'))) echo ' flipped'; ?>" id="card_<?php echo $card_id; ?>" data-card-id="<?php echo $card_id; ?>">
		<div class="name" id="card_<?php echo $card_id; ?>_name"><?php echo strtoupper($card->getName()); ?></div>
		<div class="card_image" id="card_<?php echo $card_id; ?>_image" style="background-image: url('/images/cards/<?php echo $card->getKey(); ?>.png');">
		</div>
		<div class="card_reflection">
			<img src="/images/cards/<?php echo $card->getKey(); ?>.png" id="card_<?php echo $card_id; ?>_image_reflection">
			<div class="cover"></div>
		</div>
		<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
			<div class="attacks">
				<?php foreach ($card->getAttacks() as $attack): ?>
					<?php include_component('game/cardattack', compact('attack')); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
			<div class="hp"><?php echo $card->getHP(); ?></div>
			<div class="magic"><?php echo ($card->getEP()) ? $card->getEP() : '-'; ?></div>
			<div class="dmp"><div class="box"><?php echo ($card->isOwned()) ? (($card->getUserDMP()) ? $card->getUserDMP() : '-') : $card->getBaseDMP(); ?></div></div>
		<?php endif; ?>
		<div class="selection_indicator"><img src="/images/icon_ok.png"></div>
	</div>
<?php endif; ?>