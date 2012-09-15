<h1 style="margin: 10px auto; width: 300px;">Choose your race</h1>
<div class="character_setup">
	<form action="<?php echo make_url('profile'); ?>" method="post">
		<?php foreach (range(1, 4) as $race): ?>
			<div class="menu-left race-picker" style="float: none; display: inline-block; width: 360px; margin: 30px 55px; text-align: center;" id="race_<?php echo $race; ?>_div">
				<img src="/images/swirl_top_right.png" class="swirl top-right">
				<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
				<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
				<img src="/images/swirl_top_left.png" class="swirl top-left">
				<h3 style="margin-bottom: 15px; display: inline-block;"><?php

					switch ($race) {
						case \application\entities\User::RACE_HUMAN:
							echo 'Humans';
							break;
						case \application\entities\User::RACE_LIZARD:
							echo 'Lacerta';
							break;
						case \application\entities\User::RACE_BEAST:
							echo 'Beast';
							break;
						case \application\entities\User::RACE_ELF:
							echo 'Elves';
							break;
					}

				?></h3>
				<br style="clear: both;">
				<img src="/images/race_<?php echo $race; ?>.png" style="margin-left: 5px; box-shadow: 0 0 8px rgba(255, 128, 0, 0.5), 0 0 18px rgba(255, 255, 0, 0.4); border-radius: 15px; border: 2px solid rgba(255, 128, 0, 0.6);">
				<br style="clear: both;">
				<p style="text-align: justify;">
					Vivamus sit amet nulla ac ante egestas pellentesque. Fusce metus justo, blandit sed vehicula quis, volutpat vel velit. Morbi quis sapien non orci volutpat sollicitudin. Nulla facilisi. Cras rutrum, nibh sit amet convallis rhoncus, dolor nisi fermentum metus, eget varius lorem purus in justo. 
				</p>
				<p style="text-align: justify;">
					Donec est nibh, ultrices eget aliquet quis, condimentum in augue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus pharetra lectus ac urna ornare elementum. Mauris aliquam magna et eros vestibulum dapibus. Donec aliquam orci ac tellus consequat vel mattis mi fringilla. Sed pretium ornare commodo.
				</p>
				<div style="text-align: center; margin: 15px 0;">
					<a href="javascript:void(0);" class="button button-standard" onclick="Devo.Main.Profile.pickRace(<?php echo $race; ?>);" style="font-size: 1.1em; font-weight: normal; padding: 10px 15px !important;">Pick this race</a>
				</div>
			</div>
		<?php endforeach; ?>
		<input type="hidden" name="character_setup" value="1">
		<input type="hidden" name="step" value="1">
		<input type="hidden" name="race" value="" id="race_input">
		<div class="menu-left" style="float: none; width: 840px; margin: 30px 0 0 55px; text-align: center;">
			<img src="/images/swirl_top_right.png" class="swirl top-right">
			<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
			<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
			<img src="/images/swirl_top_left.png" class="swirl top-left">
			<?php if (isset($charactername_error) && $charactername_error): ?>
				<div style="color: red; font-size: 15px; font-weight: bold; padding: 5px 0;">You must choose a character name!</div>
			<?php endif; ?>
			<?php if (isset($race_error) && $race_error): ?>
				<div style="color: red; font-size: 15px; font-weight: bold; padding: 5px 0;">You must choose a race!</div>
			<?php endif; ?>
			<h6>Character name</h6>
			<label for="character_name_input" style="float: none; display: inline-block;">Enter the name of your character here: </label>
			<input type="text" name="character_name" id="character_name_input" value="<?php echo $csp_user->getCharacterName(); ?>">
		</div>
		<div style="text-align: center; margin-top: 30px;">
			<input type="submit" value="Continue &raquo;" id="character_continue_button" style="font-size: 1.4em; font-weight: normal; padding: 10px 20px !important;" disabled>
		</div>
	</form>
</div>