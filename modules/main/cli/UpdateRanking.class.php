<?php

    namespace application\modules\main\cli;
    
    use caspar\core\Caspar;

    class UpdateRanking extends \caspar\core\CliCommand
    {

        protected function _setup()
        {
            $this->_command_name = 'update_ranking';
            $this->_description = 'Updates all users with the correct singleplayer and multiplayer ranking, according to their SP and MP ranking points';
			$this->addOptionalArgument('verbose', 'Whether to output the ranking');
        }

        protected function do_execute()
        {
            $this->cliEcho("Processing ranking!\n", 'white', 'bold');
			$users = \application\entities\tables\Users::getTable()->updateRanking();

			if ($this->getProvidedArgument('verbose') != '') {
				$this->cliEcho("Done!\n\n");
				$this->cliEcho("Singleplayer ranking:\n", 'green', 'bold');
				foreach ($users['sp_users'] as $user => $ranking) {
					$this->cliEcho("{$ranking}: {$user}\n");
				}
				$this->cliEcho("\n");

				$this->cliEcho("Multiplayer ranking:\n", 'green', 'bold');
				foreach ($users['mp_users'] as $user => $ranking) {
					$this->cliEcho("{$ranking}: {$user}\n");
				}
			}

			$this->cliEcho("Done!\n\n", 'white', 'bold');
        }

    }