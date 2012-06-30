<?php if ($card instanceof application\entities\Card): ?>
	<?php $card_id = $card->getUniqueId(); ?>
	<div <?php if ($ingame): ?>draggable="true" <?php endif; ?>
		 class="card <?php

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

		?> <?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE) echo $card->getFaction() . ' class-' . $card->getCreatureClassKey(); ?><?php if (isset($mode)) echo " $mode"; ?><?php if($card->isOwned() && $card->getUser()->getId() == $csp_user->getId()) echo ' player'; ?><?php if (isset($selected) && $selected && $ingame) echo " selected"; ?><?php if ($card->getSlot() != 0 && $card->isInPlay() && $ingame) echo ' placed'; ?><?php if ($card->getSlot() != 0 && !$card->isInPlay() && $card->isOwned() && $ingame && $card->getUser()->getId() != $csp_user->getId() && ((!isset($mode) || $mode != 'flipped'))) echo ' flipped'; ?><?php
		
			if ($card->getCardType() == application\entities\Card::TYPE_CREATURE && $ingame) {
				foreach ($card->getValidEffects() as $effect) { echo ' effect-'.$effect; }
			}
		
		?>"
		 id="card_<?php echo $card_id; ?>"
		 data-card-id="<?php echo $card_id; ?>"
		 data-slot-no="<?php echo $card->getSlot(); ?>"
		 <?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
			 data-ep="<?php echo $card->getEP(); ?>"
			 data-hp="<?php echo $card->getHP(); ?>"
		 <?php elseif ($card->getCardType() == application\entities\Card::TYPE_EQUIPPABLE_ITEM): ?>
			 <?php if ($card->isEquippableByCivilianCards()): ?> data-equippable-by-civilian="true"<?php endif; ?>
			 <?php if ($card->isEquippableByMagicCards()): ?> data-equippable-by-magic="true"<?php endif; ?>
			 <?php if ($card->isEquippableByMilitaryCards()): ?> data-equippable-by-military="true"<?php endif; ?>
			 <?php if ($card->isEquippableByPhysicalCards()): ?> data-equippable-by-physical="true"<?php endif; ?>
			 <?php if ($card->isEquippableByRangedCards()): ?> data-equippable-by-ranged="true"<?php endif; ?>
		 <?php endif; ?>
	>
		<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE && $card->getGPTPlayerModifier()): ?>
			<div class="gold_increase">
				<span><?php echo ($card->getGPTDecreasePlayer()) ? '-' : '+'; ?></span><?php echo $card->getGPTPlayerModifier(); ?>
			</div>
		<?php endif; ?>
		<div class="name" id="card_<?php echo $card_id; ?>_name" title="<?php echo ucfirst($card->getName()); ?>"><?php echo strtoupper($card->getName()); ?></div>
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
			<div class="ep magic"><?php echo $card->getEP(); ?></div>
			<div class="dmp"><div class="box"><?php echo ($card->isOwned()) ? (($card->getUserDMP()) ? $card->getUserDMP() : '-') : $card->getBaseDMP(); ?></div></div>
		<?php endif; ?>
		<div class="stunned_overlay"><span>Stunned!</span></div>
		<div class="freeze_overlay"><div class="freeze-color"></div></div>
		<?php if ($card->getCardType() != application\entities\Card::TYPE_CREATURE): ?>
			<div class="description">
				<div class="description_content">
					<?php echo $card->getBriefDescription(); ?>
				</div>
				<?php if ($card->getLongDescription()): ?>
					<div class="tooltip"><?php echo $card->getLongDescription(); ?></div>
				<?php endif; ?>
			</div>
			<?php if ($card->getCardType() == application\entities\Card::TYPE_EQUIPPABLE_ITEM): ?>
				<div class="modifier_summary">
					<?php include_template('game/cardmodifiersummary', compact('card')); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if ($card->getCardType() == application\entities\Card::TYPE_POTION_ITEM): ?>
			<div class="attacks">
				<?php include_template('game/potionattack', compact('card')); ?>
			</div>
		<?php endif; ?>
		<div class="selection_indicator"><img src="/images/icon_ok.png"></div>
	</div>
<?php endif; ?>