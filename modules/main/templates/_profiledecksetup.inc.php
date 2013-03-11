<?php

	$faction_colors = array('resistance' => 'red', 'neutrals' => 'silver', 'rutai' => 'blue');
	$faction_names = array('resistance' => 'Hologev', 'neutrals' => 'Highwinds', 'rutai' => 'Rutai');

?>
<div class="fullpage_backdrop dark" id="profile-character-setup" style="display: none;">
	<div class="swirl-dialog profile_setup character_setup starter-pack">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<h1>Get your starting deck</h1>
		<p>
			Before you can start playing, you need cards! The <strong>starter pack</strong> gets you started with a base set of cards for the faction you choose.
			As you progress through the story or play matches against friends or other opponents, you will win cards and gold to buy new cards.<br>
		</p>
		<p>Free accounts are limited to only one character and faction.</p>
		<br>
		<?php foreach (array('resistance', 'neutrals', 'rutai') as $faction): ?>
			<div style="float: left; width: 310px; text-align: center; position: relative;">
				<form action="<?php echo make_url('profile'); ?>" method="post" onsubmit="Devo.Main.Profile.completeCharacterSetup(this);return false;" id="character-setup-form-<?php echo $faction; ?>">
					<input type="hidden" name="character_setup" value="1">
					<input type="hidden" name="step" value="2">
					<input type="hidden" name="faction" value="<?php echo $faction; ?>">
					<div class="card flipped">
					</div>
					<input type="submit" value="Pick <?php echo $faction_names[$faction]; ?> starter pack" class="pick_faction button button-<?php echo $faction_colors[$faction]; ?>">
					<br style="clear: both;">
				</form>
			</div>
		<?php endforeach; ?>
		<br style="clear: both;">
	</div>
</div>
