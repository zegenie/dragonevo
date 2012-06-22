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
	<?php if ($attack->hasRepeatRoundsRange()): ?>
		for <?php echo $attack->getRepeatRoundsMin() . '-' . $attack->getRepeatRoundsMax(); ?> round(s)
	<?php else: ?>
		for <?php echo $attack->getRepeatRoundsMin(); ?> round(s)
	<?php endif; ?>
<?php endif; ?>
<br>
<?php if ($attack->canStun()): ?>
	<?php if ($attack->hasStunPercentageRange()): ?>
		+ <?php echo $attack->getStunPercentageMin() . '-' . $attack->getStunPercentageMax(); ?>% chance of stunning the opponent
	<?php else: ?>
		+ <?php echo $attack->getStunPercentageMin(); ?>% chance of stunning the opponent
	<?php endif; ?>
	<?php if ($attack->hasStunDurationRange()): ?>
		for <?php echo $attack->getStunDurationMin() . '-' . $attack->getStunDurationMax(); ?> round(s)
	<?php else: ?>
		for <?php echo $attack->getStunDurationMin(); ?> round(s)
	<?php endif; ?>
	<br>
<?php endif; ?>
<?php if ($attack->isUnblockable()): ?>
	<div class="attack_unblockable">This attack cannot be blocked!</div>
<?php endif; ?>
<?php if ($attack->canStealGold()): ?>
	<div class="attack_steal_gold"><?php echo $attack->getStealGoldChance(); ?>% chance of stealing up to <?php echo $attack->getStealGoldAmount(); ?>% gold</div>
<?php endif; ?>
<?php if ($attack->canStealMagic()): ?>
	<div class="attack_steal_magic"><?php echo $attack->getStealMagicChance(); ?>% chance of stealing up to <?php echo $attack->getStealMagicAmount(); ?>% EP</div>
<?php endif; ?>