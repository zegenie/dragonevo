<?php if ($attack instanceof application\entities\Attack): ?>
	<div id="attack_<?php echo $attack->getId(); ?>" onclick="$(this).toggleClassName('selected');" class="attack <?php echo strtolower($attack_types[$attack->getAttackType()]); ?><?php

			if ($eq_1 = $attack->getRequiresItemCardType1()) {
				echo ' equippable-requires-'.$eq_1;
			}
			if ($eq_2 = $attack->getRequiresItemCardType2()) {
				echo ' equippable-requires-'.$eq_2;
			}
			if ($attack->isForageAttack()) echo ' forage';
			elseif ($attack->isStealAttack()) echo ' steal';

		?>" 
		data-attack-id="<?php echo $attack->getId(); ?>"
		data-cost-gold="<?php echo $attack->getCostGold(); ?>"
		data-cost-ep="<?php echo $attack->getCostMagic(); ?>"
		data-requires-level="<?php echo $attack->getRequiresLevel(); ?>"
		data-requires-equippable-class-one="<?php echo $eq_1; ?>"
		data-requires-equippable-class-two="<?php echo $eq_2; ?>"
		data-attack-type="<?php echo $attack->getAttackType(); ?>"
		<?php if ($attack->isBonusAttack()): ?> data-is-bonus-attack <?php endif; ?>
		<?php if ($attack->isForageAttack()): ?> data-is-forage-attack <?php endif; ?>
		<?php if ($attack->isStealAttack()): ?> data-is-steal-attack <?php endif; ?>
		<?php if ($attack->doesAttackAll()): ?> data-does-attack-all <?php endif; ?>
		<?php if ($attack->doesRequireBothItems()): ?> data-requires-equippable-both <?php endif; ?>
		>
		<div class="attack_hover" onclick="$(this).toggleClassName('selected');">
			<div class="<?php if (isset($ingame) && $ingame) echo 'attack_tooltip'; ?> tooltip attack_details <?php echo strtolower($attack_types[$attack->getAttackType()]); ?>">
				<div class="attack_name"><?php echo $attack->getName(); ?></div>
				<div class="attack_description">
					<?php if ($eq_1 = $attack->getRequiresItemCardType1()): ?>
						<div class="attack_steal_gold requires-card">
							<?php if ($attack->getRequiresItemCardType2() == $eq_1): ?>
								Requires <?php echo (!$attack->doesRequireBothItems()) ? 'one or two' : 'two'; ?> equipped <?php

								$item_classes = \application\entities\ItemCard::getItemClasses();
								echo strtolower($item_classes[$eq_1]);

								?> item cards
							<?php else: ?>
								Requires an equipped <?php

								$item_classes = \application\entities\ItemCard::getItemClasses();
								echo strtolower($item_classes[$eq_1]);

								?> item card
								<?php if ($eq_2 = $attack->getRequiresItemCardType2()): ?>
									<?php echo ($attack->doesRequireBothItems()) ? 'and' : 'or'; ?>
									an equipped <?php echo strtolower($item_classes[$eq_2]); ?> item card
								<?php endif; ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php echo nl2br($attack->getDescription()); ?><br>
					<br>
					<?php include_template('game/cardattackdamage', compact('attack')); ?>
				</div>
			</div>
		</div>
		<?php if ($attack->getRequiresLevel()): ?><div class="attack_level"><?php echo $attack->getRequiresLevel(); ?></div><?php endif; ?>
		<div class="attack_name"><?php echo $attack->getName(); ?></div>
		<?php if ($attack->hasCostMagic() || $attack->hasCostGold()): ?>
			<div class="attack_cost">
				<?php if ($attack->hasCostGold()): ?>
					<div class="cost_gold"><?php echo $attack->getCostGold(); ?></div>
				<?php endif; ?>
				<?php if ($attack->hasCostMagic() && $attack->hasCostGold()): ?>
					<div class="plus">+</div>
				<?php endif; ?>
				<?php if ($attack->hasCostMagic()): ?>
					<div class="cost_magic"><?php echo $attack->getCostMagic(); ?></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="attack_impact<?php if ($attack->isBonusAttack() && $attack->doesRegenerateHP()) echo ' bonus_health'; ?><?php if ($attack->isBonusAttack() && $attack->doesRegenerateEP()) echo ' bonus_ep'; ?><?php if ($attack->isStealAttack() || $attack->isForageAttack()) echo ' bonus_gold'; ?>"><?php
		
			if ($attack->hasAttackPointsRange()) {
				echo "Deals " . $attack->getAttackPointsMin() . '-' . $attack->getAttackPointsMax() . 'HP damage';
			} elseif ($attack->getAttackPointsMin()) {
				echo "Deals " . $attack->getAttackPointsMin() . 'HP damage';
			} elseif ($attack->isBonusAttack()) {
				if ($attack->doesRegenerateHP()) {
					echo 'Regenerates '.$attack->getGenerateHpAmount().'% HP';
				} elseif ($attack->doesRegenerateEP()) {
					echo 'Generates '.$attack->getGenerateMagicAmount().' EP';
				}
			} elseif ($attack->isStealAttack()) {
				echo 'Steals 0-'.$attack->getStealGoldAmount().'% gold ('.$attack->getStealGoldChance().'% chance)';
			} elseif ($attack->isForageAttack()) {
				echo 'Generates '.$attack->getGenerateGoldAmount().' gold';
			}
			
			if ($attack->isRepeatable()) {
				echo '<br>+';
				if ($attack->hasRepeatAttackPointsRange()) {
					echo $attack->getRepeatAttackPointsMin() . '-' . $attack->getRepeatAttackPointsMax();
				} else {
					echo $attack->getRepeatAttackPointsMin();
				}
				echo 'HP damage x ';
				if ($attack->hasRepeatRoundsRange()) {
					echo $attack->getRepeatRoundsMin() . '-' . $attack->getRepeatRoundsMax();
				} else {
					echo $attack->getRepeatRoundsMin();
				}
			}

            if ($eq_1 = $attack->getRequiresItemCardType1()) {
                $item_classes = \application\entities\ItemCard::getItemClasses();
                echo '<br><span class="requires">';
                echo 'Requires ';
                if ($attack->getRequiresItemCardType2() == $eq_1) {
                    echo (!$attack->doesRequireBothItems()) ? 'one or two' : 'two';
                    echo ' equipped '.strtolower($item_classes[$eq_1]).' item card(s)';
                } else {
                    echo 'equipped ';
                    echo strtolower($item_classes[$eq_1]);
                    if ($eq_2 = $attack->getRequiresItemCardType2()) {
                        echo ($attack->doesRequireBothItems()) ? ' and ' : ' or ';
                        echo 'equipped '.strtolower($item_classes[$eq_1]);
                    }
                    echo ' card(s)';
                }
                echo '</span>';
            }

		?></div>
        <div class="attack_bonus"></div>
	</div>
<?php endif; ?>
