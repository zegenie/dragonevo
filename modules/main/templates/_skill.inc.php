<div id="skill_<?php echo $skill->getId(); ?>" 
	 class="skill<?php if ($trained) echo ' trained'; ?><?php if (isset($first)) echo ' first'; ?>"
	 <?php if (!$trained): ?> onclick="Devo.Main.Profile.toggleSkillTraining(<?php echo $skill->getId(); ?>);" style="cursor: pointer;"<?php endif; ?>
	 data-required-level="<?php echo $skill->getRequiredLevel(); ?>"
	 data-xp-cost="<?php echo $skill->getXpCost(); ?>"
	 >
	<h1>
		<?php echo $skill->getName(); ?><br>
		<span class="training">(selected for training)</span><span class="trained">(trained)</span>
	</h1>
	<p><?php echo $skill->getDescription(); ?></p>
	<fieldset>
		<legend>Requirements / cost</legend>
	</fieldset>
	<div class="xp-cost"> <?php echo $skill->getXpCost(); ?>XP</div>
	<div class="requires-level">Minimum level <?php echo $skill->getRequiredLevel(); ?></div>
	<fieldset>
		<legend>Player bonuses</legend>
	</fieldset>
	<?php $cc = 0; ?>
	<?php foreach(array('Air', 'Dark', 'Earth', 'Fire', 'Freeze', 'Melee', 'Poison', 'Ranged') as $type): ?>
		<?php

			$increasesTypeAttackDamagePercentage = 'getIncreases'.$type.'AttackDamagePercentage';
			$increasesTypeAttackDmpPercentage = 'getIncreases'.$type.'AttackDmpPercentage';

		?>
		<?php if ($skill->$increasesTypeAttackDamagePercentage()): ?>
			<?php $cc++; ?>
			<div class="modification"><?php echo image_tag('/images/attack_'.strtolower($type).'.png'); ?> +<?php echo $skill->$increasesTypeAttackDamagePercentage(); ?>%</div>
		<?php endif; ?>
		<?php if ($skill->$increasesTypeAttackDmpPercentage()): ?>
			<?php $cc++; ?>
			<div class="modification"><?php echo image_tag('/images/dmp_small.png').image_tag('/images/attack_'.strtolower($type).'.png'); ?> +<?php echo $skill->$increasesTypeAttackDmpPercentage(); ?>%</div>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php if (!$cc): ?>
		<span class="faded">None</span>
	<?php endif; ?>
	<fieldset>
		<legend>Opponent penalties</legend>
		<?php $cc = 0; ?>
	</fieldset>
	<?php foreach(array('Air', 'Dark', 'Earth', 'Fire', 'Freeze', 'Melee', 'Poison', 'Ranged') as $type): ?>
		<?php

			$decreasesTypeAttackDamagePercentage = 'getDecreases'.$type.'AttackDamagePercentage';
			$decreasesTypeAttackDmpPercentage = 'getDecreases'.$type.'AttackDmpPercentage';

		?>
		<?php if ($skill->$decreasesTypeAttackDamagePercentage()): ?>
			<?php $cc++; ?>
			<div class="modification"><?php echo image_tag('/images/attack_'.strtolower($type).'.png'); ?> -<?php echo $skill->$decreasesTypeAttackDamagePercentage(); ?>%</div>
		<?php endif; ?>
		<?php if ($skill->$decreasesTypeAttackDmpPercentage()): ?>
			<?php $cc++; ?>
			<div class="modification"><?php echo image_tag('/images/dmp_small.png').image_tag('/images/attack_'.strtolower($type).'.png'); ?> -<?php echo $skill->$decreasesTypeAttackDmpPercentage(); ?>%</div>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php if (!$cc): ?>
		<span class="faded">None</span>
	<?php endif; ?>
</div>
<?php foreach ($skill->getSubSkills() as $subskill): ?>
	<?php include_component('main/skill', array('skill' => $subskill)); ?>
<?php endforeach; ?>
