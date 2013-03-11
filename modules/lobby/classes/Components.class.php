<?php 

	namespace application\modules\lobby;

	/**
	 * market action components
	 */
	class Components extends \caspar\core\Components
	{

		public function componentChatRoom()
		{
			$this->room = (isset($this->room)) ? $this->room : new \application\entities\ChatRoom(1);
		}

		public function componentLobbyContent()
		{
			\application\entities\tables\ChatPings::getTable()->cleanRoomPings();
			$this->num_users = \application\entities\tables\ChatPings::getTable()->getNumberOfUsersByRoomId(1);
		}

	}
