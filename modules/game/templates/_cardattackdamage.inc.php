<?php if ($attack->hasAttackPointsRange()): ?>
	Deals <?php echo $attack->getAttackPointsMin() . '-' . $attack->getAttackPointsMax(); ?> HP damage
<?php elseif ($attack->getAttackPointsMin()): ?>
	Deals <?php echo $attack->getAttackPointsMin(); ?> HP damage
<?php elseif ($attack->isBonusAttack()): ?>
	<?php if ($attack->doesRegenerateHP()): ?>
		(Re-)generates <?php echo $attack->getGenerateHpAmount(); ?>% HP
	<?php elseif ($attack->doesRegenerateEP()): ?>
		(Re-)generates <?php echo $attack->getGenerateMagicAmount(); ?> EP
	<?php elseif ($attack->doesGenerateGold()): ?>
		Generates <?php echo $attack->getGenerateGoldAmount(); ?> gold
	<?php endif; ?>
<?php endif; ?>
<?php if ($attack->isRepeatable()): ?>
	<?php if ($attack->hasRepeatAttackPointsRange()): ?>
		+ <?php echo $attack->getRepeatAttackPointsMin() . '-' . $attack->getRepeatAttackPointsMax(); ?> HP
	<?php else: ?>
		+ <?php echo $attack->getRepeatAttackPointsMin(); ?>
	<?php endif; ?>
	HP
	<?php if ($attack->hasRepeatRoundsRange()): ?>
		<?php echo $attack->getRepeatRoundsMin() . '-' . $attack->getRepeatRoundsMax(); ?> time(s)
	<?php else: ?>
		<?php echo $attack->getRepeatRoundsMin(); ?> time(s)
	<?php endif; ?>
<?php endif; ?>
<br>
<?php if ($attack->getRequiresLevel()): ?>
	<div class="attack_unblockable">This attack requires a character level <?php echo $attack->getRequiresLevel(); ?> or higher</div>
<?php endif; ?>
<?php if ($attack->isUnblockable()): ?>
	<div class="attack_unblockable">This attack cannot be blocked!</div>
<?php endif; ?>
<?php if ($attack->getPenaltyDmg()): ?>
	<div class="attack_steal_gold">Damages self <?php echo $attack->getPenaltyDmg(); ?>HP!</div>
<?php endif; ?>
<?php if ($attack->hasOwnPenaltyRounds()): ?>
	<div class="attack_unblockable">
		<?php if ($attack->hasPenaltyRoundsRange()): ?>
			Stuns self for <?php echo $attack->getPenaltyRoundsMin() . '-' . $attack->getPenaltyRoundsMax(); ?> round(s)
		<?php else: ?>
			Stuns self for <?php echo $attack->getPenaltyRoundsMin(); ?> round(s)
		<?php endif; ?>
	</div>
<?php endif; ?>
<?php if ($attack->hasEffect()): ?>
	<?php

		$effect_duration = ($attack->hasEffectDurationRange()) ? $attack->getEffectDurationMin() . '-' . $attack->getEffectDurationMax() : $attack->getEffectDurationMin();
		$effect_percentage = ($attack->hasEffectPercentageRange()) ? $attack->getEffectPercentageMin() . '-' . $attack->getEffectPercentageMax() : $attack->getEffectPercentageMin();
		$reduced_effect_percentage = ($attack->hasEffectPercentageRange()) ? ceil($attack->getEffectPercentageMin() / 2) . '-' . ceil($attack->getEffectPercentageMax() / 2) : ceil($attack->getEffectPercentageMin() / 2);

		switch ($attack->getAttackType()) {
			case \application\entities\Attack::TYPE_AIR:
				echo "<div class=\"attack_unblockable\">Damages {$effect_percentage}% of attacked card's max HP for {$effect_duration} round(s)</div>";
				echo "<div class=\"attack_unblockable\">May remove one of the opponent's item cards</div>";
				echo "<div class=\"attack_unblockable\">10% chance of stunning the opponent for 1 round</div>";
				break;
			case \application\entities\Attack::TYPE_DARK:
				echo "<div class=\"attack_unblockable\">{$effect_percentage}% chance of causing dark magic effect for {$effect_duration} round(s)</div>";
				echo "<div class=\"attack_unblockable\">(Dark magic reduces opponents damage capabilities by 10-50%)</div>";
				break;
			case \application\entities\Attack::TYPE_EARTH:
				echo "<div class=\"attack_unblockable\">Damages {$effect_percentage}% of attacked card's max HP</div>";
				echo "<div class=\"attack_unblockable\">50% chance of either damaging 1-2 adjacent cards by {$reduced_effect_percentage}% of max HP or stunning 1-2 adjacent cards for {$effect_duration} round(s)</div>";
				break;
			case \application\entities\Attack::TYPE_FIRE:
				echo "<div class=\"attack_unblockable\">Damages {$effect_percentage}% of attacked card's max HP for {$effect_duration} round(s)</div>";
				break;
			case \application\entities\Attack::TYPE_FREEZE:
				echo "<div class=\"attack_unblockable\">{$effect_percentage}% chance of freezing or stunning opponent for {$effect_duration} round(s)</div>";
				break;
			case \application\entities\Attack::TYPE_POISON:
				echo "<div class=\"attack_unblockable\">{$effect_percentage}% chance of poisoning attacked card for {$effect_duration} round(s)</div>";
				echo "<div class=\"attack_unblockable\">(Poison reduces opponents damage capabilities by 10-50%)</div>";
				break;
			default:
				echo "<div class=\"attack_unblockable\">{$effect_percentage}% chance of stunning opponent for {$effect_duration} round(s)</div>";
				break;
		}

	?>
<?php endif; ?>
<?php if ($attack->canStealMagic()): ?>
	<div class="attack_steal_magic"><?php echo $attack->getStealMagicChance(); ?>% chance of stealing up to <?php echo $attack->getStealMagicAmount(); ?>% EP</div>
<?php endif; ?>
<?php if ($attack->canStealGold()): ?>
	<div class="attack_steal_gold"><?php echo $attack->getStealGoldChance(); ?>% chance of stealing up to <?php echo $attack->getStealGoldAmount(); ?>% gold</div>
<?php endif; ?>