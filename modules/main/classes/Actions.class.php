<?php

namespace application\modules\main;

use \caspar\core\Request,
	\caspar\core\Caspar;

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
//		$user->setPassword('pooWZLX1');
//		$user->save();
//		$user = new \application\entities\User();
//		$user->setUsername('thondal');
//		$user->setIsAdmin();
//		$user->setPassword('elskerhelena88');
//		$user->save();
	}

	public function runNotFound(Request $request)
	{
		$this->getResponse()->setHttpStatus(404);
	}
	
	public function runSkills(Request $request)
	{
		$this->available_skills = \application\entities\tables\Skills::getTable()->getSkillsByRace($this->getUser()->getRace());
		$this->user_skills = $this->getUser()->getSkills();
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
		$this->intro = $greetings[array_rand($greetings)];
		$user = $this->getUser();

		$this->message = \caspar\core\Caspar::getMessageAndClear('profile_message');
		$this->error = \caspar\core\Caspar::getMessageAndClear('profile_error');
		$this->games_played = 0;
		$this->banner_message = Caspar::getMessageAndClear('profile_banner_message');
		if ($request->isPost()) {
			if ($request->getParameter('character_setup')) {
				switch ($request->getParameter('step')) {
					case 1:
						if (strlen(trim($request->getParameter('character_name'))) == 0) {
							$charactername_error = true;
						} elseif (!$request->getParameter('race') || $request->getParameter('race') > 4) {
							$race_error = true;
						} else {
							$user->setCharacterName($request->getParameter('character_name'));
							$user->setRace($request->getParameter('race'));
							$user->save();
							$this->forward($this->getRouting()->generate('profile'));
						}
						break;
					case 2:
						if (!$user->hasCards()) {
							$this->getUser()->generateStarterPack($request->getParameter('faction'));
						}
						Caspar::setMessage('profile_banner_message', 'starter_pack_generated');
						$this->forward($this->getRouting()->generate('profile'));
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
		} else {
			$this->games = $this->getUser()->getGames();
			$this->games_played = \application\entities\tables\Games::getTable()->getNumberOfGamesByUserId($this->getUser()->getId());
			$this->games_won = \application\entities\tables\Games::getTable()->getNumberOfGamesWonByUserId($this->getUser()->getId());
			$this->pct_won = ($this->games_played > 0) ? round(($this->games_won / $this->games_played) * 100, 1) : 0;
		}
	}

	/**
	 * Profile overview
	 *
	 * @param Request $request
	 */
	public function runPlay(Request $request)
	{
		$this->getResponse()->setFullscreen();
	}

	/**
	 * Cards overview
	 *
	 * @param Request $request
	 */
	public function runCards(Request $request)
	{
		$this->cards = $this->getUser()->getCards();
	}

	/**
	 * "Unavailable" page
	 *
	 * @param Request $request
	 */
	public function runUnavailable(Request $request)
	{

	}

	/**
	 * FAQ page
	 *
	 * @param Request $request
	 */
	public function runFaq(Request $request)
	{
		$this->getResponse()->setFullscreen();
	}

	/**
	 * News item page
	 *
	 * @param Request $request
	 */
	public function runNews(Request $request)
	{
		$this->news = null;
		try {
			$this->news = new \application\entities\News($request['id']);
		} catch (Exception $e) {}
	}

	/**
	 * Media page / gallery
	 *
	 * @param Request $request
	 */
	public function runMedia(Request $request)
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
				case 'attack':
					$template_name = 'admin/attack';
					if ($request['card_id']) {
						$card = new \application\entities\CreatureCard($request['card_id']);
						$attack = new \application\entities\Attack();
						$attack->setCard($card);
					} else {
						$attack = new \application\entities\Attack($request['attack_id']);
						$card = $attack->getCard();
					}
					$options['attack'] = $attack;
					$options['card'] = $card;
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

	public function runJoin(Request $request)
	{
		$valid_code = \application\entities\tables\Users::getTable()->validateCode($request['code']);
		$this->valid_code = $valid_code;
		$this->code = $request['code'];
		$this->registered = false;
		if ($valid_code && $request->isPost()) {
			if (\application\entities\tables\Users::getTable()->validateUsername($request['desired_username'])) {
				if (filter_var($request->getParameter('email'), FILTER_VALIDATE_EMAIL)) {
					if (trim($request['desired_password_1']) && strlen(trim($request['desired_password_1'])) >= 8 && $request['desired_password_1'] == $request['desired_password_2']) {
						$user = new \application\entities\User();
						$user->setUsername(trim($request['desired_username']));
						$user->setPassword($request['desired_password_1']);
						$user->setEmail($request['email']);
						$user->setIsAdmin(false);
						$user->save();
						require_once CASPAR_APPLICATION_PATH . 'swift/lib/swift_required.php';
						$message = \Swift_Message::newInstance('Dragon Evo: The Card Game account created');
						$message->setFrom('support@dragonevo.com', 'The Dragon Evo team');
						$message->setTo($request->getParameter('email'));
						$plain_content = str_replace(array('%username%', '%password%'), array($user->getUsername(), $request['desired_password_1']), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'account_created.txt'));
						$message->setBody($plain_content, 'text/plain');
						$transport = \Swift_SmtpTransport::newInstance('smtp.domeneshop.no', 587)
							->setUsername('dragonevo1')
							->setPassword('sDf47nQ5');
						$mailer = \Swift_Mailer::newInstance($transport);
						$retval = $mailer->send($message);
						$this->registered = true;
					} else {
						$this->error = 'Please enter a password (with at least 8 characters) twice';
					}
				} else {
					$this->error = 'Please enter a valid email address';
				}
			} else {
				$this->error = 'This username is invalid or already in use';
			}
		}
	}
	
	/**
	 * Do login (AJAX call)
	 *
	 * @param TBGRequest $request
	 */
	public function runLogin(Request $request)
	{
		if ($request->isPost()) {
//			$forward_url = $this->getRouting()->generate('home');
			try {
				if ($request->hasParameter('csp_username') && $request->hasParameter('csp_password') && $request['csp_username'] != '' && $request['csp_password'] != '') {
					if (!\caspar\core\Caspar::getUser()->isAuthenticated()) {
						throw new \Exception('Unknown username and / or password');
					}
					$this->forward($this->getRouting()->generate('home'));
				}
				else {
					throw new \Exception('Please enter a username and password');
				}
			} catch (\Exception $e) {
				$this->error = $e->getMessage();
			}
		}
	}

	public function runLogout(Request $request)
	{
		$this->getUser()->logout();
		\caspar\core\Caspar::logout();
		$this->forward($this->getRouting()->generate('home'));
	}

}