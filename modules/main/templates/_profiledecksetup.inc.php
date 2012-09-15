<?php

	$faction_colors = array('resistance' => 'red', 'neutrals' => 'silver', 'rutai' => 'blue');
	$faction_names = array('resistance' => 'Hologev', 'neutrals' => 'Highwinds', 'rutai' => 'Rutai');

?>
<div class="character_setup">
	<h3>Get your starting deck</h3>
	<p>
		Before you can start playing, you need cards! The <strong>starter pack</strong> gets you started with a base set of cards for the faction you choose.<br>
		As you progress through the story or play matches against friends or other opponents, you will win cards and gold to buy new cards.<br>
	</p>
	<p>Free accounts are limited to only one character and faction.</p>
	<br>
	<?php foreach (array('resistance', 'neutrals', 'rutai') as $faction): ?>
		<div style="float: left; width: 310px; text-align: center; position: relative;">
			<form action="" method="post">
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