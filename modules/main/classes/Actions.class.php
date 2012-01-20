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
//		$user = new \application\entities\User();
//		$user->setUsername('zegenie');
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