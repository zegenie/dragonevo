<?php

	use application\entities\EquippableItemCard;

	$csp_response->setTitle($card->getB2DBID() ? __('Edit item card') : __('Create new item card'));

?>
<h2 style="margin: 10px 0 0 10px;">
	<?php echo link_tag(make_url('edit_cards', array('card_type' => 'item')), "Edit item cards"); ?>&nbsp;&rArr;
	<?php echo $card->getB2DBID() ? $card->getName() : __('New item card'); ?>
</h2>
<?php if (isset($error) && $error): ?>
	<h6 class="error"><?php echo $error; ?></h6>
<?php endif; ?>
<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<?php include_template('admin/commoncardform', compact('card')); ?>
	<fieldset>
		<legend>Item details</legend>
		<div>
			<label for="card_item_class">Item class</label>
			<select name="item_class" id="card_item_class">
				<?php foreach (EquippableItemCard::getEquippableItemClasses() as $class => $description): ?>
					<option value="<?php echo $class; ?>"<?php if ($card->getItemClass() == $class) echo ' selected'; ?>><?php echo $description; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div>
			<label for="card_level_affection" style="padding: 17px 0;">Equippable by</label>
			<?php foreach (array('low', 'regular', 'power') as $level): ?>
				<?php $method = 'isEquippableBy'.ucfirst($level).'LvlCards'; ?>
				<input type="checkbox" name="level_equippable[<?php echo $level; ?>]" id="card_level_<?php echo $level; ?>_equippable" value="1"<?php if ($card->$method()) echo ' checked'; ?>>
				<label for="card_level_<?php echo $level; ?>_equippable" style="float: none; display: inline; font-weight: normal; width: auto;"><?php echo ucfirst($level); ?> Lvl cards&nbsp;&nbsp;</label>
			<?php endforeach; ?><br>
			<?php foreach (array('civilian', 'magic', 'military', 'physical', 'ranged') as $class): ?>
				<?php $method = 'isEquippableBy'.ucfirst($class).'Cards'; ?>
				<input type="checkbox" name="card_type_equippable[<?php echo $class; ?>]" id="card_type_<?php echo $class; ?>_equippable" value="1"<?php if ($card->$method()) echo ' checked'; ?>>
				<label for="card_type_<?php echo $class; ?>_equippable" style="float: none; display: inline; font-weight: normal; width: auto;"><?php echo ucfirst($class); ?> cards&nbsp;&nbsp;</label>
			<?php endforeach; ?>
		</div>
	</fieldset>
	<br style="clear: both;">
	<fieldset>
		<legend>Alteration details</legend>
		<?php include_template('admin/modifiercardform', compact('card')); ?>
	</fieldset>
	<br style="clear: both;">
	<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: rgba(80, 54, 32, 0.4); border: 1px dotted rgba(72, 48, 28, 0.8); border-left: none; border-right: none;">
		<input type="submit" value="Save card" style="font-size: 1em; padding: 3px 10px !important;">
	</div>
</form>