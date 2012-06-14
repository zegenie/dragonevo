<?php if ($attack instanceof application\entities\Attack): ?>
	<div class="attack <?php echo strtolower($attack_types[$attack->getAttackType()]); ?>" data-attack-id="<?php echo $attack->getId(); ?>" data-cost-gold="<?php echo $attack->getCostGold(); ?>" data-cost-ep="<?php echo $attack->getCostMagic(); ?>" id="attack_<?php echo $attack->getId(); ?>">
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
				<br>
				<?php include_template('game/cardattackdamage', compact('attack')); ?>
			</div>
		</div>
	</div>
<?php endif; ?>