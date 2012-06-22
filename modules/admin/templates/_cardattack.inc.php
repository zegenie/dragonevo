<li id="admin_card_attack_<?php echo $attack->getId(); ?>">
	<button class="button button-standard" onclick="Devo.Main.Helpers.Backdrop.show('<?php echo make_url('get_backdrop_partial', array('key' => 'attack', 'attack_id' => $attack->getId())); ?>');return false;">Edit</button>
	<span class="attack_name"><?php echo $attack->getName(); ?></span>
	&nbsp;&nbsp;&ndash;&nbsp;&nbsp;<span class="attack_impact"><?php
		
		if ($attack->hasAttackPointsRange()) {
			echo $attack->getAttackPointsMin() . '-' . $attack->getAttackPointsMax() . 'HP';
		} elseif ($attack->getAttackPointsMin()) {
			echo $attack->getAttackPointsMin() . 'HP';
		} elseif ($attack->isBonusAttack()) {
			if ($attack->doesRegenerateHP()) {
				echo '(Re-)generates '.$attack->getGenerateHpAmount().'% HP';
			} elseif ($attack->doesRegenerateEP()) {
				echo '(Re-)generates '.$attack->getGenerateMagicAmount().' EP';
			} elseif ($attack->doesGenerateGold()) {
				echo 'Generates '.$attack->getGenerateGoldAmount().' gold';
			}
		}

		if ($attack->isRepeatable()) {
			echo '(+';
			if ($attack->hasRepeatAttackPointsRange()) {
				echo $attack->getRepeatAttackPointsMin() . '-' . $attack->getRepeatAttackPointsMax();
			} else {
				echo $attack->getRepeatAttackPointsMin();
			}
			echo 'HP x ';
			if ($attack->hasRepeatRoundsRange()) {
				echo $attack->getRepeatRoundsMin() . '-' . $attack->getRepeatRoundsMax();
			} else {
				echo $attack->getRepeatRoundsMin();
			}
			echo ')';
		}
		
		if ($attack->canStun()) echo ', can stun';
		if ($attack->canStealGold() && $attack->canStealMagic()) echo ', can steal gold and magic';
		elseif ($attack->canStealGold()) echo ', can steal gold';
		elseif ($attack->canStealMagic()) echo ', can steal magic';
		if ($attack->isUnblockable()) echo ', unblockable';

	?></span>
</li>