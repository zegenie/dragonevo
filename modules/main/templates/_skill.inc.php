<div id="skill_<?php echo $skill->getId(); ?>" class="skill<?php if ($trained) echo ' trained'; ?><?php if (isset($first)) echo ' first'; ?>" <?php if (!$trained): ?> onclick="Devo.Main.Profile.toggleSkillTraining(<?php echo $skill->getId(); ?>);" style="cursor: pointer;"<?php endif; ?>>
	<h1>
		<?php echo $skill->getName(); ?><br>
		<span class="training">(training)</span><span class="trained">(trained)</span>
	</h1>
	<p><?php echo $skill->getDescription(); ?></p>
</div>
<?php foreach ($skill->getSubSkills() as $subskill): ?>
	<?php include_component('main/skill', array('skill' => $subskill)); ?>
<?php endforeach; ?>
