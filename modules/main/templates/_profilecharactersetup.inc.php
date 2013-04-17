<?php

	use application\entities\User;

?>
<div class="fullpage_backdrop dark" id="profile-character-setup" style="display: none;">
	<div class="swirl-dialog profile_setup">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<h1>Greetings, brave traveler!</h1>
		<p>
			Our great world - once a peaceful land, now torn to pieces by war and bickering - is anxiously looking forward to your heroic presence.
		</p>
		<form action="<?php echo make_url('profile'); ?>" method="post" onsubmit="Devo.Main.Profile.completeCharacterSetup();return false;" id="character-setup-form">
			<input type="hidden" name="character_setup" value="1">
			<input type="hidden" name="step" value="1">
			<input type="hidden" name="race" value="" id="race_input">
			<input type="hidden" name="avatar" value="" id="avatar_input">
			<div id="character-avatar-container" class="character_setup">
				<label>It is too dark to see you. What do you look like?</label><br>
				<?php foreach (range(1, 13) as $avatar): ?>
					<div class="avatar_preview" onclick="Devo.Main.Profile.pickAvatar(<?php echo $avatar; ?>);" id="avatar_preview_<?php echo $avatar; ?>" style="background-image: url('/images/avatars/avatar_<?php echo $avatar; ?>.png');"></div>
				<?php endforeach; ?>
				<br>
				<div style="text-align: right; margin-top: 20px;">
					<button id="character_avatar_button" class="button button-standard" onclick="$('character-avatar-container').addClassName('completed');$('character-name-container').toggle();return false;" style="font-size: 1em; font-weight: normal; padding: 7px 15px !important;" disabled>This is how I look &raquo;</button>
				</div>
			</div>
			<div id="character-name-container" class="character_setup" style="display: none;">
				<label for="character_name_input">Please, tell us your fair name</label><br>
				<input type="text" name="character_name" id="character_name_input" value="<?php echo $csp_user->getCharacterName(); ?>" style="padding: 7px;">
				<button id="character_name_button" class="button button-standard" onclick="$('character_name_display').update($('character_name_input').getValue());$('character-name-container').toggle();$('character-name-header').toggle();$('race-card-picker').toggle();return false;" style="display: inline-block; font-size: 1em; font-weight: normal; padding: 7px 15px !important;">That is my name &raquo;</button>
			</div>
			<h6 id="character-name-header" style="display: none;">It's great to see you,<br><span id="character_name_display"></span></h6>
			<br style="clear: both;">
			<div class="character_setup cardpicker" id="race-card-picker" style="display: none;">
				<p style="padding-left: 2px;">
					The people of our land have heard many tales about you. I urge you, tell us your race.
				</p>
				<ul class="cards">
					<?php foreach (User::getRaces() as $race => $racename): ?>
						<?php include_template('main/racecard', compact('race', 'racename')); ?>
					<?php endforeach; ?>
				</ul>
				<br style="clear: both;">
				<div class="card_help">
					<span>Choose your race by picking one of the race cards</span><br>
					The race you pick will affect your abilities and the skills you can train
				</div>
				<input type="submit" value="Collect starter pack" id="character_continue_button" style="display: none;" disabled>
			</div>
		</form>
	</div>
</div>