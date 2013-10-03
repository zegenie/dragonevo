<?php

	namespace application\lib;

	class Response extends \caspar\core\Response
	{
		
		protected $_version = '0.5.7.2.1';

		protected $_fullscreen = false;

        protected $_socket = null;
        protected $_zmq_context = null;

        public function setFullscreen($fullscreen = true)
		{
			$this->_fullscreen = $fullscreen;
		}
		
		public function isFullscreen()
		{
			return $this->_fullscreen;
		}

		public function getVersion()
		{
			return $this->_version;
		}

        protected function _getZmqSocket()
        {
            if ($this->_zmq_context === null) {
                $context = new \ZMQContext();
                $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
                $socket->connect("tcp://localhost:5555");
                $this->_socket = $socket;
            }

            return $this->_socket;
        }

        public function zmqSendEvent($event)
        {
            $this->_getZmqSocket()->send(json_encode($event));
        }

    }
