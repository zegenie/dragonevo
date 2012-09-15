<?php

	namespace application\entities\tables;

	/**
	 * @Table(name="modifier_effects")
	 * @Entity(class="\application\entities\ModifierEffect")
	 */
	class ModifierEffects extends \b2db\Table
	{

		public function removeEffects($game_id = null)
		{
			$crit = $this->getCriteria();
			if ($game_id !== null) $crit->addWhere('modifier_effects.game_id', $game_id);
			$this->doDelete($crit);
		}

	}