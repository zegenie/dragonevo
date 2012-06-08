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

		public function getInvitesByUserId($user_id, $exclude_ids = array())
		{
			$crit = $this->getCriteria();
			if (is_array($exclude_ids) && count($exclude_ids)) {
				$crit->addWhere('game_invites.id', $exclude_ids, Criteria::DB_NOT_IN);
			}
			$crit->addWhere('game_invites.to_player_id', $user_id);

			return $this->select($crit);
		}

		public function getRemovedInvitesByUserId($user_id, $invite_ids = array())
		{
			if (count((array) $invite_ids)) {
				$crit = $this->getCriteria();
				if (is_array($invite_ids)) {
					$crit->addWhere('game_invites.id', $invite_ids, Criteria::DB_IN);
				}
				$crit->addWhere('game_invites.to_player_id', $user_id);
				$crit->addSelectionColumn('game_invites.id', 'id');

				$invites = array_flip($invite_ids);
				if ($res = $this->select($crit)) {
					while ($row = $res->getNextRow()) {
						$id = $row->get('id');
						if (array_key_exists($id, $invites)) {
							unset($invites[$id]);
						}
					}
				}
				return array_flip($invites);
			}
			return array();
		}

		public function deleteInvitesByGameId($game_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('game_invites.game_id', $game_id);

			return $this->doDelete($crit);
		}

	}
