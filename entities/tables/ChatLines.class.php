<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

	/**
	 * Chat lines table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="settings")
	 */
	class ChatLines extends \b2db\Table
	{

		protected function _initialize()
		{
			parent::_setup('chat_lines', 'chat_lines.id');
			parent::_addText('chat_lines.text', 45);
			parent::_addInteger('chat_lines.posted', 10);
			parent::_addInteger('chat_lines.user_id', 10);
			parent::_addInteger('chat_lines.game_id', 10);
			parent::_addInteger('chat_lines.room_id', 10);
		}

		public function getLinesByRoomId($room_id, $since, $limit = null)
		{
			$crit = $this->getCriteria();
			$crit->addJoin(Users::getTable(), 'users.id', 'chat_lines.user_id');
			$crit->addWhere('chat_lines.room_id', $room_id);
			$crit->addWhere('chat_lines.posted', $since, Criteria::DB_GREATER_THAN_EQUAL);
			$crit->orderBy('chat_lines.posted', Criteria::DB_SORT_DESC);
			$crit->setLimit($limit);

			$lines = array();
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$lines[$row->get('chat_lines.id')] = array('user_id' => $row->get('users.id'), 'user_username' => $row->get('users.username'), 'text' => $row->get('chat_lines.text'), 'posted' => $row->get('chat_lines.posted'));
				}
			}

			return $lines;
		}

		public function say($text, $user_id, $room_id)
		{
			$crit = $this->getCriteria();
			$crit->addInsert('chat_lines.room_id', $room_id);
			$crit->addInsert('chat_lines.user_id', $user_id);
			$crit->addInsert('chat_lines.text', $text);
			$crit->addInsert('chat_lines.posted', time());
			$res = $this->doInsert($crit);
		}
		
	}
