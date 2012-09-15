<?php

	use application\entities\Skill;

	$csp_response->setTitle($skill->getB2DBID() ? __('Edit %skill_name%', array('%skill_name%' => $skill->getName())) : __('Create new skill'));

?>
<h2 style="margin: 10px 0 0 10px;">
	<?php echo link_tag(make_url('admin_skills'), "Edit skills"); ?>&nbsp;&rArr;
	<?php if ($skill->getParentSkill() instanceof Skill): ?>
		<?php include_template('admin/parentskill', array('skill' => $skill->getParentSkill())); ?>
	<?php endif; ?>
	<?php echo $skill->getB2DBID() ? $skill->getName() : __('New skill'); ?>
</h2>
<?php if (isset($error) && $error): ?>
	<h6 class="error"><?php echo $error; ?></h6>
<?php endif; ?>
<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<fieldset>
		<legend>Basic details</legend>
		<div style="float: left; width: 680px; clear: none;">
			<div>
				<label for="skill_parent_skill_id">Parent skill</label>
				<select name="parent_skill_id" id="skill_parent_skill_id">
					<option value=""<?php if (!$skill->getParentSkillId()) echo ' selected'; ?>>No parent skill</option>
					<?php foreach (\application\entities\tables\Skills::getTable()->getAll() as $parent_skill): ?>
						<?php if ($parent_skill->getId() == $skill->getId()) continue; ?>
						<option value="<?php echo $parent_skill->getId(); ?>"<?php if ($skill->getParentSkillId() == $parent_skill->getId()) echo ' selected'; ?>><?php echo $parent_skill->getName(); ?> (<?php echo implode(', ', $parent_skill->getAppliesTo()); ?>)</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="skill_name">Skill name</label>
				<input type="text" name="name" id="skill_name" value="<?php echo $skill->getName(); ?>" placeholder="Enter the name of the skill here">
			</div>
			<div>
				<label for="skill_description">Brief description</label>
				<input type="text" name="description" class="long" id="skill_description" value="<?php echo $skill->getDescription(); ?>" placeholder="Enter a skill description here">
			</div>
			<div>
				<label for="skill_race_human">Available to humans</label>
				<input type="checkbox" name="race_human" id="skill_race_human" value="1" <?php if ($skill->getRaceHuman()) echo 'checked'; ?>>
			</div>
			<div>
				<label for="skill_race_lizard">Available to Lacerta</label>
				<input type="checkbox" name="race_lizard" id="skill_race_lizard" value="1" <?php if ($skill->getRaceLizard()) echo 'checked'; ?>>
			</div>
			<div>
				<label for="skill_race_beast">Available to beasts</label>
				<input type="checkbox" name="race_beast" id="skill_race_beast" value="1" <?php if ($skill->getRaceBeast()) echo 'checked'; ?>>
			</div>
			<div>
				<label for="skill_race_elf">Available to elves</label>
				<input type="checkbox" name="race_elf" id="skill_race_elf" value="1" <?php if ($skill->getRaceElf()) echo 'checked'; ?>>
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Skill bonuses</legend>
		<?php foreach (array(array('basic', 'air', 'dark', 'earth', 'fire'), array('freeze', 'melee', 'poison', 'ranged')) as $elements): ?>
			<div style="width: 480px; float: left; clear: none;">
				<?php foreach ($elements as $element): ?>
					<?php $getDecreasesElementHitPercentage = 'getDecreases'.ucfirst($element).'AttackHitPercentage'; ?>
					<?php $getDecreasesElementDamagePercentage = 'getDecreases'.ucfirst($element).'AttackDamagePercentage'; ?>
					<?php $getDecreasesElementDmpPercentage = 'getDecreases'.ucfirst($element).'AttackDmpPercentage'; ?>
					<?php $getElementHitPercentageModifier = 'get'.ucfirst($element).'AttackHitPercentageModifier'; ?>
					<?php $getElementDamagePercentageModifier = 'get'.ucfirst($element).'AttackDamagePercentageModifier'; ?>
					<?php $getElementDmpPercentageModifier = 'get'.ucfirst($element).'AttackDmpPercentageModifier'; ?>
					<div style="padding-bottom: 5px; border-bottom: 1px dotted rgba(72, 48, 28, 0.8); margin-bottom: 5px;">
						<label for="modifies_<?php echo $element; ?>_attacks_hit_percentage" style="padding: 30px 0;"><?php echo ucfirst($element); ?> attacks</label>
						<select name="modifies_<?php echo $element; ?>_attacks_hit_percentage" style="width: 220px;">
							<option value="increase"<?php if (!$skill->$getDecreasesElementHitPercentage()) echo ' selected'; ?>>Increases chance of hitting by</option>
							<option value="decrease"<?php if ($skill->$getDecreasesElementHitPercentage()) echo ' selected'; ?>>Decreases chance of hitting by</option>
						</select>
						<input type="text" name="hit_percentage_<?php echo $element; ?>_modifier" value="<?php echo $skill->$getElementHitPercentageModifier(); ?>" class="points">%<br>
						<select name="modifies_<?php echo $element; ?>_attacks_damage_percentage" style="width: 220px;">
							<option value="increase"<?php if (!$skill->$getDecreasesElementDamagePercentage()) echo ' selected'; ?>>Increases damage dealt by</option>
							<option value="decrease"<?php if ($skill->$getDecreasesElementDamagePercentage()) echo ' selected'; ?>>Decreases damage dealt by</option>
						</select>
						<input type="text" name="damage_percentage_<?php echo $element; ?>_modifier" value="<?php echo $skill->$getElementDamagePercentageModifier(); ?>" class="points">%<br>
						<select name="modifies_<?php echo $element; ?>_attacks_dmp_percentage" style="width: 220px;">
							<option value="increase"<?php if (!$skill->$getDecreasesElementDmpPercentage()) echo ' selected'; ?>>Increases DMP against by</option>
							<option value="decrease"<?php if ($skill->$getDecreasesElementDmpPercentage()) echo ' selected'; ?>>Decreases DMP against by</option>
						</select>
						<input type="text" name="dmp_percentage_<?php echo $element; ?>_modifier" value="<?php echo $skill->$getElementDmpPercentageModifier(); ?>" class="points">%
					</div>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
	</fieldset>
	<br style="clear: both;">
	<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: rgba(80, 54, 32, 0.4); border: 1px dotted rgba(72, 48, 28, 0.8); border-left: none; border-right: none;">
		<input type="submit" value="Save skill" style="font-size: 1em; padding: 3px 10px !important;">
	</div>
	<br style="clear: both;">
	<fieldset>
		<legend>Sub skills</legend>
		<?php if (!$skill->getB2DBID()): ?>
			<div class="faded_out" style="padding: 10px;">You need to save this skill before you can add sub skills</div>
		<?php else: ?>
			<ul class="skill_subskills" id="admin_skill_subskills">
				<?php if (count($subskills)): ?>
					<?php foreach ($subskills as $subskill): ?>
						<h6 style="margin: 0 0 5px 0; padding: 0;"><a href="<?php echo make_url('edit_skill', array('skill_id' => $subskill->getId())); ?>" class="button button-standard" style="font-size: 0.9em; margin-right: 5px;">Edit</a><?php echo $subskill->getName(); ?> <span style="font-weight: normal;">(<?php echo implode(', ', $parent_skill->getAppliesTo()); ?>)</span></h6>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
			<div class="faded_out" style="<?php if (count($subskills)): ?>display: none; <?php endif; ?> padding: 15px 0;" id="skill_no_subskills">This skill doesn't have any sub skills (yet)</div>
		<?php endif; ?>
		<a href="<?php echo make_url('new_skill', array('parent_skill_id' => $skill->getId())); ?>" class="button button-standard" style="margin-left: 10px;">Create new sub skill</a>
	</fieldset>
</form>