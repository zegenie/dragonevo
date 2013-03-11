<?php

	use application\entities\Tellable,
		application\entities\Adventure,
		application\entities\Story,
		application\entities\Chapter,
		application\entities\Part,
		application\entities\TellableCardReward;

	switch ($tellable->getTellableType()) {
		case Tellable::TYPE_STORY:
			$csp_response->setTitle($tellable->getB2DBID() ? __('Edit story') : __('Create new story'));
			break;
		case Tellable::TYPE_CHAPTER:
			$csp_response->setTitle($tellable->getB2DBID() ? __('Edit chapter') : __('Create new chapter'));
			break;
		case Tellable::TYPE_PART:
			$csp_response->setTitle($tellable->getB2DBID() ? __('Edit part') : __('Create new part'));
			break;
		case Tellable::TYPE_ADVENTURE:
			$csp_response->setTitle($tellable->getB2DBID() ? __('Edit adventure') : __('Create new adventure'));
			break;
	}

?>
<h2 style="margin: 10px 0 0 10px;">
	<?php if ($tellable->getTellableType() == Tellable::TYPE_STORY): ?>
		<?php echo link_tag(make_url('admin_tellables', array('tellable_type' => 'story')), "Edit stories"); ?>&nbsp;&rArr;
		<?php echo $tellable->getB2DBID() ? $tellable->getName() : __('New story'); ?>
	<?php elseif ($tellable->getTellableType() == Tellable::TYPE_CHAPTER): ?>
		<?php echo link_tag(make_url('admin_tellables', array('tellable_type' => 'story')), "Edit stories"); ?>&nbsp;&rArr;
		<?php echo link_tag(make_url('edit_tellable', array('tellable_type' => 'story', 'tellable_id' => $tellable->getStoryId())), $tellable->getStory()->getName()); ?>&nbsp;&rArr;
		<?php echo $tellable->getB2DBID() ? $tellable->getName() : __('New chapter'); ?>
	<?php elseif ($tellable->getTellableType() == Tellable::TYPE_PART): ?>
		<?php if ($tellable->hasChapter()): ?>
			<?php echo link_tag(make_url('admin_tellables', array('tellable_type' => 'story')), "Edit stories"); ?>&nbsp;&rArr;
			<?php echo link_tag(make_url('edit_tellable', array('tellable_type' => 'story', 'tellable_id' => $tellable->getChapter()->getStoryId())), $tellable->getChapter()->getStory()->getName()); ?>&nbsp;&rArr;
			<?php echo link_tag(make_url('edit_tellable', array('tellable_type' => 'chapter', 'tellable_id' => $tellable->getChapterId())), $tellable->getChapter()->getName()); ?>&nbsp;&rArr;
		<?php else: ?>
			<?php echo link_tag(make_url('admin_tellables', array('tellable_type' => 'adventure')), "Edit adventures"); ?>&nbsp;&rArr;
			<?php echo link_tag(make_url('edit_tellable', array('tellable_type' => 'adventure', 'tellable_id' => $tellable->getAdventureId())), $tellable->getAdventure()->getName()); ?>&nbsp;&rArr;
		<?php endif; ?>
		<?php echo $tellable->getB2DBID() ? $tellable->getName() : __('New part'); ?>
	<?php elseif ($tellable->getTellableType() == Tellable::TYPE_ADVENTURE): ?>
		<?php echo link_tag(make_url('admin_tellables', array('tellable_type' => 'adventure')), "Edit adventures"); ?>&nbsp;&rArr;
		<?php echo $tellable->getB2DBID() ? $tellable->getName() : __('New adventure'); ?>
	<?php endif; ?>
</h2>
<?php if (isset($error) && $error): ?>
	<h6 class="error"><?php echo $error; ?></h6>
