<?php if ($attack->hasAttackPointsRange()): ?>
	Deals <?php echo $attack->getAttackPointsMin() . '-' . $attack->getAttackPointsMax(); ?> HP damage
<?php else: ?>
	Deals <?php echo $attack->getAttackPointsMin(); ?> HP damage
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
<?php if ($attack->isUnblockable()): ?>
	<div class="attack_unblockable">This attack cannot be blocked!</div>
<?php endif; ?>
<?php if ($attack->canStealGold()): ?>
	<div class="attack_steal_gold"><?php echo $attack->getStealGoldChance(); ?>% chance of stealing up to <?php echo $attack->getStealGoldAmount(); ?>% gold</div>
<?php endif; ?>
<?php if ($attack->canStealMagic()): ?>
	<div class="attack_steal_magic"><?php echo $attack->getStealMagicChance(); ?>% chance of stealing up to <?php echo $attack->getStealMagicAmount(); ?>% EP</div>
<?php endif; ?>