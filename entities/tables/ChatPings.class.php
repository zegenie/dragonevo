<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

	/**
	 * Chat pings table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="chat_pings")
	 */
	class ChatPings extends \b2db\Table
	{

		protected function _initialize()
		{
			parent::_setup('chat_pings', 'chat_pings.id');
			parent::_addInteger('chat_pings.pinged', 10);
			parent::_addInteger('chat_pings.user_id', 10);
			parent::_addInteger('chat_pings.room_id', 10);
		}

		public function ping($room_id, $user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('chat_pings.room_id', $room_id);
			$crit->addWhere('chat_pings.user_id', $user_id);
			if ($row = $this->doSelectOne($crit)) {
				$crit->addUpdate('chat_pings.pinged', time());
				$this->doUpdate($crit);
			} else {
				$crit = $this->getCriteria();
				$crit->addInsert('chat_pings.room_id', $room_id);
				$crit->addInsert('chat_pings.user_id', $user_id);
				$crit->addInsert('chat_pings.pinged', time());
				$this->doInsert($crit);
			}
		}

		public function cleanRoomPings($room_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('chat_pings.room_id', $room_id);
			$crit->addWhere('chat_pings.pinged', time() - 60 * 5, Criteria::DB_LESS_THAN_EQUAL);
			$this->doDelete($crit);
		}

		public function cleanUserPings($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('chat_pings.user_id', $user_id);
			$this->doDelete($crit);
		}

		public function getNumberOfUsersByRoomId($room_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('chat_pings.room_id', $room_id);
			return $this->doCount($crit);
		}

		public function getUsersByRoomId($room_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('chat_pings.room_id', $room_id);
			$crit->addSelectionColumn('chat_pings.user_id');
			$user_ids = array();

			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$user_id = $row->get('chat_pings.user_id');
					$user_ids[$user_id] = $user_id;
				}
			}

			$crit = Users::getTable()->getCriteria();
			$crit->addWhere('users.id', $user_ids, Criteria::DB_IN);
			$users = Users::getTable()->select($crit);

			return $users;
		}
		
	}
