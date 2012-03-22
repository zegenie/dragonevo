<?php $csp_response->setTitle($card->getB2DBID() ? __('Edit event card') : __('Create new event card')); ?>
<form method="post" accept-charset="utf-8">
	<fieldset>
		<legend>Basic details</legend>
		<div>
			<label for="card_name">Card name</label>
			<input type="text" name="name" id="card_name" value="<?php echo $card->getName(); ?>">
		</div>
		<div>
			<label for="base_health">Base HP</label>
			<input type="text" name="base_health" id="base_health" class="points" value="<?php echo $card->getBaseHP(); ?>">
		</div>
		<div>
			<label for="base_health">Base DMP (defence multiplier - chance of averting a basic attack)</label>
			<input type="text" name="base_health" id="base_health" class="points" value="<?php echo $card->getBaseHP(); ?>">
		</div>
		<div>
			<label for="is_special_card">Special card</label>
			<select name="special_card" id="is_special_card">
				<option value="1"<?php if ($card->isSpecialCard()) echo ' selected'; ?>>Yes</option>
				<option value="0"<?php if (!$card->isSpecialCard()) echo ' selected'; ?>>No</option>
			</select>
		</div>
	</fieldset>
	<fieldset>
		<legend>Modifiers</legend>
		<div>
			<label for="gpt_player">GPT (gold per turn) modifier player</label>
			<select name="gpt_player">
				<option value="increase"<?php if (!$card->getGPTDecreasePlayer()) echo ' selected'; ?>>Increase by</option>
				<option value="decrease"<?php if ($card->getGPTDecreasePlayer()) echo ' selected'; ?>>Decrease by</option>
			</select>
			<input type="text" name="gpt_player_modifier" value="<?php echo $card->getGPTPlayerModifier(); ?>" class="points"> GPT
		</div>
		<div>
			<label for="gpt_opponent">GPT (gold per turn) modifier opponent</label>
			<select name="gpt_opponent">
				<option value="increase"<?php if (!$card->getGPTDecreaseOpponent()) echo ' selected'; ?>>Increase by</option>
				<option value="decrease"<?php if ($card->getGPTDecreaseOpponent()) echo ' selected'; ?>>Decrease by</option>
			</select>
			<input type="text" name="gpt_opponent_modifier" value="<?php echo $card->getGPTOpponentModifier(); ?>" class="points"> GPT
		</div>
		<div>
			<label for="gpt_player">MPT (magic per turn) modifier player</label>
			<select name="gpt_player">
				<option value="increase"<?php if (!$card->getMPTDecreasePlayer()) echo ' selected'; ?>>Increase by</option>
				<option value="decrease"<?php if ($card->getMPTDecreasePlayer()) echo ' selected'; ?>>Decrease by</option>
			</select>
			<input type="text" name="gpt_player_modifier" value="<?php echo $card->getMPTPlayerModifier(); ?>" class="points"> MPT
		</div>
		<div>
			<label for="gpt_opponent">MPT (magic per turn) modifier opponent</label>
			<select name="gpt_opponent">
				<option value="increase"<?php if (!$card->getMPTDecreaseOpponent()) echo ' selected'; ?>>Increase by</option>
				<option value="decrease"<?php if ($card->getMPTDecreaseOpponent()) echo ' selected'; ?>>Decrease by</option>
			</select>
			<input type="text" name="gpt_opponent_modifier" value="<?php echo $card->getMPTOpponentModifier(); ?>" class="points"> MPT
		</div>
	</fieldset>
</form>