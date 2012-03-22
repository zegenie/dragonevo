<?php $csp_response->setTitle($card->getB2DBID() ? __('Edit event card') : __('Create new event card')); ?>
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
			<select name="event_type" id="card_event_type">
				<?php foreach (\application\entities\EventCard::getEventTypes() as $type => $description): ?>
					<option value="<?php echo $type; ?>"<?php if ($card->getEventType() == $type) echo ' selected'; ?>><?php echo $description; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div>
			<label for="card_turn_duration">Duration</label>
			<input type="text" name="turn_duration" class="points" id="card_turn_duration" value="<?php echo $card->getTurnDuration(); ?>"> turns <span class="faded_out">(0 for persistent)</span>
		</div>
	</fieldset>
	<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: #F1F1F1; border: 1px dotted #CCC; border-left: none; border-right: none;">
		<input type="submit" value="Save card" style="font-size: 1em; padding: 3px 10px !important;">
	</div>
</form>