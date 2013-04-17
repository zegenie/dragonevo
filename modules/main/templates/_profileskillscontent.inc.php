<?php $csp_response->setTitle('Character skills'); ?>
<?php include_template('main/profileleftmenu'); ?>
<div class="content profile left" id="profile-skills-container">
	<?php include_template('main/profiledetailstop'); ?>
	<div id="profile-skills-train-button-container">
		<img src="/images/spinning_20.gif" id="training_indicator" style="margin: 5px 5px -5px 0; display: none;">
		<a class="button button-standard disabled" id="levelup_button" href="javascript:void(0);" onclick="Devo.Main.Profile.trainSelectedSkill();" style="">Train selected skill</a>
		<input type="hidden" id="selected_skill" name="selected_skill" value="">
	</div>
	<h2>
		<?php echo $csp_user->getRaceName(); ?> skills<br>
		<span style="display: none; font-weight: normal; font-size: 0.7em;"><?php echo link_tag(make_url('profile'), '&laquo; Back to profile'); ?></span>
	</h2>
	<p id="user_level">
		Your character is currently level <span id="user-level" data-level="<?php echo $csp_user->getLevel(); ?>"><strong class="level" id="user-level-amount"><?php echo $csp_user->getLevel(); ?></strong></span>
	</p>
	<div id="skill_list">
		<?php foreach ($available_skills as $skill): ?>
			<div class="skills">
				<?php include_component('main/skill', array('skill' => $skill, 'first' => true)); ?>
			</div>
			<br style="clear: both;">
		<?php endforeach; ?>
	</div>
</div>
