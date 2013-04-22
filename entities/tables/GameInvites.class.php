<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

	/**
	 * Game invites table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="game_invites")
	 * @Entity(class="\application\entities\GameInvite")
	 */
	class GameInvites extends \b2db\Table
	{

		public function getInvitesByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('game_invites.to_player_id', $user_id);

			return $this->select($crit);
		}

		public function getAll()
		{
			return $this->selectAll($crit);
		}

		public function deleteInvitesByGameId($game_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('game_invites.game_id', $game_id);

			return $this->doDelete($crit);
		}

	}
