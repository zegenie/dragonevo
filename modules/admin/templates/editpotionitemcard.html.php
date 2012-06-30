<?php

	use application\entities\PotionItemCard,
		application\entities\ItemCard;

	$csp_response->setTitle($card->getB2DBID() ? __('Edit potion card') : __('Create new potion card'));

?>
<h2 style="margin: 10px 0 0 10px;">
	<?php echo link_tag(make_url('edit_cards', array('card_type' => 'potion_item')), "Edit potion cards"); ?>&nbsp;&rArr;
	<?php echo $card->getB2DBID() ? $card->getName() : __('New potion card'); ?>
</h2>
<?php if (isset($error) && $error): ?>
	<h6 class="error"><?php echo $error; ?></h6>
<?php endif; ?>
<form method="post" accept-charset="utf-8" enctype="multipart/form-data" id="potionitemcard_form">
	<?php include_template('admin/commoncardform', compact('card')); ?>
	<fieldset>
		<legend>Potion details</legend>
		<div>
			<label for="card_number_of_uses">Duration</label>
			Potion expires after <input type="text" name="number_of_uses" class="points" id="card_number_of_uses" value="<?php echo $card->getNumberOfUses(); ?>"> use(s)</span>
		</div>
		<div>
			<label for="is_one_time_potion">One time potion</label>
			<select name="is_one_time_potion" id="is_one_time_potion">
				<option value="1"<?php if ($card->isOneTimePotion()) echo ' selected'; ?>>Yes</option>
				<option value="0"<?php if (!$card->isOneTimePotion()) echo ' selected'; ?>>No</option>
			</select>
			&nbsp;<span class="faded_out">If used, a one time potion is destroyed after expiration or when the game ends</span>
			<input type="hidden" name="item_class" value="<?php echo ItemCard::CLASS_POTION_HEALTH; ?>">
		</div>
	</fieldset>
	<br style="clear: both;">
	<div id="potion_sub_details">
		<fieldset>
			<legend>Health restoration details</legend>
			<div>
				<label for="card_restores_health_percentage">Restore HP</label>
				Restores <input type="text" name="restores_health_percentage" class="points" id="card_restores_health_percentage" value="<?php echo $card->getRestoresHealthPercentage(); ?>">% of the character's max HP
			</div>
		</fieldset>
		<fieldset>
			<legend>Effect removal</legend>
			<?php foreach (array('air', 'dark', 'earth', 'freeze', 'fire', 'poison', 'stun') as $element): ?>
				<div>
					<?php $doesMethod = 'doesRemove'.ucfirst($element); ?>
					<label for="card_removes_<?php echo $element; ?>">Removes <?php echo $element; ?> effect</label>
					<input type="checkbox" name="removes_<?php echo $element; ?>" id="card_removes_<?php echo $element; ?>" <?php if ($card->$doesMethod()) echo ' checked'; ?>>
				</div>
			<?php endforeach; ?>
		</fieldset>
	</div>
	<br style="clear: both;">
	<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: rgba(80, 54, 32, 0.4); border: 1px dotted rgba(72, 48, 28, 0.8); border-left: none; border-right: none;">
		<input type="submit" value="Save card" style="font-size: 1em; padding: 3px 10px !important;">
	</div>
</form>