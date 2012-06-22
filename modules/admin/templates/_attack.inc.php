<div class="backdrop_box large" id="login_popup">
	<div id="backdrop_detail_content" class="rounded_top login_content">
		<form method="post" accept-charset="utf-8" id="admin_attack_form" action="<?php echo ($attack->getId()) ? make_url('edit_attack', array('attack_id' => $attack->getId())) : make_url('create_attack'); ?>" onsubmit="Devo.Admin.Cards.saveAttack(this);return false;">
			<?php if (!$attack->getId()): ?>
				<h1>Create new attack</h1>
			<?php endif; ?>
			<input type="hidden" name="card_id" value="<?php echo $card->getId(); ?>">
			<input type="hidden" name="attack_id" value="<?php echo $attack->getId(); ?>">
			<input type="hidden" name="mode" value="edit">
			<fieldset>
				<legend>Basic details</legend>
				<div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_name">Name</label><input id="attack_<?php echo $attack->getId(); ?>_name" type="text" name="name" value="<?php echo $attack->getName(); ?>" style="width: 150px;">
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_description">Description</label>
						<textarea name="description" id="attack_<?php echo $attack->getId(); ?>_description" style="width: 400px; height: 60px;"><?php echo $attack->getDescription(); ?></textarea>
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_type">Attack type</label>
						<select name="attack_type" id="attack_<?php echo $attack->getId(); ?>_type">
							<?php foreach (application\entities\Attack::getTypes() as $a_type => $a_desc): ?>
								<option value="<?php echo $a_type; ?>"<?php if ($attack->getAttackType() == $a_type): ?> selected<?php endif; ?>><?php echo $a_desc; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_mandatory_no">Mandatory</label>
						<input id="attack_<?php echo $attack->getId(); ?>_mandatory_no" type="radio" name="mandatory" value="0"<?php if (!$attack->isMandatory()): ?> checked<?php endif; ?>><label for="attack_<?php echo $attack->getId(); ?>_mandatory_no" style="font-weight: normal; display: inline; float: none;">No</label>
						<input id="attack_<?php echo $attack->getId(); ?>_mandatory_yes" type="radio" name="mandatory" value="1"<?php if ($attack->isMandatory()): ?> checked<?php endif; ?>><label for="attack_<?php echo $attack->getId(); ?>_mandatory_yes" style="font-weight: normal; display: inline; float: none;">Yes</label><br>
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_attack_all_no">Attacks all cards</label>
						<input id="attack_<?php echo $attack->getId(); ?>_attack_all_no" type="radio" name="attack_all" value="0"<?php if (!$attack->doesAttackAll()): ?> checked<?php endif; ?>><label for="attack_<?php echo $attack->getId(); ?>_attack_all_no" style="font-weight: normal; display: inline; float: none;">No</label>
						<input id="attack_<?php echo $attack->getId(); ?>_attack_all_yes" type="radio" name="attack_all" value="1"<?php if ($attack->doesAttackAll()): ?> checked<?php endif; ?>><label for="attack_<?php echo $attack->getId(); ?>_attack_all_yes" style="font-weight: normal; display: inline; float: none;">Yes</label><br>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Cost</legend>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_cost_gold">Gold</label><input id="attack_<?php echo $attack->getId(); ?>_cost_gold" type="text" name="cost_gold" value="<?php echo $attack->getCostGold(); ?>" style="width: 40px; text-align: right;"> gold<br>
					</div>
				</div>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_cost_magic">Magic</label><input id="attack_<?php echo $attack->getId(); ?>_cost_magic" type="text" name="cost_magic" value="<?php echo $attack->getCostMagic(); ?>" style="width: 40px; text-align: right;"> EP<br>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Requirements</legend>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_requires_level">Card level</label><input id="attack_<?php echo $attack->getId(); ?>_requires_level" type="text" name="requires_level" value="<?php echo $attack->getRequiresLevel(); ?>" style="width: 40px; text-align: right;"><br>
						<div class="faded_out" style="padding: 10px 0 0 140px;">Level 0 means no requirements</div>
					</div>
				</div>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_requires_item_card_type_1">Powerup item 1</label>
						<select id="attack_<?php echo $attack->getId(); ?>_requires_item_card_type_1" name="requires_item_card_type_1">
							<option value="0"<?php if ($attack->getRequiresItemCardType1() == 0) echo ' selected'; ?>>No requirements</option>
							<?php foreach (\application\entities\ItemCard::getItemClasses() as $class_key => $description): ?>
								<option value="<?php echo $class_key; ?>"<?php if ($attack->getRequiresItemCardType1() == $class_key) echo ' selected'; ?>><?php echo $description; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div>
					<select name="attack_<?php echo $attack->getId(); ?>_requires_item_both" id="attack_<?php echo $attack->getId(); ?>_requires_item_both" style="margin-left: 140px;">
						<option value="1"<?php if ($attack->doesRequireBothItems()) echo ' selected'; ?>>and</option>
						<option value="0"<?php if (!$attack->doesRequireBothItems()) echo ' selected'; ?>>or</option>
					</select>
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_requires_item_card_type_2">Powerup item 2</label>
						<select id="attack_<?php echo $attack->getId(); ?>_requires_item_card_type_2" name="requires_item_card_type_2">
							<option value="0"<?php if ($attack->getRequiresItemCardType2() == 0) echo ' selected'; ?>>No requirements</option>
							<?php foreach (\application\entities\ItemCard::getItemClasses() as $class_key => $description): ?>
								<option value="<?php echo $class_key; ?>"<?php if ($attack->getRequiresItemCardType2() == $class_key) echo ' selected'; ?>><?php echo $description; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Properties</legend>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_hp_min">Damage dealt</label><input id="attack_<?php echo $attack->getId(); ?>_hp_min" type="text" name="hp_min" value="<?php echo $attack->getAttackPointsMin(); ?>" style="width: 25px; text-align: center;"> - <input id="attack_<?php echo $attack->getId(); ?>_hp_max" type="text" name="hp_max" value="<?php echo $attack->getAttackPointsMax(); ?>" style="width: 25px; text-align: center;"> HP<br>
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_rep_min">Repeat</label><input id="attack_<?php echo $attack->getId(); ?>_rep_min" type="text" name="rep_min" value="<?php echo $attack->getRepeatRoundsMin(); ?>" style="width: 25px; text-align: center;"> - <input id="attack_<?php echo $attack->getId(); ?>_rep_max" type="text" name="rep_max" value="<?php echo $attack->getRepeatRoundsMax(); ?>" style="width: 25px; text-align: center;"> times<br>
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_rep_hp_min">Repeat damage</label><input id="attack_<?php echo $attack->getId(); ?>_rep_hp_min" type="text" name="rep_hp_min" value="<?php echo $attack->getRepeatAttackPointsMin(); ?>" style="width: 25px; text-align: center;"> - <input id="attack_<?php echo $attack->getId(); ?>_rep_hp_max" type="text" name="rep_hp_max" value="<?php echo $attack->getRepeatAttackPointsMax(); ?>" style="width: 25px; text-align: center;"> HP<br>
					</div>
				</div>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_unblockable_no">Blockable</label>
						<input id="attack_<?php echo $attack->getId(); ?>_unblockable_no" type="radio" name="unblockable" value="0"<?php if ($attack->isBlockable()): ?> checked<?php endif; ?>><label for="attack_<?php echo $attack->getId(); ?>_unblockable_no" style="font-weight: normal; display: inline; float: none;">Yes</label>
						<input id="attack_<?php echo $attack->getId(); ?>_unblockable_yes" type="radio" name="unblockable" value="1"<?php if ($attack->isMandatory()): ?> checked<?php endif; ?>><label for="attack_<?php echo $attack->getId(); ?>_unblockable_yes" style="font-weight: normal; display: inline; float: none;">No</label><br>
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_critical_hit_percentage">Critical hit pct.</label><input id="attack_<?php echo $attack->getId(); ?>_critical_hit_percentage" type="text" name="critical_hit_percentage" value="<?php echo $attack->getCriticalHitPercentage(); ?>" style="width: 25px; text-align: center;"> %<br>
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_hp_restored">HP restored</label><input id="attack_<?php echo $attack->getId(); ?>_hp_restored" type="text" name="hp_restored" value="<?php echo $attack->getAttackPointsRestored(); ?>" style="width: 25px; text-align: right;"> %<br>
						<div class="faded_out" style="padding: 10px 0 0 140px;">"Vampire" effect - steals HP</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Stun</legend>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_stun_percentage_min">Stun percentage</label><input id="attack_<?php echo $attack->getId(); ?>_stun_percentage_min" type="text" name="stun_percentage_min" value="<?php echo $attack->getStunPercentageMin(); ?>" style="width: 25px; text-align: center;"> - <input id="attack_<?php echo $attack->getId(); ?>_stun_percentage_max" type="text" name="stun_percentage_max" value="<?php echo $attack->getStunPercentageMax(); ?>" style="width: 25px; text-align: center;"> %<br>
					</div>
				</div>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_stun_duration_min">Stun duration</label><input id="attack_<?php echo $attack->getId(); ?>_stun_duration_min" type="text" name="stun_duration_min" value="<?php echo $attack->getStunDurationMin(); ?>" style="width: 25px; text-align: center;"> - <input id="attack_<?php echo $attack->getId(); ?>_stun_duration_max" type="text" name="stun_duration_max" value="<?php echo $attack->getStunDurationMax(); ?>" style="width: 25px; text-align: center;"> rounds<br>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Own penalties</legend>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_penalty_rounds_min">Penalty rounds</label><input id="attack_<?php echo $attack->getId(); ?>_penalty_rounds_min" type="text" name="penalty_rounds_min" value="<?php echo $attack->getPenaltyRoundsMin(); ?>" style="width: 25px; text-align: center;"> - <input id="attack_<?php echo $attack->getId(); ?>_penalty_rounds_max" type="text" name="penalty_rounds_max" value="<?php echo $attack->getPenaltyRoundsMax(); ?>" style="width: 25px; text-align: center;"> rounds<br>
					</div>
				</div>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_penalty_dmg">Penalty dmg</label><input id="attack_<?php echo $attack->getId(); ?>_penalty_dmg" type="text" name="penalty_dmg" value="<?php echo $attack->getPenaltyDmg(); ?>" style="width: 25px; text-align: center;"> HP<br>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Own bonuses</legend>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_generate_gold_amount">Generate gold</label><input id="attack_<?php echo $attack->getId(); ?>_generate_gold_amount" type="text" name="generate_gold_amount" value="<?php echo $attack->getGenerateGoldAmount(); ?>" style="width: 25px; text-align: center;"> gold<br>
					</div>
				</div>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_generate_magic_amount">Generate magic</label><input id="attack_<?php echo $attack->getId(); ?>_generate_magic_amount" type="text" name="generate_magic_amount" value="<?php echo $attack->getGenerateMagicAmount(); ?>" style="width: 25px; text-align: center;"> EP<br>
					</div>
				</div>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_generate_hp_amount">Regenerate health</label><input id="attack_<?php echo $attack->getId(); ?>_generate_hp_amount" type="text" name="generate_hp_amount" value="<?php echo $attack->getGenerateHpAmount(); ?>" style="width: 25px; text-align: center;"> %<br>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Stealing</legend>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_steal_gold_chance">Gold chance</label><input id="attack_<?php echo $attack->getId(); ?>_steal_gold_chance" type="text" name="steal_gold_chance" value="<?php echo $attack->getStealGoldChance(); ?>" style="width: 25px; text-align: center;"> %<br>
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_steal_gold_amount">Gold amount</label><input id="attack_<?php echo $attack->getId(); ?>_steal_gold_amount" type="text" name="steal_gold_amount" value="<?php echo $attack->getStealGoldAmount(); ?>" style="width: 25px; text-align: center;"> %<br>
					</div>
				</div>
				<div style="width: 380px; float: left; clear: none;">
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_steal_magic_chance">Magic chance</label><input id="attack_<?php echo $attack->getId(); ?>_steal_magic_chance" type="text" name="steal_magic_chance" value="<?php echo $attack->getStealMagicChance(); ?>" style="width: 25px; text-align: center;"> %<br>
					</div>
					<div>
						<label for="attack_<?php echo $attack->getId(); ?>_steal_magic_amount">Magic amount</label><input id="attack_<?php echo $attack->getId(); ?>_steal_magic_amount" type="text" name="steal_magic_amount" value="<?php echo $attack->getStealMagicAmount(); ?>" style="width: 25px; text-align: center;"> %<br>
					</div>
				</div>
			</fieldset>
			<br style="clear: both;">
			<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: rgba(80, 54, 32, 0.4); border: 1px dotted rgba(72, 48, 28, 0.8); border-left: none; border-right: none;">
				<img src="/images/spinning_20.gif" id="save_attack_indicator" style="display: none; margin: 2px 5px -6px 0;">
				<input type="submit" value="<?php echo ($attack->getId()) ? 'Update attack' : 'Create attack'; ?>" style="font-size: 1em; padding: 3px 10px !important;">
			</div>
		</form>
	</div>
	<div class="backdrop_detail_footer">
		<a href="javascript:void(0);" onclick="Devo.Main.Helpers.Backdrop.reset();">Close</a>
	</div>
</div>
