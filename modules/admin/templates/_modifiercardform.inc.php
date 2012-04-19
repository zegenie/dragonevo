<?php foreach (array(array('basic', 'air', 'dark', 'earth', 'fire'), array('freeze', 'melee', 'poison', 'ranged')) as $elements): ?>
	<div style="width: 480px; float: left; clear: none;">
		<?php foreach ($elements as $element): ?>
			<?php $getDecreasesElementHitPercentage = 'getDecreases'.ucfirst($element).'AttackHitPercentage'; ?>
			<?php $getDecreasesElementDamagePercentage = 'getDecreases'.ucfirst($element).'AttackDamagePercentage'; ?>
			<?php $getDecreasesElementDmpPercentage = 'getDecreases'.ucfirst($element).'AttackDmpPercentage'; ?>
			<?php $getElementHitPercentageModifier = 'get'.ucfirst($element).'AttackHitPercentageModifier'; ?>
			<?php $getElementDamagePercentageModifier = 'get'.ucfirst($element).'AttackDamagePercentageModifier'; ?>
			<?php $getElementDmpPercentageModifier = 'get'.ucfirst($element).'AttackDmpPercentageModifier'; ?>
			<div style="padding-bottom: 5px; border-bottom: 1px dotted #CCC; margin-bottom: 5px;">
				<label for="modifies_<?php echo $element; ?>_attacks_hit_percentage" style="padding: 30px 0;"><?php echo ucfirst($element); ?> attacks</label>
				<select name="modifies_<?php echo $element; ?>_attacks_hit_percentage" style="width: 220px;">
					<option value="increase"<?php if (!$card->$getDecreasesElementHitPercentage()) echo ' selected'; ?>>Increases chance of hitting by</option>
					<option value="decrease"<?php if ($card->$getDecreasesElementHitPercentage()) echo ' selected'; ?>>Decreases chance of hitting by</option>
				</select>
				<input type="text" name="hit_percentage_<?php echo $element; ?>_modifier" value="<?php echo $card->$getElementHitPercentageModifier(); ?>" class="points">%<br>
				<select name="modifies_<?php echo $element; ?>_attacks_damage_percentage" style="width: 220px;">
					<option value="increase"<?php if (!$card->$getDecreasesElementDamagePercentage()) echo ' selected'; ?>>Increases damage dealt by</option>
					<option value="decrease"<?php if ($card->$getDecreasesElementDamagePercentage()) echo ' selected'; ?>>Decreases damage dealt by</option>
				</select>
				<input type="text" name="damage_percentage_<?php echo $element; ?>_modifier" value="<?php echo $card->$getElementDamagePercentageModifier(); ?>" class="points">%<br>
				<select name="modifies_<?php echo $element; ?>_attacks_dmp_percentage" style="width: 220px;">
					<option value="increase"<?php if (!$card->$getDecreasesElementDmpPercentage()) echo ' selected'; ?>>Increases DMP against by</option>
					<option value="decrease"<?php if ($card->$getDecreasesElementDmpPercentage()) echo ' selected'; ?>>Decreases DMP against by</option>
				</select>
				<input type="text" name="dmp_percentage_<?php echo $element; ?>_modifier" value="<?php echo $card->$getElementDmpPercentageModifier(); ?>" class="points">%
			</div>
		<?php endforeach; ?>
	</div>
<?php endforeach; ?>
<br style="clear: both;">