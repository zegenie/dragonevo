<?php if ($card instanceof application\entities\Card): ?>
	<?php $card_id = (isset($clone) && $clone) ? $card->getUniqueId().'_'.rand(123456, 654321) : $card->getUniqueId(); ?>
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
					echo ($card->isDefensive()) ? ' item-defend' : ' item-attack';
					break;
			}

		?> <?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE) echo $card->getFaction() . ' class-' . $card->getCreatureClassKey(); ?><?php if (isset($mode)) echo " $mode"; ?><?php if ($card->isOwned() && $card->getUserId() == $csp_user->getId()) echo ' player'; ?><?php if ($card->isOwned() && $card->getUserId() != $csp_user->getId()) echo ' opponent'; ?><?php if (isset($selected) && $selected && $ingame) echo " selected"; ?><?php if ($card->getSlot() != 0 && $card->isInPlay() && $ingame) echo ' placed'; ?><?php if ($card->getSlot() != 0 && !$card->isInPlay() && $card->isOwned() && $ingame && $card->getUserId() != $csp_user->getId() && ((!isset($mode) || $mode != 'flipped'))) echo ' flipped'; ?><?php
		
			if ($card->getCardType() == application\entities\Card::TYPE_CREATURE && $ingame) {
				foreach ($card->getValidEffects() as $effect) { echo ' effect-'.$effect; }
			}
			if ($card->getCardType() == application\entities\Card::TYPE_EQUIPPABLE_ITEM) {
				echo ' equippable-item-class-'.$card->getItemClass();
			}

		?>"
		 id="card_<?php echo $card_id; ?>"
		 data-card-id="<?php echo $card_id; ?>"
		 data-original-card-id="<?php echo $card->getOriginalCardId(); ?>"
		 data-slot-no="<?php echo $card->getSlot(); ?>"
		 <?php if ($card->getCardState() == application\entities\Card::STATE_TEMPLATE): ?>
			data-cost="<?php echo $card->getCost(); ?>"
		 <?php endif; ?>
		 <?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
			 data-ep="<?php echo $card->getEP(); ?>"
			 data-hp="<?php echo $card->getHP(); ?>"
			 data-faction="<?php echo $card->getFaction(); ?>"
		 <?php elseif ($card->getCardType() == application\entities\Card::TYPE_EQUIPPABLE_ITEM): ?>
			 <?php if ($card->isEquippableByCivilianCards()): ?> data-equippable-by-civilian="true"<?php endif; ?>
			 <?php if ($card->isEquippableByMagicCards()): ?> data-equippable-by-magic="true"<?php endif; ?>
			 <?php if ($card->isEquippableByMilitaryCards()): ?> data-equippable-by-military="true"<?php endif; ?>
			 <?php if ($card->isEquippableByPhysicalCards()): ?> data-equippable-by-physical="true"<?php endif; ?>
			 <?php if ($card->isEquippableByRangedCards()): ?> data-equippable-by-ranged="true"<?php endif; ?>
			 data-equippable-item-class="<?php echo $card->getItemClass(); ?>"
			 <?php foreach (array('air', 'dark', 'earth', 'fire', 'freeze', 'melee', 'poison', 'ranged') as $type): ?>
				<?php list($increaseMethod, $decreaseMethod) = array("getIncreases".ucfirst($type)."AttackDamagePercentage", "getDecreases".ucfirst($type)."AttackDamagePercentage"); ?>
				data-increases-<?php echo $type; ?>-attack="<?php echo $card->$increaseMethod(); ?>"
				data-decreases-<?php echo $type; ?>-attack="<?php echo $card->$decreaseMethod(); ?>"
			 <?php endforeach; ?>
		 <?php endif; ?>
	>
		<?php if ($card->getCardState() == application\entities\Card::STATE_TEMPLATE || (isset($sellmode) && $sellmode)): ?>
			<div class="card_cost">
				<span><?php echo (isset($sellmode) && $sellmode) ? $card->getSellValue() : $card->getCost(); ?></span>
				<div class="cost_underlay"></div>
			</div>
		<?php endif; ?>
		<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE && $card->getGPTPlayerModifier()): ?>
			<div class="gold_increase">
				<div class="tooltip from-above">Effect on your gold</div>
				<span><?php echo ($card->getGPTDecreasePlayer()) ? '-' : '+'; ?></span><?php echo $card->getGPTPlayerModifier(); ?>
			</div>
		<?php endif; ?>
		<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE && $card->getGPTOpponentModifier()): ?>
			<div class="gold_increase opponent">
				<div class="tooltip from-above">Effect on opponents gold</div>
				<span><?php echo ($card->getGPTDecreaseOpponent()) ? '-' : '+'; ?></span><?php echo $card->getGPTOpponentModifier(); ?>
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
			<div class="hp" title="Max HP: <?php echo $card->getBaseHP(); ?>"><?php echo ($ingame) ? $card->getHP() : $card->getBaseHP(); ?></div>
			<div class="ep magic" title="Max EP: <?php echo $card->getBaseEP(); ?>"><?php echo ($ingame) ? $card->getEP() : $card->getBaseEP(); ?></div>
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
		<?php if ($card->getCardState() == application\entities\Card::STATE_OWNED && $card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
			<div class="card_level">
				<div class="bg"></div>
				<div class="level"><?php echo $card->getUserCardLevel(); ?></div>
			</div>
		<?php endif; ?>
		<?php if ($card->getCardType() == application\entities\Card::TYPE_EQUIPPABLE_ITEM): ?>
			<div class="item_class">
				<div class="bg"></div>
				<div class="img"></div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>