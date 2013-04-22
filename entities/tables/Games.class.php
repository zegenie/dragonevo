<?php

	namespace application\entities\tables;

	use \b2db\Core,
		\b2db\Criteria,
		\b2db\Criterion,
		\b2db\Table;

	/**
	 * Games table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="games")
	 * @Entity(class="\application\entities\Game")
	 */
	class Games extends Table
	{

		public function getGamesByUserId($user_id, $ongoing = true)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.player_id', $user_id);
			$crit->addWhere('games.part_id', 0);
			if ($ongoing !== null) {
				if ($ongoing) {
					$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED, Criteria::DB_NOT_EQUALS);
				} else {
					$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
				}
			}
			$crit->addWhere('games.opponent_id', 0, Criteria::DB_NOT_EQUALS);
			$ctn = $crit->returnCriterion('games.opponent_id', $user_id);
			$ctn->addWhere('games.invitation_confirmed', true);
			if ($ongoing !== null) {
				if ($ongoing) {
					$ctn->addWhere('games.state', \application\entities\Game::STATE_COMPLETED, Criteria::DB_NOT_EQUALS);
				} else {
					$ctn->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
				}
			}
			$crit->addOr($ctn);

			return $this->select($crit);
		}

		public function getNumberOfGamesByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
			$crit->addWhere('games.part_id', 0);
			$ctn = $crit->returnCriterion('games.opponent_id', $user_id);
			$ctn->addOr('games.player_id', $user_id);
			$crit->addWhere($ctn);

			return $this->count($crit);
		}

		public function getNumberOfGamesWonByUserId($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.part_id', 0);
			$crit->addWhere('games.winning_player_id', $user_id);

			return $this->count($crit);
		}

		public function cleanOldQuickmatchGames($user_id)
		{
			$past = time() - 60;
			$crit = $this->getCriteria();
			$crit->addWhere('games.player_id', $user_id, Criteria::DB_NOT_EQUALS);
			$crit->addWhere('games.opponent_id', 0);
			$crit->addWhere('games.invitation_sent', false);
			$crit->addWhere('games.created_at', $past, Criteria::DB_LESS_THAN);
			$crit->addJoin(Users::getTable(), 'users.id', 'games.player_id');
			$crit->addSelectionColumn('users.lastseen', 'lastseen');
			$crit->addSelectionColumn('games.created_at', 'created_at');
			$crit->addSelectionColumn('games.id', 'id');
			$crit->addOrderBy('games.id', Criteria::SORT_ASC);

			$res = $this->doSelect($crit);
			$games = array();
			if ($res) {
				while ($row = $res->getNextRow()) {
					$created_at = $row->get('created_at');
					if ($row->get('lastseen') < $created_at || $created_at < $past) {
						$games[$row->get('id')] = true;
					}
				}
				if (count($games)) {
					$crit = $this->getCriteria();
					$crit->addWhere('games.id', array_keys($games), Criteria::DB_IN);
					$this->doDelete($crit);
				}
			}
		}

		public function getAvailableGameForQuickmatch($user_id)
		{
			$this->cleanOldQuickmatchGames($user_id);
			
			$crit = $this->getCriteria();
			$crit->addWhere('games.player_id', $user_id, Criteria::DB_NOT_EQUALS);
			$crit->addWhere('games.opponent_id', 0);
			$crit->addWhere('games.invitation_sent', false);
			$crit->addOrderBy('games.id', Criteria::SORT_ASC);
			$crit->setLimit(1);

			return $this->selectOne($crit);
		}

		public function getGameByRoomId($room_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.chatroom_id', $room_id);

			return $this->selectOne($crit);
		}

		public function getQuickmatchGameForUser($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.player_id', $user_id);
			$crit->addWhere('games.quickmatch_state', 1);
			$crit->setLimit(1);

			$game = $this->selectOne($crit);
			
			return $game;
		}

		public function getCurrentPartAttemptForUser($user_id, $part_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.player_id', $user_id);
			$crit->addWhere('games.part_id', $part_id);
			$crit->addWhere('games.state', \application\entities\Game::STATE_ONGOING);
			$crit->setLimit(1);

			$game = $this->selectOne($crit);

			return $game;
		}

		protected function _getAiIds()
		{
			$ai_easy = \application\entities\tables\Users::getTable()->getByUsername('ai_easy');
			$ai_normal = \application\entities\tables\Users::getTable()->getByUsername('ai_normal');
			$ai_hard = \application\entities\tables\Users::getTable()->getByUsername('ai_hard');
			
			return array($ai_easy->getId(), $ai_normal->getId(), $ai_hard->getId());
		}
		
		public function getNumberOfCurrentMultiplayerGames()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.state', \application\entities\Game::STATE_ONGOING);
			$crit->addWhere('games.opponent_id', $this->_getAiIds(), Criteria::DB_NOT_IN);
			$crit->addWhere('games.part_id', 0);

			return $this->count($crit);
		}

		public function getNumberOfCurrentTrainingGames()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.state', \application\entities\Game::STATE_ONGOING);
			$crit->addWhere('games.opponent_id', $this->_getAiIds(), Criteria::DB_IN);
			$crit->addWhere('games.part_id', 0);

			return $this->count($crit);
		}

		public function getNumberOfCurrentScenarioGames()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.state', \application\entities\Game::STATE_ONGOING);
			$crit->addWhere('games.part_id', 0, Criteria::DB_NOT_EQUALS);

			return $this->count($crit);
		}

		public function getNumberOfMultiplayerGamesLast24Hours()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.opponent_id', $this->_getAiIds(), Criteria::DB_NOT_IN);
			$crit->addWhere('games.part_id', 0);
			$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
			$crit->addWhere('games.ended_at', time() - 86400, \b2db\Criteria::DB_GREATER_THAN_EQUAL);

			return $this->count($crit);
		}

		public function getNumberOfMultiplayerGamesLastWeek()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.opponent_id', $this->_getAiIds(), Criteria::DB_NOT_IN);
			$crit->addWhere('games.part_id', 0);
			$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
			$crit->addWhere('games.ended_at', time() - 604800, \b2db\Criteria::DB_GREATER_THAN_EQUAL);

			return $this->count($crit);
		}

		public function getNumberOfScenarioGamesLast24Hours()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.part_id', 0, Criteria::DB_NOT_EQUALS);
			$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
			$crit->addWhere('games.ended_at', time() - 86400, \b2db\Criteria::DB_GREATER_THAN_EQUAL);

			return $this->count($crit);
		}

		public function getNumberOfScenarioGamesLastWeek()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.part_id', 0, Criteria::DB_NOT_EQUALS);
			$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
			$crit->addWhere('games.ended_at', time() - 604800, \b2db\Criteria::DB_GREATER_THAN_EQUAL);

			return $this->count($crit);
		}

		public function getNumberOfTrainingGamesLast24Hours()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.opponent_id', $this->_getAiIds(), Criteria::DB_IN);
			$crit->addWhere('games.part_id', 0);
			$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
			$crit->addWhere('games.ended_at', time() - 86400, \b2db\Criteria::DB_GREATER_THAN_EQUAL);

			return $this->count($crit);
		}

		public function getNumberOfTrainingGamesLastWeek()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.opponent_id', $this->_getAiIds(), Criteria::DB_IN);
			$crit->addWhere('games.part_id', 0);
			$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
			$crit->addWhere('games.ended_at', time() - 604800, \b2db\Criteria::DB_GREATER_THAN_EQUAL);

			return $this->count($crit);
		}

		public function getNumberOfGamesLast24Hours()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
			$crit->addWhere('games.ended_at', time() - 86400, \b2db\Criteria::DB_GREATER_THAN_EQUAL);

			return $this->count($crit);
		}

		public function getNumberOfGamesLastWeek()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.state', \application\entities\Game::STATE_COMPLETED);
			$crit->addWhere('games.ended_at', time() - 604800, \b2db\Criteria::DB_GREATER_THAN_EQUAL);

			return $this->count($crit);
		}

		public function getAllByState($state, $type)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.state', $state);
			switch ($type) {
				case 'multiplayer';
					$crit->addWhere('games.opponent_id', $this->_getAiIds(), Criteria::DB_NOT_IN);
					$crit->addWhere('games.part_id', 0);
					break;
				case 'scenario';
					$crit->addWhere('games.part_id', 0, Criteria::DB_NOT_EQUALS);
					break;
				case 'training';
					$crit->addWhere('games.opponent_id', $this->_getAiIds(), Criteria::DB_IN);
					$crit->addWhere('games.part_id', 0);
					break;
			}
			$crit->addOrderBy('games.created_at', \b2db\Criteria::SORT_DESC);
			return $this->select($crit);
		}

	}
