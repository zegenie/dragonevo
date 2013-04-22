<?php

    namespace application\modules\main\cli;
    
    use caspar\core\Caspar,
		application\entities\User,
		application\entities\Game;

    class GameReminders extends \caspar\core\CliCommand
    {
		
		protected $_mailer = null;

        protected function _setup()
        {
            $this->_command_name = 'game_reminders';
            $this->_description = 'Reminds all users about games awaiting their action';
        }

		protected function _getMailer()
		{
			if ($this->_mailer === null) {
				require_once CASPAR_LIB_PATH . 'swift/lib/swift_required.php';
				$transport = \Swift_SmtpTransport::newInstance('smtp.domeneshop.no', 587)
					->setUsername('dragonevo1')
					->setPassword('sDf47nQ5');
				$this->_mailer = \Swift_Mailer::newInstance($transport);
			}
			return $this->_mailer;
		}

		protected function _sendGameReminder(Game $game, User $user, User $player)
		{
			$mailer = $this->_getMailer();
			$player_name = $player->getCharactername().' ('.$player->getUsername().')';
			$user_name = $user->getCharactername().' ('.$user->getUsername().')';
			$message = \Swift_Message::newInstance($player_name.' is waiting for you');
			$message->setFrom('support@dragonevo.com', 'The Dragon Evo team');
			$message->setTo($user->getEmail());
			$plain_content = str_replace(array('%username%', '%playername%', '%game_id%'), array($user_name, $player_name, $game->getId()), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'game_reminder.txt'));
			$message->setBody($plain_content, 'text/plain');
			$retval = $mailer->send($message);
		}

        protected function do_execute()
        {
            $this->cliEcho("Processing games!\n", 'white', 'bold');
			$games = \application\entities\tables\Games::getTable()->getCurrentMultiplayerGames();

			foreach ($games as $game) {
				if ($game->getCreatedAt() < time() - 21600 && \application\entities\tables\GameEvents::getTable()->getLatestEndPhaseEventByGame($game) < time() - 7200) {
					$this->_sendGameReminder($game, $game->getCurrentPlayer(), ($game->getCurrentPlayerId() == $game->getOpponentId()) ? $game->getPlayer() : $game->getOpponent());
				}
			}

			$this->cliEcho("Done!\n\n", 'white', 'bold');
        }

    }