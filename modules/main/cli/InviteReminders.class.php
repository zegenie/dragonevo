<?php

    namespace application\modules\main\cli;
    
    use caspar\core\Caspar,
		application\entities\User,
		application\entities\GameInvite;

    class InviteReminders extends \caspar\core\CliCommand
    {
		
		protected $_mailer = null;

        protected function _setup()
        {
            $this->_command_name = 'invite_reminders';
            $this->_description = 'Reminds all users about any outstanding invites';
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

		protected function _sendGameInviteReminder(GameInvite $invite, User $user, User $player)
		{
			$mailer = $this->_getMailer();
			$player_name = $player->getCharactername().' ('.$player->getUsername().')';
			$message = \Swift_Message::newInstance('Unanswered game invitation from '.$player_name);
			$message->setFrom('support@dragonevo.com', 'The Dragon Evo team');
			$message->setTo($user->getEmail());
			$plain_content = str_replace(array('%username%', '%playername%', '%invite_id%'), array($user->getUsername(), $player_name, $invite->getId()), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'game_invite_reminder.txt'));
			$message->setBody($plain_content, 'text/plain');
			$retval = $mailer->send($message);
		}

        protected function do_execute()
        {
            $this->cliEcho("Processing invites!\n", 'white', 'bold');
			$invites = \application\entities\tables\GameInvites::getTable()->getAll();

			foreach ($invites as $invite) {
				if ($invite->getGame() instanceof \application\entities\Game) {
					if ($invite->getGame()->getCreatedAt() < time() - 21600) {
						$this->_sendGameInviteReminder($invite, $invite->getToPlayer(), $invite->getFromPlayer());
					}
				} else {
					$invite->delete();
				}
			}

			$this->cliEcho("Done!\n\n", 'white', 'bold');
        }

    }