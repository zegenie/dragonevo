<?php

	use application\entities\CreatureCard,
		application\entities\Card;

	$csp_response->setTitle($card->getB2DBID() ? __('Edit %card_name%', array('%card_name%' => $card->getName())) : __('Create new creature card'));

?>
<h2 style="margin: 10px 0 0 10px;">
	<?php echo link_tag(make_url('edit_cards', array('card_type' => 'creature')), "Edit creature cards"); ?>&nbsp;&rArr;
	<?php echo $card->getB2DBID() ? $card->getName() : __('New creature card'); ?>
</h2>
<?php if (isset($error) && $error): ?>
	<h6 class="error"><?php echo $error; ?></h6>
<?php endif; ?>
<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<?php include_template('admin/commoncardform', compact('card')); ?>
	<fieldset>
		<legend>Creature details</legend>
		<div>
			<label for="card_faction">Faction</label>
			<select name="faction" id="card_faction">
				<?php foreach (Card::getFactions() as $faction => $description): ?>
					<option value="<?php echo $faction; ?>"<?php if ($card->getFaction() == $faction) echo ' selected'; ?>><?php echo $description; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div>
			<label for="card_creature_class">Creature class</label>
			<select name="creature_class" id="card_creature_class">
				<?php foreach (CreatureCard::getCreatureClasses() as $class => $description): ?>
					<option value="<?php echo $class; ?>"<?php if ($card->getCreatureClass() == $class) echo ' selected'; ?>><?php echo $description; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div>
			<label for="card_level">Card level</label>
			<select name="level" id="card_level">
				<?php foreach (array('low', 'regular', 'power') as $level): ?>
					<option value="<?php echo $level; ?>"<?php if ($card->getCardLevel() == $level) echo ' selected'; ?>><?php echo ucfirst($level); ?></option>
				<?php endforeach; ?>
			</select>&nbsp;&nbsp;<span class="faded_out">(this is not the XP level)</span>
		</div>
		<div style="width: 480px; float: left; clear: none;">
			<div>
				<label for="card_base_health">Base HP</label>
				<input type="text" name="base_health" class="points" id="card_base_health" value="<?php echo $card->getBaseHealth(); ?>"> HP
			</div>
			<div>
				<label for="card_base_health_randomness">HP randomness</label>
				<input type="text" name="base_health_randomness" class="points" id="card_base_health_randomness" value="<?php echo $card->getBaseHealthRandomness(); ?>">%
			</div>
			<div>
				<label for="card_base_dmp">Max DMP</label>
				<input type="text" name="base_dmp" class="points" id="card_base_dmp" value="<?php echo $card->getBaseDMP(); ?>">x&nbsp;&nbsp;
			</div>
			<div>
				<label for="card_base_dmp_randomness">DMP randomness</label>
				<input type="text" name="base_dmp_randomness" class="points" id="card_base_dmp_randomness" value="<?php echo $card->getBaseDMPRandomness(); ?>">%
			</div>
		</div>
		<div style="width: 480px; float: left; clear: none;">
			<div>
				<label for="card_base_ep">Base EP</label>
				<input type="text" name="base_ep" class="points" id="card_base_ep" value="<?php echo $card->getBaseEP(); ?>"> EP
			</div>
			<div>
				<label for="card_base_ep_randomness">EP randomness</label>
				<input type="text" name="base_ep_randomness" class="points" id="card_base_ep_randomness" value="<?php echo $card->getBaseEPRandomness(); ?>">%
			</div>
			<div style="margin-top: 10px;">
				<span class="faded_out"><strong>Base values</strong> will be multiplied based on card's level</span><br>
				<span class="faded_out"><strong>Randomness %</strong> determines the variation for cards that are picked / bought / generated</span>
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Available item card slots</legend>
		<?php foreach (range(1,2) as $cc): ?>
			<?php $isCardSlotAvailable = "isSlot{$cc}Available"; ?>
			<div>
				<label for="card_slot_<?php echo $cc; ?>_available">Slot <?php echo $cc; ?></label>
				<select name="slot_<?php echo $cc; ?>_available" id="card_slot_<?php echo $cc; ?>_available">
					<option value="1"<?php if ($card->$isCardSlotAvailable()) echo ' selected'; ?>>Yes</option>
					<option value="0"<?php if (!$card->$isCardSlotAvailable()) echo ' selected'; ?>>No</option>
				</select>
			</div>
		<?php endforeach; ?>
	</fieldset>
	<br style="clear: both;">
	<fieldset>
		<legend>Attacks</legend>
		<?php if (!$card->getB2DBID()): ?>
			<div class="faded_out" style="padding: 10px;">You need to save this card before you can add attacks</div>
		<?php else: ?>
		<?php endif; ?>
	</fieldset>
	<br style="clear: both;">
	<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: rgba(80, 54, 32, 0.4); border: 1px dotted rgba(72, 48, 28, 0.8); border-left: none; border-right: none;">
		<input type="submit" value="Save card" style="font-size: 1em; padding: 3px 10px !important;">
	</div>
</form>