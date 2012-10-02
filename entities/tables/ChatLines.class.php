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
	 * @Table(name="chat_lines")
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

		public function resetChatLines() 
		{
			$crit = $this->getCriteria();
			$crit->addWhere('chat_lines.room_id', 1, Criteria::DB_NOT_EQUALS);
			$this->doDelete($crit);
		}

		public function getLinesByRoomId($room_id, $since = null, $limit = null)
		{
			$crit = $this->getCriteria();
			$crit->addJoin(Users::getTable(), 'users.id', 'chat_lines.user_id');
			$crit->addWhere('chat_lines.room_id', $room_id);
			if ($since) {
				$crit->addWhere('chat_lines.id', $since, Criteria::DB_GREATER_THAN);
			}
			$crit->addOrderBy('chat_lines.posted', Criteria::SORT_DESC);
			$crit->setLimit($limit);

			$lines = array();
			if ($res = $this->doSelect($crit)) {
				while ($row = $res->getNextRow()) {
					$posted = $row->get('chat_lines.posted');
					$user_id = $row->get('chat_lines.user_id');
					array_unshift($lines, array('line_id' => $row->get('chat_lines.id'), 'user_id' => $user_id, 'user_username' => ($user_id) ? $row->get('users.username') : 'System', 'user_charactername' => ($user_id) ? $row->get('users.charactername') : 'System', 'user_race' => ($user_id && $row->get('users.race')) ? \application\entities\User::getRaceNameByRace($row->get('users.race')) : '', 'user_level' => ($user_id) ? $row->get('users.level') : 0, 'text' => htmlspecialchars($row->get('chat_lines.text'), ENT_NOQUOTES, 'utf-8'), 'posted' => $posted, 'posted_formatted_hours' => date('H:i', $posted), 'posted_formatted_date' => date('d/m/Y', $posted)));
				}
			}

			return $lines;
		}

		public function say($text, $user_id, $room_id, $time = null)
		{
			$time = ($time !== null) ? $time : time();
			$crit = $this->getCriteria();
			$crit->addInsert('chat_lines.room_id', $room_id);
			$crit->addInsert('chat_lines.user_id', $user_id);
			$crit->addInsert('chat_lines.text', $text);
			$crit->addInsert('chat_lines.posted', $time);
			$res = $this->doInsert($crit);
		}
		
	}
