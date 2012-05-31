<h3>Set up your character</h3>
<div class="character_setup">
	<form action="<?php echo make_url('profile'); ?>" method="post">
		<input type="hidden" name="character_setup" value="1">
		<input type="hidden" name="step" value="1">
		Before you continue, you must set up your game character!<br>
		<br>
		<?php if (isset($charactername_error) && $charactername_error): ?>
			<div style="color: red; font-size: 15px; font-weight: bold; padding: 5px 0;">You must choose a character name!</div>
		<?php endif; ?>
		<label for="character_name_input">Please enter your character's name</label>
		<input type="text" name="character_name" id="character_name_input" value="<?php echo $csp_user->getCharacterName(); ?>">
		<input type="submit" value="Continue &raquo;">
	</form>
</div>