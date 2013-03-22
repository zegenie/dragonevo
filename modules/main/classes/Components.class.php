<?php 

	namespace application\modules\main;

	/**
	 * Main action components
	 */
	class Components extends \caspar\core\Components
	{

		public function componentLoginpopup()
		{
			if ($this->getRequest()->getParameter('redirect') == true)
				$this->mandatory = true;
		}

		public function componentLogin()
		{
			$this->selected_tab = isset($this->section) ? $this->section : 'login';
			$this->options = $this->getParameterHolder();

			if (array_key_exists('HTTP_REFERER', $_SERVER)):
				$this->referer = $_SERVER['HTTP_REFERER'];
			else:
				$this->referer = $this->getRouting()->generate('home');
			endif;

		}

		public function componentLatestNews()
		{
			$this->latest_news = \application\entities\tables\News::getTable()->getLatestNews();
		}

		public function componentCardOfTheWeek()
		{
			$this->card = \application\entities\Settings::getCardOfTheWeek();
			$this->preview = (isset($this->preview)) ? $this->preview : false;
		}

		public function componentSkill()
		{
			$this->trained = $this->getUser()->hasTrainedSkill($this->skill);
		}

		public function componentMyGames()
		{
			$this->games = $this->getUser()->getGames();			
		}

		public function componentInviteFriend()
		{
			$this->userfriends = $this->getUser()->getUserFriends();
		}

		public function componentProfileContent()
		{
			$greetings = array('Hello', 'Hey there', 'Hola', 'Bonjour', 'Ohoy', 'Heya', 'Hey', 'Welcome', 'There you are');
			$this->intro = $greetings[array_rand($greetings)];
			$this->games = $this->getUser()->getGames();
			$this->games_played = \application\entities\tables\Games::getTable()->getNumberOfGamesByUserId($this->getUser()->getId());
			$this->games_won = \application\entities\tables\Games::getTable()->getNumberOfGamesWonByUserId($this->getUser()->getId());
			$this->pct_won = ($this->games_played > 0) ? round(($this->games_won / $this->games_played) * 100, 1) : 0;
		}

		public function componentProfileCardsContent()
		{
			$this->factions = \application\entities\Card::getFactions();
			$this->itemclasses = \application\entities\EquippableItemCard::getEquippableItemClasses();
			$this->cards = $this->getUser()->getCards();
		}

		public function componentProfileSkillsContent()
		{
			$this->available_skills = \application\entities\tables\Skills::getTable()->getSkillsByRace($this->getUser()->getRace());
			$this->user_skills = $this->getUser()->getSkills();
		}

	}
