<?php

	namespace application\entities\tables;

	use application\entities\ChatRoom;
    use application\entities\Game;
    use b2db\Core,
		b2db\Criteria,
		b2db\Criterion,
        caspar\core\Caspar;

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

		public function ping(\application\entities\ChatRoom $room, \application\entities\User $user)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('chat_pings.room_id', $room->getId());
			$crit->addWhere('chat_pings.user_id', $user->getId());
			if ($row = $this->doSelectOne($crit)) {
				$crit->addUpdate('chat_pings.pinged', time());
				$this->doUpdate($crit);
			} else {
				$crit = $this->getCriteria();
				$crit->addInsert('chat_pings.room_id', $room->getId());
				$crit->addInsert('chat_pings.user_id', $user->getId());
				$crit->addInsert('chat_pings.pinged', time());
				$this->doInsert($crit);
				$row = $room->say("{$user->getCharactername()} joined.", 0);

                $row = Users::getTable()->doSelectById($user->getId());
                $line = array(
                    'room_id' => $room->getId(),
                    'user_id' => $user->getId(),
                    'user' => Users::getTable()->getUserData($user->getId(), $row),
                );
                $event = array('category' => 'Chat-'.$room->getId(),
                                'event' => $line);
                Caspar::getResponse()->zmqSendEvent($event);
			}
		}

		public function cleanRoomPings()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('chat_pings.pinged', time() - 30, Criteria::DB_LESS_THAN_EQUAL);
			$res = $this->doSelect($crit);
			
			if ($res) {
				while ($row = $res->getNextRow()) {
					$id = $row->get('chat_pings.id');
					$room_id = $row['chat_pings.room_id'];
					$user_id = $row['chat_pings.user_id'];
					$user = Users::getTable()->selectById($user_id);
					$room = ChatRooms::getTable()->selectById($room_id);
                    if ($room instanceof ChatRoom) {
                        if ($room_id > 0) {
                            $game = Games::getTable()->getGameByRoomId($room_id);
                            if ($game instanceof Game && $game->isUserOnline($user_id)) {
                                $game->setUserOffline($user_id);
                                $game->save();
                            }
                        }
                        if ($room_id > 1 || $row['chat_pings.pinged'] <= (time() - 18000)) {
                            $room->say("{$user->getCharactername()} left the chat", 0, $row['chat_pings.pinged'] + 2);
                            $this->doDeleteById($id);
                        }
                    }
				}
			}
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

		public function getNumberOfUsersInGames()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('chat_pings.room_id', 1, Criteria::DB_NOT_EQUALS);
			return $this->doCount($crit);
		}

		public function getUserIdsByRoomId($room_id)
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

			return $user_ids;
		}
		
		public function getUsersByRoomId($room_id)
		{
			$user_ids = $this->getUserIdsByRoomId($room_id);

			$crit = Users::getTable()->getCriteria();
			$crit->addWhere('users.id', $user_ids, Criteria::DB_IN);
			$users = Users::getTable()->select($crit);

			return $users;
		}

	}
