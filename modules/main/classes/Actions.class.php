<?php

namespace application\modules\main;

use \caspar\core\Request,
	\caspar\core\Caspar;

/**
 * Actions for the main module
 */
class Actions extends \application\lib\Actions
{

	/**
	 * Index page
	 *
	 * @param Request $request
	 */
	public function runIndex(Request $request)
	{
	}

	public function runNotFound(Request $request)
	{
		$this->getResponse()->setHttpStatus(404);
	}
	
	public function runSkills(Request $request)
	{
		$this->forward403unless($this->getUser()->isAuthenticated());
		$this->getResponse()->setFullscreen();
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
		if ($request->isPost()) {
			$user = $this->getUser();
			if ($request->getParameter('character_setup')) {
				switch ($request->getParameter('step')) {
					case 1:
						if (strlen(trim($request->getParameter('character_name'))) == 0) {
							$this->getResponse()->setHttpStatus(400);
							return $this->renderJSON(array('error' => 'You need to pick a character name'));
						} elseif (!$request->getParameter('race') || $request->getParameter('race') > 4) {
							$this->getResponse()->setHttpStatus(400);
							return $this->renderJSON(array('error' => 'This is not a valid race'));
						} elseif (!$request->getParameter('avatar') || $request->getParameter('avatar') > 13) {
							$this->getResponse()->setHttpStatus(400);
							return $this->renderJSON(array('error' => 'This is not a valid avatar'));
						} else {
							$user->setCharacterName($request->getParameter('character_name'));
							$user->setRace($request->getParameter('race'));
							$user->setAvatar("avatar_".$request->getParameter('avatar').".png");
							$user->save();
							return $this->renderJSON(array('character_setup' => 'step_1_ok'));
						}
						break;
					case 2:
						if (!$user->hasCards()) {
							$this->getUser()->generateStarterPack($request->getParameter('faction'));
						}
						return $this->renderJSON(array('character_setup' => 'step_2_ok'));
						break;
				}
			}
		}
		$this->getResponse()->setHttpStatus(400);
		return $this->renderJSON(array('error' => 'Invalid request'));
	}

	/**
	 * Profile overview
	 *
	 * @param Request $request
	 */
	public function runPlay(Request $request)
	{
		if (!$this->getUser()->isAuthenticated()) {
			return $this->forward($this->getRouting()->generate('home'));
		}
		if ($this->getUser()->getLastVersion() != $this->getResponse()->getVersion()) {
			$this->changelog = true;
		} else {
			$this->changelog = false;
		}
		$this->getResponse()->setFullscreen();
	}

	/**
	 * Cards overview
	 *
	 * @param Request $request
	 */
	public function runCards(Request $request)
	{
		$this->forward403unless($this->getUser()->isAuthenticated());
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
		$this->cards = array(
			'rutai' => \application\entities\tables\CreatureCards::getTable()->selectById(4),
			'resistance' => \application\entities\tables\CreatureCards::getTable()->selectById(8),
			'neutrals' => \application\entities\tables\CreatureCards::getTable()->selectById(12)
			);
	}

	/**
	 * Changelog page
	 *
	 * @param Request $request
	 */
	public function runChangelog(Request $request)
	{
	}

	/**
	 * "How to play" page
	 *
	 * @param Request $request
	 */
	public function runHowtoplay(Request $request)
	{
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
				case 'editprofile':
					$template_name = 'main/profileedit';
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
				case 'tellable_card_reward':
					$template_name = 'admin/addcardreward';
					$options['tellable_type'] = $request['tellable_type'];
					$options['tellable_id'] = $request['tellable_id'];
					break;
				case 'invitefriend':
					$template_name = 'main/invitefriend';
					break;
				case 'tellable_card_opponent':
					$template_name = 'admin/addcardopponent';
					$options['tellable_type'] = $request['tellable_type'];
					$options['tellable_id'] = $request['tellable_id'];
					break;
				case 'tellable_coordinates':
					$template_name = 'admin/tellablecoordinates';
					$options['tellable_type'] = $request['tellable_type'];
					$options['tellable_id'] = $request['tellable_id'];
					$options['parent_id'] = $request['parent_id'];
					$options['parent_type'] = $request['parent_type'];
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

	public function runForgot(Request $request)
	{
		if ($request->isPost()) {
			$userinfo = trim($request['userinfo']);
			$users = ($userinfo) ? \application\entities\tables\Users::getTable()->findByInfo($userinfo) : array();
			if (count($users) == 1) {
				$user = array_shift($users);
				$code = $user->getOrGeneratePasswordRestoreKey();
				$user->save();
				$mailer = $this->_getMailer();
				$message = \Swift_Message::newInstance('Dragon Evo: The Card Game account restoration');
				$message->setFrom('support@dragonevo.com', 'The Dragon Evo team');
				$message->setTo($user->getEmail());
				$plain_content = str_replace(array('%username%', '%code%'), array($user->getUsername(), $code), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'account_restore.txt'));
				$message->setBody($plain_content, 'text/plain');
				$retval = $mailer->send($message);
				$this->sent_details = true;
				if ($request->isAjaxCall()) {
					return $this->renderJSON(array('message' => 'Password reset email sent'));
				}
			} else {
				$this->error = 'Could not find a user with these details';
				if ($request->isAjaxCall()) {
					$this->getResponse()->setHttpStatus(400);
					return $this->renderJSON(array('error' => $this->error));
				}
			}
		}
	}

	public function runRestore(Request $request)
	{
		$this->username = trim($request['username']);
		$this->code = trim($request['code']);
		$user = \application\entities\tables\Users::getTable()->getByUsername($this->username);
		$valid_code = false;
		try {
			if (!$user instanceof application\entities\User) {
				if ($this->code == $user->getOrGeneratePasswordRestoreKey()) {
					$valid_code = true;
				}
				if ($request->isPost() && $valid_code) {
					if (trim($request['desired_password_1']) && strlen(trim($request['desired_password_1'])) >= 8 && $request['desired_password_1'] == $request['desired_password_2']) {
						$user->setPassword($request['desired_password_1']);
						$user->save();
						$mailer = $this->_getMailer();
						$message = \Swift_Message::newInstance('Dragon Evo: The Card Game new password saved');
						$message->setFrom('support@dragonevo.com', 'The Dragon Evo team');
						$message->setTo($user->getEmail());
						$plain_content = str_replace('%username%', $user->getUsername(), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'account_restored.txt'));
						$message->setBody($plain_content, 'text/plain');
						$retval = $mailer->send($message);
						$this->password_saved = true;
					} else {
						throw new \Exception('Please enter a password (with at least 8 characters) twice');
					}
				}
			}
		} catch (\Exception $e) {
			$this->error = 'Could not find a user with these details';
		}
		$this->valid_code = $valid_code;
	}

	public function runJoin(Request $request)
	{
		$valid_code = true; // \application\entities\tables\Users::getTable()->validateCode($request['code']);
		$this->valid_code = $valid_code;
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
						$mailer = $this->_getMailer();
						$message = \Swift_Message::newInstance('Dragon Evo: The Card Game account created');
						$message->setFrom('support@dragonevo.com', 'The Dragon Evo team');
						$message->setTo($request->getParameter('email'));
						$plain_content = str_replace(array('%username%', '%password%'), array($user->getUsername(), $request['desired_password_1']), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'account_created.txt'));
						$message->setBody($plain_content, 'text/plain');
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
					$this->forward($this->getRouting()->generate('play'));
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