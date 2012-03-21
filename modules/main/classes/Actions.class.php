<?php

namespace application\modules\main;

use \caspar\core\Request;

/**
 * Actions for the main module
 */
class Actions extends \caspar\core\Actions
{

	/**
	 * Index page
	 *
	 * @param Request $request
	 */
	public function runIndex(Request $request)
	{
//		\application\entities\User::getB2DBTable()->create();
//		$user = new \application\entities\User();
//		$user->setUsername('zegenie');
//		$user->setIsAdmin();
//		$user->setPassword('passord');
//		$user->save();
	}

	public function runNotFound(Request $request)
	{
		$this->getResponse()->setHttpStatus(404);
	}

	/**
	 * Profile overview
	 *
	 * @param Request $request
	 */
	public function runProfile(Request $request)
	{
		$this->forward403unless($this->getUser()->isAuthenticated());
		$greetings = array('Hello', 'Hey there', 'Hola', 'Bonjour', 'Ohoy', 'Heya', 'Hey', 'Welcome', 'There you are');
		$user = $this->getUser();

		$this->intro = $greetings[array_rand($greetings)];
		$this->message = \caspar\core\Caspar::getMessageAndClear('profile_message');
		$this->error = \caspar\core\Caspar::getMessageAndClear('profile_error');
		if ($request->isPost()) {
			if ($request->getParameter('character_setup')) {
				switch ($request->getParameter('step')) {
					case 1:
						if (strlen(trim($request->getParameter('character_name'))) > 0) {
							$user->setCharacterName($request->getParameter('character_name'));
							$user->save();
						} else {
							$charactername_error = true;
						}
						break;
					case 2:
						$cards = Card::getStarterPack($request->getParameter('faction'));
						if (count($cards)) {
							foreach ($cards as $card) {
								$usercard = new UserCard();
								$usercard->setCard($card);
								$usercard->setUser(DEVO::getUser());
								$usercard->setLevel(1);
								$usercard->generateRandomDefenceMultiplier();
								$usercard->save();
							}
						}
						if ($user->hasCards()) {
							header('Location: deck.php');
							exit();
						}
						break;
				}
			} elseif ($request->getParameter('change_password')) {
				if (md5($request->getParameter('current_password')) == DEVO::getUser()->getPassword()) {
					if (strlen(trim($request->getParameter('new_password_1'))) > 5 && $request->getParameter('new_password_1') == $request->getParameter('new_password_2')) {
						DEVO::getUser()->setPassword($request->getParameter('new_password_1'));
						DEVO::getUser()->save();
						setcookie("devo_password", DEVO::getUser()->getPassword());
						$password_changed = true;
					} else {
						$pwd_error = 'Please type a new password twice, minimum 5 characters long';
					}
				} else {
					$pwd_error = 'Please type your current password';
				}
			}
		}
	}

	/**
	 * Invite email
	 *
	 * @param Request $request
	 */
	public function runInvite(Request $request)
	{
		$this->forward403unless($this->getUser()->isAuthenticated());
		$user = $this->getUser();

		if (filter_var($request->getParameter('invite_email'), FILTER_VALIDATE_EMAIL)) {
			$invite_code = $user->createInvite($request->getParameter('invite_email'));
			require_once CASPAR_LIB_PATH . 'swift/lib/swift_required.php';
			$message = Swift_Message::newInstance('Dragon Evo: The Card Game invitation');
			$message->setFrom('automailer@dragonevo.com', 'Dragon Evo Invite automailer');
			$message->setTo($request->getParameter('invite_email'));
			$plain_content = file_get_contents(CASPAR_APPLICATION_PATH . DS . 'templates' . DS . 'invitation_email.txt');
			$plain_content = str_replace(array('%code%', '%user%'), array($invite_code, $user->getCharacterName()), $plain_content);
			$message->setBody($plain_content, 'text/plain');
			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
			$retval = $mailer->send($message);
			\caspar\core\Caspar::setMessage('profile_message', 'Invitation sent successfully');
		} else {
			\caspar\core\Caspar::setMessage('profile_error', 'Invalid email address');
		}
		return $this->forward($this->getRouting()->generate('profile'));
	}

	/**
	 * Profile overview
	 *
	 * @param Request $request
	 */
	public function runLobby(Request $request)
	{

	}

	public function runGetBackdropPartial(Request $request)
	{
		if (!$request->isAjaxCall()) {
			return $this->return404($this->getI18n()->__('You need to enable javascript for Dragon Evo to work properly'));
		}
		try {
			$template_name = null;
			$options = array();
			switch ($request['key']) {
				case 'usercard':
					$template_name = 'main/usercard';
					if ($user_id = $request['user_id']) {
						$user = new User($user_id);
						$options['user'] = $user;
					}
					break;
				case 'login':
					$template_name = 'main/loginpopup';
					$options = $request->getParameters();
					$options['content'] = $this->getComponentHTML('main/login', array('section' => $request->getParameter('section', 'login')));
					$options['mandatory'] = false;
					break;
				case 'openid':
					$template_name = 'main/openid';
					break;
			}
			if ($template_name !== null) {
				return $this->renderJSON(array('content' => $this->getComponentHTML($template_name, $options)));
			}
		} catch (Exception $e) {
			$this->getResponse()->cleanBuffer();
			$this->getResponse()->setHttpStatus(400);
			return $this->renderJSON(array('error' => $this->getI18n()->__('An error occured: %error_message%', array('%error_message%' => $e->getMessage()))));
		}
		$this->getResponse()->cleanBuffer();
		$this->getResponse()->setHttpStatus(400);
		return $this->renderJSON(array('error' => $this->getI18n()->__('Invalid template or parameter')));
	}

	/**
	 * Do login (AJAX call)
	 *
	 * @param TBGRequest $request
	 */
	public function runDoLogin(Request $request)
	{
		$forward_url = $this->getRouting()->generate('home');
		if ($request->isPost()) {
			try {
				if ($request->hasParameter('csp_username') && $request->hasParameter('csp_password') && $request['csp_username'] != '' && $request['csp_password'] != '') {
					\caspar\core\Caspar::loadUser();
					if (!\caspar\core\Caspar::getUser()->isAuthenticated()) {
						throw new \Exception('Unknown username and / or password');
					}
					$forward_url = $request->getParameter('devo_referer', $this->getRouting()->generate('home'));
				}
				else {
					throw new \Exception('Please enter a username and password');
				}
			} catch (\Exception $e) {
				if ($request->isAjaxCall()) {
					$this->getResponse()->setHttpStatus(401);
					return $this->renderJSON(array("error" => $e->getMessage()));
				} else {
					$this->forward403($e->getMessage());
				}
			}
		} else {
			if ($request->isAjaxCall()) {
				$this->getResponse()->setHttpStatus(401);
				return $this->renderJSON(array("error" => 'Please enter a username and password'));
			} else {
				$this->forward403('Please enter a username and password');
			}
		}

		if ($request->isAjaxCall()) {
			return $this->renderJSON(array('forward' => $forward_url));
		} else {
			$this->forward($forward_url);
		}
	}

	public function runLogout(Request $request)
	{
		\caspar\core\Caspar::logout();
		$this->forward($this->getRouting()->generate('home'));
	}

}