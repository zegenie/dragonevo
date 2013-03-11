<?php

	namespace application\entities\tables;

	/**
	 * @Table(name="game_cards")
	 * @Entity(class="\application\entities\GameCard")
	 */
	class GameCards extends \b2db\Table
	{

		public function getByUserIdAndGameId($user_id, $game_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('game_cards.user_id', $user_id);
			$crit->addWhere('game_cards.game_id', $game_id);
			return $this->select($crit);
		}

	}