<?php endif; ?>
<?php if ($tellable->getB2DBID()): ?>
	<div style="float: right; margin: 10px;">
		<form method="post" accept-charset="utf-8" enctype="multipart/form-data" action="<?php echo make_url('delete_tellable', array('tellable_id' => $tellable->getId(), 'tellable_type' => $tellable->getTellableType())); ?>">
			<a href="javascript:void(0);" class="button button-red" id="delete-tellable-confirm" onclick="$('delete-tellable').show();$(this).hide();" style="width: 80px;">Delete</a>
			<div id="delete-tellable" style="display: none;">
				<input type="submit" value="Yes" class="button button-red">
				<a href="javascript:void(0);" class="button button-silver" onclick="$('delete-tellable').hide();$('delete-tellable-confirm').show();" style="width: 80px;">No</a>
			</div>
		</form>
	</div>
<?php endif; ?>
<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<?php if ($tellable->getTellableType() == Tellable::TYPE_CHAPTER): ?>
		<input type="hidden" name="story_id" value="<?php echo $tellable->getStoryId(); ?>">
	<?php elseif ($tellable->getTellableType() == Tellable::TYPE_PART): ?>
		<input type="hidden" name="chapter_id" value="<?php echo $tellable->getChapterId(); ?>">
		<input type="hidden" name="adventure_id" value="<?php echo $tellable->getAdventureId(); ?>">
	<?php endif; ?>
	<fieldset>
		<legend>Basic details</legend>
		<div style="clear: both;">
			<?php if ($tellable->getTellableType() == Tellable::TYPE_PART): ?>
				<div>
					<label for="tellable_previous_part_id">Previous quest</label>
					<select name="previous_part_id" id="tellable_previous_part_id">
						<option value="0" <?php if ($tellable->getPreviousPartId() == 0) echo ' selected'; ?>>First quest</option>
						<?php if ($tellable->hasChapter()): ?>
							<?php foreach ($tellable->getParent()->getStory()->getChapters() as $chapter): ?>
								<optgroup label="<?php echo $chapter->getName(); ?>">
									<?php foreach ($chapter->getParts() as $p_id => $p): ?>
										<?php if ($p_id == $tellable->getId()) continue; ?>
										<option value="<?php echo $p_id; ?>" <?php if ($tellable->getPreviousPartId() == $p_id) echo ' selected'; ?>><?php echo $p->getName(); ?></option>
									<?php endforeach; ?>
								</optgroup>
							<?php endforeach; ?>
						<?php else: ?>
							<?php foreach ($tellable->getParent()->getParts() as $p_id => $p): ?>
								<?php if ($p_id == $tellable->getId()) continue; ?>
								<option value="<?php echo $p_id; ?>" <?php if ($tellable->getPreviousPartId() == $p_id) echo ' selected'; ?>><?php echo $p->getName(); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			<?php endif; ?>
			<div>
				<label for="tellable_name">Name</label>
				<input type="text" name="name" id="tellable_name" value="<?php echo $tellable->getName(); ?>" placeholder="Enter the name of the <?php echo $tellable->getTellableType(); ?> here">
			</div>
			<div>
				<label for="tellable_required_level">Required level</label>
				<input type="text" name="required_level" id="tellable_required_level" class="points" value="<?php echo $tellable->getRequiredLevel(); ?>">
			</div>
			<?php if ($tellable->getTellableType() != Tellable::TYPE_CHAPTER): ?>
				<div>
					<label for="tellable_coordinates">Coordinates</label>
					<input type="text" name="coordinates" id="tellable_coordinates" class="points" value="<?php echo join(',', array_values($tellable->getCoordinates())); ?>"> <a class="button button-standard" onclick="Devo.Main.Helpers.Backdrop.show('<?php echo make_url('get_backdrop_partial', array('key' => 'tellable_coordinates', 'tellable_type' => $tellable->getTellableType(), 'tellable_id' => (int) $tellable->getId(), 'parent_id' => $tellable->getParentId(), 'parent_type' => $tellable->getParentType())); ?>');return false;" style="margin-left: 5px;">Place on map</a>
				</div>
			<?php else: ?>
				<input type="hidden" name="coordinates" value="0,0">
			<?php endif; ?>
			<div>
				<label for="tellable_excerpt">Excerpt</label>
				<input type="text" name="excerpt" class="long" id="tellable_excerpt" value="<?php echo $tellable->getExcerpt(); ?>" placeholder="Enter a *short* summary here (will appear in the tooltip)">
			</div>
			<div>
				<label for="tellable_fullstory">Full story</label>
				<textarea name="fullstory" class="long" id="tellable_fullstory" placeholder="Enter the full story text here (will appear in the adventure book)"><?php echo $tellable->getFullstory(); ?></textarea>
			</div>
		</div>
	</fieldset>
	<br style="clear: both;">
	<fieldset>
		<legend>Available to faction(s)</legend>
		<div style="width: 280px; float: left; clear: none;">
			<div>
				<label for="tellable_applies_neutrals">Highwinds</label><input id="tellable_applies_neutrals" type="checkbox" name="applies_neutrals" <?php if ($tellable->getAppliesNeutrals()) echo ' checked'; ?>>
			</div>
		</div>
		<div style="width: 280px; float: left; clear: none;">
			<div>
				<label for="tellable_applies_resistance">Hologev</label><input id="tellable_applies_resistance" type="checkbox" name="applies_resistance" <?php if ($tellable->getAppliesResistance()) echo ' checked'; ?>>
			</div>
		</div>
		<div style="width: 280px; float: left; clear: none;">
			<div>
				<label for="tellable_applies_rutai">Rutai</label><input id="tellable_applies_rutai" type="checkbox" name="applies_rutai" <?php if ($tellable->getAppliesRutai()) echo ' checked'; ?>>
			</div>
		</div>
	</fieldset>
	<br style="clear: both;">
	<?php if ($tellable->getTellableType() == Tellable::TYPE_PART): ?>
		<fieldset>
			<legend>Restrictions</legend>
			<div style="width: 280px; float: left; clear: none;">
				<div>
					<label for="tellable_max_creature_cards">Max creature cards</label><input id="tellable_max_creature_cards" type="text" class="points" name="max_creature_cards" value="<?php echo $tellable->getMaxCreatureCards(); ?>">
				</div>
				<div style="margin-left: 140px;">
					<span class="faded_out">"0" means default rules<br>
				</div>
			</div>
			<div style="width: 280px; float: left; clear: none;">
				<div>
					<label for="tellable_max_item_cards">Max item cards</label><input id="tellable_max_item_cards" type="text" class="points" name="max_item_cards" value="<?php echo $tellable->getMaxItemCards(); ?>">
				</div>
				<div style="margin-left: 140px;">
					<span class="faded_out">"0" means default rules<br>
				</div>
			</div>
			<div style="width: 280px; float: left; clear: none;">
				<div>
					<label for="tellable_allow_potions">Allow potions</label>
					<select name="allow_potions" id="tellable_allow_potions">
						<option value="0" <?php if (!$tellable->getAllowPotions()) echo ' selected'; ?>>No</option>
						<option value="1" <?php if ($tellable->getAllowPotions()) echo ' selected'; ?>>Yes</option>
					</select>
				</div>
			</div>
		</fieldset>
		<br style="clear: both;">
		<fieldset>
			<legend>AI cards <?php if ($tellable->getB2DBID()): ?><a class="button button-standard" onclick="Devo.Main.Helpers.Backdrop.show('<?php echo make_url('get_backdrop_partial', array('key' => 'tellable_card_opponent', 'tellable_type' => $tellable->getTellableType(), 'tellable_id' => $tellable->getId())); ?>');return false;" style="margin-left: 20px; margin-right: 20px;">Add</a><?php endif; ?></legend>
			<?php if ($tellable->getB2DBID()): ?>
				<ul class="card_attacks" id="tellable_card_opponents">
					<?php foreach ($tellable->getCardOpponents() as $card_opponent): ?>
						<?php include_template('admin/cardopponent', array('opponent' => $card_opponent)); ?>
					<?php endforeach; ?>
				</ul>
			<?php else: ?>
				<div class="faded_out" style="padding: 10px;">You need to save this <?php echo $tellable->getTellableType(); ?> before you can add AI cards</div>
			<?php endif; ?>
		</fieldset>
		<br style="clear: both;">
	<?php endif; ?>
	<fieldset>
		<legend>Basic rewards</legend>
		<div style="width: 460px; float: left; clear: none;">
			<div>
				<label for="tellable_reward_gold">Gold</label><input id="tellable_reward_gold" type="text" name="reward_gold" class="points" value="<?php echo $tellable->getRewardGold(); ?>"> gold<br>
			</div>
		</div>
		<div style="width: 460px; float: left; clear: none;">
			<div>
				<label for="tellable_reward_xp">XP</label><input id="tellable_reward_xp" type="text" name="reward_xp" class="points" value="<?php echo $tellable->getRewardXp(); ?>"> XP<br>
			</div>
		</div>
	</fieldset>
	<br style="clear: both;">
	<fieldset>
		<legend>Card rewards <?php if ($tellable->getB2DBID()): ?><a class="button button-standard" onclick="Devo.Main.Helpers.Backdrop.show('<?php echo make_url('get_backdrop_partial', array('key' => 'tellable_card_reward', 'tellable_type' => $tellable->getTellableType(), 'tellable_id' => $tellable->getId())); ?>');return false;" style="margin-left: 20px; margin-right: 20px;">Add</a><?php endif; ?></legend>
		<?php if ($tellable->getB2DBID()): ?>
			<ul class="card_attacks" id="tellable_card_rewards">
				<?php foreach ($tellable->getCardRewards() as $card_reward): ?>
					<?php include_template('admin/cardreward', array('reward' => $card_reward)); ?>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<div class="faded_out" style="padding: 10px;">You need to save this <?php echo $tellable->getTellableType(); ?> before you can add card rewards</div>
		<?php endif; ?>
	</fieldset>
	<?php if ($tellable->getTellableType() == Tellable::TYPE_STORY): ?>
		<fieldset>
			<legend>Chapters <?php if ($tellable->getB2DBID()): ?><a href="<?php echo make_url('new_tellable', array('tellable_type' => 'chapter', 'parent_id' => $tellable->getId())); ?>" class="button button-standard" style="margin-left: 10px; margin-right: 10px;">Add chapter</a><?php endif; ?></legend>
			<?php if ($tellable->getB2DBID()): ?>
				<ul class="card_attacks" id="tellable_children">
					<?php foreach ($tellable->getChapters() as $chapter_id => $chapter): ?>
						<li><a href="<?php echo make_url('edit_tellable', array('tellable_type' => Tellable::TYPE_CHAPTER, 'tellable_id' => $chapter_id)); ?>" class="button button-standard" style="font-size: 0.9em; margin-right: 5px;">Edit</a><?php echo $chapter->getName(); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php else: ?>
				<div class="faded_out" style="padding: 10px;">You need to save this story before you can add chapters</div>
			<?php endif; ?>
		</fieldset>
	<?php elseif ($tellable->getTellableType() == Tellable::TYPE_CHAPTER || $tellable->getTellableType() == Tellable::TYPE_ADVENTURE): ?>
		<fieldset>
			<legend>Parts <?php if ($tellable->getB2DBID()): ?><a href="<?php echo make_url('new_tellable', array('tellable_type' => 'part', 'parent_id' => $tellable->getId(), 'parent_type' => $tellable->getTellableType())); ?>" class="button button-standard" style="margin-left: 10px; margin-right: 10px;">Add part</a><?php endif; ?></legend>
			<?php if ($tellable->getB2DBID()): ?>
				<ul class="card_attacks" id="tellable_children">
					<?php foreach ($tellable->getParts() as $part_id => $part): ?>
						<li><a href="<?php echo make_url('edit_tellable', array('tellable_type' => Tellable::TYPE_PART, 'tellable_id' => $part_id)); ?>" class="button button-standard" style="font-size: 0.9em; margin-right: 5px;">Edit</a><?php echo $part->getName(); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php else: ?>
				<div class="faded_out" style="padding: 10px;">You need to save this story before you can add chapters</div>
			<?php endif; ?>
		</fieldset>
	<?php endif; ?>
	<br style="clear: both;">
	<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: rgba(80, 54, 32, 0.4); border: 1px dotted rgba(72, 48, 28, 0.8); border-left: none; border-right: none;">
		<input type="submit" value="Save <?php echo $tellable->getTellableType(); ?>" style="font-size: 1em; padding: 3px 10px !important;">
	</div>
</form>