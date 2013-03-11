<?php $csp_response->setTitle('Edit user skills'); ?>
<div class="content left">
	<?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right cotw-admin">
	<h1>
		Edit user skills
	</h1>
	<?php foreach (range(1, 4) as $race): ?>
		<div class="feature">
			<h4 style="margin-top: 15px;"><?php
			
				switch ($race) {
					case \application\entities\User::RACE_HUMAN:
						echo 'Humans';
						$skills = $skills_human;
						break;
					case \application\entities\User::RACE_LIZARD:
						echo 'Lacerta';
						$skills = $skills_lizard;
						break;
					case \application\entities\User::RACE_BEAST:
						echo 'Faewryn';
						$skills = $skills_beast;
						break;
					case \application\entities\User::RACE_ELF:
						echo 'Skurn';
						$skills = $skills_elf;
						break;
				}

			?>
				<a href="<?php echo make_url('new_skill', compact('race')); ?>" class="button button-standard" style="margin-left: 10px;">Create new skill</a>
			</h4>
			<?php if (count($skills)): ?>
				<?php foreach ($skills as $skill_id => $skill): ?>
					<?php include_component('admin/skill', array('skill' => $skill, 'race' => $race)); ?>
				<?php endforeach; ?>
			<?php else: ?>
				<span class="faded_out" style="display: inline-block; padding: 5px 0;">This race doesn't have any skills (yet)</span>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>