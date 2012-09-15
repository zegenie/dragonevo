<?php if ($skill->getParentSkill() instanceof application\entities\Skill): ?>
	<?php include_template('admin/parentskill', array('skill' => $skill->getParentSkill())); ?>
<?php endif; ?>
<a href="<?php echo make_url('edit_skill', array('skill_id' => $skill->getId())); ?>"><?php echo $skill->getName(); ?></a>&nbsp;&rArr;