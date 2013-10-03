<?php

	namespace application\entities\tables;

	use b2db\Core,
		b2db\Criteria,
		b2db\Criterion;

	/**
	 * News table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 3.1
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package dragonevo
	 * @subpackage tables
	 *
	 * @Table(name="news")
	 * @Entity(class="\application\entities\News")
	 */
	class News extends \b2db\Table
	{

		public function getLatestNews($limit = 10)
		{
			return $this->getNews($limit);
		}

		public function getNews($limit = null)
		{
			$crit = $this->getCriteria();
			$crit->addOrderBy('news.created_at', Criteria::SORT_DESC);
			
			if ($limit)
				$crit->setLimit($limit);

			return $this->select($crit);
		}

		public function getAll()
		{
			return $this->getNews();
		}

	}
