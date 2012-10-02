<?php

	namespace application\lib;

	class Response extends \caspar\core\Response
	{
		
		protected $_fullscreen = false;

		public function setFullscreen($fullscreen = true)
		{
			$this->_fullscreen = $fullscreen;
		}
		
		public function isFullscreen()
		{
			return $this->_fullscreen;
		}

	}