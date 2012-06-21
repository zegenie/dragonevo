<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

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
	class Games extends \b2db\Table
	{

		public function getGamesByUserId($user_id, $ongoing = true)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.player_id', $user_id);
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

		public function cleanOldQuickmatchGames($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.player_id', $user_id, Criteria::DB_NOT_EQUALS);
			$crit->addWhere('games.opponent_id', 0);
			$crit->addWhere('games.invitation_sent', false);
			$crit->addWhere('games.created_at', time() - 300, Criteria::DB_LESS_THAN);
			$crit->addJoin(Users::getTable(), 'users.id', 'games.player_id');
			$crit->addSelectionColumn('users.lastseen', 'lastseen');
			$crit->addSelectionColumn('games.created_at', 'created_at');
			$crit->addSelectionColumn('games.id', 'id');
			$crit->addOrderBy('games.id', Criteria::SORT_ASC);

			$res = $this->doSelect($crit);
			$games = array();
			if ($res) {
				while ($row = $res->getNextRow()) {
					if ($row->get('lastseen') < $row->get('created_at')) {
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

		public function getQuickmatchGameForUser($user_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.player_id', $user_id);
			$crit->addWhere('games.quickmatch_state', 1);
			$crit->setLimit(1);

			return $this->selectOne($crit);
		}

		public function getNumberOfCurrentGames()
		{
			$crit = $this->getCriteria();
			$crit->addWhere('games.state', \application\entities\Game::STATE_ONGOING);

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

	}
