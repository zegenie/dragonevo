<?php foreach(array('Air', 'Dark', 'Earth', 'Fire', 'Freeze', 'Melee', 'Poison', 'Ranged') as $type): ?>
	<?php

		$increasesTypeAttackDamagePercentage = 'getIncreases'.$type.'AttackDamagePercentage';
		$increasesTypeAttackDmpPercentage = 'getIncreases'.$type.'AttackDmpPercentage';
		$decreasesTypeAttackDamagePercentage = 'getDecreases'.$type.'AttackDamagePercentage';
		$decreasesTypeAttackDmpPercentage = 'getDecreases'.$type.'AttackDmpPercentage';

	?>
	<?php if ($card->$increasesTypeAttackDamagePercentage()): ?>
		<div class="modification"><?php echo image_tag('/images/attack_'.strtolower($type).'.png'); ?> +<?php echo $card->$increasesTypeAttackDamagePercentage(); ?>%</div>
	<?php elseif ($card->$decreasesTypeAttackDamagePercentage()): ?>
		<div class="modification"><?php echo image_tag('/images/attack_'.strtolower($type).'.png'); ?> -<?php echo $card->$decreasesTypeAttackDamagePercentage(); ?>%</div>
	<?php endif; ?>
	<?php if ($card->$increasesTypeAttackDmpPercentage()): ?>
		<div class="modification"><?php echo image_tag('/images/attack_'.strtolower($type).'.png').image_tag('/images/dmp_small.png'); ?> +<?php echo $card->$increasesTypeAttackDmpPercentage(); ?>%</div>
	<?php elseif ($card->$decreasesTypeAttackDmpPercentage()): ?>
		<div class="modification"><?php echo image_tag('/images/attack_'.strtolower($type).'.png').image_tag('/images/dmp_small.png'); ?> -<?php echo $card->$decreasesTypeAttackDmpPercentage(); ?>%</div>
	<?php endif; ?>
<?php endforeach; ?>
