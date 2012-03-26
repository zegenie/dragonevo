<?php

	use application\entities\EventCard;

	$csp_response->setTitle($card->getB2DBID() ? __('Edit event card') : __('Create new event card'));

?>
<h2 style="margin: 10px 0 0 10px;"><?php echo $card->getB2DBID() ? __('Edit event card') : __('Create new event card'); ?></h2>
<?php if (isset($error) && $error): ?>
	<h6><?php echo $error; ?></h6>
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
			<input type="text" name="turn_duration" class="points" id="card_turn_duration" value="<?php echo $card->getTurnDuration(); ?>"> turns <span class="faded_out">(0 for persistent)</span>
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
		</fieldset>
		<fieldset id="properties_<?php echo EventCard::TYPE_ALTERATION; ?>"<?php if ($card->getEventType() != EventCard::TYPE_ALTERATION): ?> style="display: none;"<?php endif; ?>>
			<legend>Alteration details</legend>
			<?php foreach (array(array('basic', 'air', 'fire', 'freeze'), array('melee', 'poison', 'ranged')) as $elements): ?>
				<div style="width: 480px; float: left; clear: none;">
					<?php foreach ($elements as $element): ?>
						<?php $getDecreasesElement = 'getDecreases'.ucfirst($element).'AttackPercentage'; ?>
						<?php $getElementModifier = 'get'.ucfirst($element).'AttackModifier'; ?>
						<div>
							<label for="modifies_<?php echo $element; ?>_attacks"><?php echo ucfirst($element); ?> attacks</label>
							<select name="modifies_<?php echo $element; ?>_attacks">
								<option value="increase"<?php if (!$card->$getDecreasesElement()) echo ' selected'; ?>>Increased by</option>
								<option value="decrease"<?php if ($card->$getDecreasesElement()) echo ' selected'; ?>>Decreased by</option>
							</select>
							<input type="text" name="<?php echo $element; ?>_modifier" value="<?php echo $card->$getElementModifier(); ?>" class="points"> pct.
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
			<br style="clear: both;">
		</fieldset>
	</div>
	<br style="clear: both;">
	<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: #F1F1F1; border: 1px dotted #CCC; border-left: none; border-right: none;">
		<input type="submit" value="Save card" style="font-size: 1em; padding: 3px 10px !important;">
	</div>
</form>