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

	}
