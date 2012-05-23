<?php if ($attack instanceof application\entities\Attack): ?>
	<div class="attack <?php echo strtolower($attack_types[$attack->getAttackType()]); ?>">
		<div class="attack_name"><?php echo $attack->getName(); ?></div>
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
		<div class="attack_impact"><?php
		
			if ($attack->hasAttackPointsRange()) {
				echo $attack->getAttackPointsMin() . '-' . $attack->getAttackPointsMax();
			} else {
				echo $attack->getAttackPointsMin();
			}
			echo 'HP';
			
			if ($attack->isRepeatable()) {
				echo ' (+';
				if ($attack->hasRepeatAttackPointsRange()) {
					echo $attack->getRepeatAttackPointsMin() . '-' . $attack->getRepeatAttackPointsMax();
				} else {
					echo $attack->getRepeatAttackPointsMin();
				}
				echo 'HP x ';
				if ($attack->hasRepeatRoundsRange()) {
					echo $attack->getRepeatRoundsMin() . '-' . $attack->getRepeatRoundsMax();
				} else {
					echo $attack->getRepeatRoundsMin();
				}
				echo ')';
			}
			
		?></div>
		<div class="tooltip attack_details <?php echo strtolower($attack_types[$attack->getAttackType()]); ?>">
			<div class="attack_name"><?php echo $attack->getName(); ?></div>
			<div class="attack_description">
				<?php echo nl2br($attack->getDescription()); ?><br>
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
			</div>
		</div>
	</div>
<?php endif; ?>