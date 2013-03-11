<?php 

	namespace application\modules\adventure;

	/**
	 * market action components
	 */
	class Components extends \caspar\core\Components
	{

		/**
		 * Index page
		 *
		 * @param Request $request
		 */
		public function componentAdventureContent()
		{
			$this->stories = \application\entities\tables\Stories::getTable()->getAll();
			$this->adventures = \application\entities\tables\Adventures::getTable()->getAll();
			$user_id = $this->getUser()->getId();
			$this->completed_items = array(
				'adventure' => \application\entities\tables\UserAdventures::getTable()->getAdventuresByUserId($user_id),
				'story' => \application\entities\tables\UserStories::getTable()->getStoriesByUserId($user_id),
				'chapter' => \application\entities\tables\UserChapters::getTable()->getChaptersByUserId($user_id),
				'part' => \application\entities\tables\UserParts::getTable()->getPartsByUserId($user_id),
				);
		}
		
		/**
		 * Menu bar component
		 *
		 * @param Request $request
		 */
		public function componentMenubar()
		{
			$this->factions = \application\entities\Card::getFactions();
		}

	}
