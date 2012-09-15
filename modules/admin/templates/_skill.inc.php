<h6 style="margin: 0 0 5px 0; padding: 0;"><?php if ($skill->getParentSkill() instanceof application\entities\Skill) echo '&raquo;&nbsp;&nbsp;'; ?><a href="<?php echo make_url('edit_skill', array('skill_id' => $skill->getId())); ?>" class="button button-standard" style="font-size: 0.9em; margin-right: 5px;">Edit</a><?php echo $skill->getName(); ?></h6>
<?php if (count($subskills)): ?>
	<ul style="margin-left: 15px; list-style: none;">
		<?php foreach ($subskills as $subskill): ?>
			<?php include_component('admin/skill', array('skill' => $subskill, 'race' => $race)); ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
