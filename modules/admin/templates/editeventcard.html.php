<?php

	use application\entities\EventCard;

	$csp_response->setTitle($card->getB2DBID() ? __('Edit event card') : __('Create new event card'));

?>
<h2 style="margin: 10px 0 0 10px;">
	<?php echo link_tag(make_url('edit_cards', array('card_type' => 'event')), "Edit event cards"); ?>&nbsp;&rArr;
	<?php echo $card->getB2DBID() ? $card->getName() : __('New event card'); ?>
</h2>
<?php if (isset($error) && $error): ?>
	<h6 class="error"><?php echo $error; ?></h6>
<?php endif; ?>
<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<?php include_template('admin/commoncardform', compact('card')); ?>
	<fieldset>
		<legend>Event details</legend>
		<div>
			<label for="card_event_type">Event type</label>
			<select name="event_type" id="card_event_type" onchange="$('event_sub_details').select('fieldset').each(function(element) { $(element).hide(); }); $('properties_'+$(this).getValue()).show();">
				<?php foreach (EventCard::getEventTypes() as $type => $description): ?>
					<option value="<?php echo $type; ?>"<?php if ($card->getEventType() == $type) echo ' selected'; ?>><?php echo $description; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div>
			<label for="card_turn_duration">Duration</label>
			<input type="text" name="turn_duration" class="points" id="card_turn_duration" value="<?php echo $card->getTurnDuration(); ?>"> turns <span class="faded_out">(0 for persistent, or until removed)</span>
		</div>
		<div>
			<label for="card_level_affection">Affects levels</label>
			<?php foreach (array('low', 'regular', 'power') as $level): ?>
				<?php $method = 'affects'.ucfirst($level).'LvlCards'; ?>
				<input type="checkbox" name="level_affection[<?php echo $level; ?>]" id="card_level_<?php echo $level; ?>_affection" value="1"<?php if ($card->$method()) echo ' checked'; ?>>
				<label for="card_level_<?php echo $level; ?>_affection" style="float: none; display: inline; font-weight: normal; width: auto;"><?php echo ucfirst($level); ?> Lvl cards&nbsp;&nbsp;</label>
			<?php endforeach; ?>
		</div>
		<div>
			<label for="card_level_affection">Affects card types</label>
			<?php foreach (array('civilian', 'magic', 'military', 'physical', 'ranged') as $class): ?>
				<?php $method = 'affects'.ucfirst($class).'Cards'; ?>
				<input type="checkbox" name="card_type_affection[<?php echo $class; ?>]" id="card_type_<?php echo $class; ?>_affection" value="1"<?php if ($card->$method()) echo ' checked'; ?>>
				<label for="card_type_<?php echo $class; ?>_affection" style="float: none; display: inline; font-weight: normal; width: auto;"><?php echo ucfirst($class); ?> cards&nbsp;&nbsp;</label>
			<?php endforeach; ?>
		</div>
	</fieldset>
	<br style="clear: both;">
	<div id="event_sub_details">
		<fieldset id="properties_<?php echo EventCard::TYPE_DAMAGE; ?>"<?php if ($card->getEventType() != EventCard::TYPE_DAMAGE): ?> style="display: none;"<?php endif; ?>>
			<legend>Damage details</legend>
			<div>
				<label for="card_hp_damage_chance_percent">HP damage</label>
				<input type="text" name="hp_damage_chance_percent" class="points" id="card_hp_damage_chance_percent" value="<?php echo $card->getHpDamageChancePercent(); ?>">% chance of causing
				<input type="text" name="hp_damage_percent_min" class="points" id="card_hp_damage_percent_min" value="<?php echo $card->getHpDamagePercentMin(); ?>">&nbsp;&ndash;
				<input type="text" name="hp_damage_percent_max" class="points" id="card_hp_damage_percent_max" value="<?php echo $card->getHpDamagePercentMax(); ?>">% damage per turn
			</div>
			<div>
				<label for="card_hp_damage_chance_percent">Stun card</label>
				<input type="text" name="stun_chance_percent" class="points" id="card_stun_chance_percent" value="<?php echo $card->getStunChancePercent(); ?>">% chance of stunning a card per turn
			</div>
		</fieldset>
		<fieldset id="properties_<?php echo EventCard::TYPE_ALTERATION; ?>"<?php if ($card->getEventType() != EventCard::TYPE_ALTERATION): ?> style="display: none;"<?php endif; ?>>
			<legend>Alteration details</legend>
			<?php include_template('admin/modifiercardform', compact('card')); ?>
		</fieldset>
	</div>
	<br style="clear: both;">
	<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: rgba(80, 54, 32, 0.4); border: 1px dotted rgba(72, 48, 28, 0.8); border-left: none; border-right: none;">
		<input type="submit" value="Save card" style="font-size: 1em; padding: 3px 10px !important;">
	</div>
</form>