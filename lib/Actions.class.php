<?php

	namespace application\lib;

	use caspar\core\Request,
		application\entities\Game,
		application\entities\GameInvite,
		application\entities\tables\Games,
		application\entities\tables\Attacks,
		application\entities\tables\Cards,
		application\entities\User,
		application\entities\tables\GameInvites;

	class Actions extends \caspar\core\Actions
	{

		protected $_mailer = null;

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

		protected function _sendGameInvite(GameInvite $invite, User $user, User $player)
		{
			$mailer = $this->_getMailer();
			$message = \Swift_Message::newInstance('New game invitation from '.$player->getCharactername().' ('.$player->getUsername().')');
			$message->setFrom('support@dragonevo.com', 'The Dragon Evo team');
			$message->setTo($user->getEmail());
			$plain_content = str_replace(array('%username%', '%playername%', '%invite_id%'), array($user->getUsername(), $player->getUsername(), $invite->getId()), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'game_invite.txt'));
			$message->setBody($plain_content, 'text/plain');
			$retval = $mailer->send($message);
		}

		protected function _sendEmailGameInvite(User $user, $email, $invite_code)
		{
			$mailer = $this->_getMailer();
			$message = \Swift_Message::newInstance('Dragon Evo: The Card Game invitation');
			$message->setFrom('support@dragonevo.com', 'The Dragon Evo team');
			$message->setTo($email);
			$filename = 'invitation_game_email.txt';
			$plain_content = str_replace(array('%code%', '%user%'), array($invite_code, $user->getCharactername()), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . $filename));
			$message->setBody($plain_content, 'text/plain');
			$retval = $mailer->send($message);
		}

		protected function _sendGameTurnEmail(Game $game, User $user, User $player)
		{
			$mailer = $this->_getMailer();
			$message = \Swift_Message::newInstance($player->getCharactername().' ('.$player->getUsername().') just finished their turn!');
			$message->setFrom('support@dragonevo.com', 'The Dragon Evo team');
			$message->setTo($user->getEmail());
			$plain_content = str_replace(array('%username%', '%playername%', '%game_id%'), array($user->getUsername(), $player->getUsername(), $game->getId()), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'game_turn.txt'));
			$message->setBody($plain_content, 'text/plain');
			$retval = $mailer->send($message);
		}

	}
