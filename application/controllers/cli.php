<?php

	/*
	 * To change this template, choose Tools | Templates
	 * and open the template in the editor.
	 */

	/**
	 * Description of cli
	 *
	 * @author Andrej
	 */
	class Cli extends CI_Controller {

		public function __construct() {
			parent::__construct();

			if (!$this->input->is_cli_request()) {
				die();
			}
		}

		public function __destruct() {
			echo "\n";
		}

		public function index() {
			echo "Vitajte v konfiguracii aplikacie LEDCOIN.\n\n";
			echo "Prosim vyberte si z nasledujucej ponuky:\n\n";
			echo "(1) - databazove migracie\n";
			echo "(2) - vytvorenie administratora\n";
			echo "(3) - zjednotiť konfiguráciu\n";
            echo "(4) - zmeniť prostredie aplikácie\n";
			echo "(5) - koniec\n";
			echo "\n";
			do {
				$choice = $this->_get_cli_user_input('Volba');
			} while (!preg_match('/^[0-9]+$/', $choice) || ((int)$choice < 1 || (int)$choice > 5));

			switch ((int)$choice) {
				case 1:
					$this->migration();
					break;
				case 2:
					$this->admin();
					break;
				case 3:
					$this->merge();
					break;
                case 4:
                    $this->set_environment();
                    break;
			}
		}

		public function migration() {
		    $this->load->database();
            $this->load->library('datamapper');
			$this->load->library('migration');

			echo "Ktoru migraciu chcete spustit?\n(P) - poslednu\n(cislo) - cislo migracie\n\n";
			do {
				$choice = $this->_get_cli_user_input('Volba');
			} while (strtolower($choice) != 'p' && !preg_match('/^[0-9]+$/', $choice));

			if (strtolower($choice) == 'p') {
				$this->db->query('SET FOREIGN_KEY_CHECKS=0;');
				$this->db->query('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');
				if ($this->migration->latest() === FALSE) {
					$this->db->query('SET FOREIGN_KEY_CHECKS=1;');
					echo $this->migration->error_string();
				} else {
					$this->db->query('SET FOREIGN_KEY_CHECKS=1;');
					$this->_clear_production_cache();
					echo 'Migracia uspesna.';
				}
			} else {
				if ($this->migration->version((int)$choice) === FALSE) {
					$this->db->query('SET FOREIGN_KEY_CHECKS=1;');
					echo $this->migration->error_string();
				} else {
					$this->db->query('SET FOREIGN_KEY_CHECKS=1;');
					$this->_clear_production_cache();
					echo 'Migracia uspesna.';
				}
			}
		}

		public function admin() {
            $this->load->database();
            $this->load->library('datamapper');

			echo "Vytvorenie noveho administratora\n\n";
			$name           = $this->_get_cli_user_input('Meno');
			$surname        = $this->_get_cli_user_input('Priezvisko');
			$login          = $this->_get_cli_user_input('Prihlasovacie meno');
			$password       = $this->_get_cli_user_input_silently('Heslo');
			$password_check = $this->_get_cli_user_input_silently('Heslo (kontrola)');
			$organisation   = $this->_get_cli_user_input('Organizacia');

			if (trim($name) == '') {
				echo "\n\nMeno je prazdne ...";

				return;
			}

			if (trim($surname) == '') {
				echo "\n\nPriezvisko je prazdne ...";

				return;
			}

			if (trim($login) == '') {
				echo "\n\nPrihlasovacie meno je prazdne ...";

				return;
			}

			if ($password != $password_check) {
				echo "\n\nHesla sa nezhoduju ...";

				return;
			}

			if (mb_strlen($password) < 6) {
				echo "\n\nHeslo musi mat aspon 6 znakov ...";

				return;
			}

			if (mb_strlen($password) > 20) {
				echo "\n\nHeslo moze mat najviac 20 znakov ...";

				return;
			}

			if (trim($organisation) == '') {
				echo "\n\nOrganizacia je prazdna ...";

				return;
			}

			$person               = new Person();
			$person->name         = trim($name);
			$person->surname      = trim($surname);
			$person->login        = trim($login);
			$person->password     = sha1($password);
			$person->admin        = 1;
			$person->enabled      = 1;
			$person->organisation = trim($organisation);
			if ($person->save()) {
				echo "\n\nOsoba vytvorena.";
			} else {
				echo "\n\nOsoba nebola vytvorena.";
			}
		}

		public function merge() {
			$this->load->library('configurator');
			echo $this->configurator->merge_config_files('config') ? "Config ... OK\n" : "Config ... Chyba\n";
			echo $this->configurator->merge_config_files('application') ? "Application ... OK\n" : "Application ... Chyba\n";
            $original_database_file = APPPATH . 'config/database.php';
            $target_database_file = APPPATH . 'config/' . ENVIRONMENT . '/database.php';
            if (!file_exists($target_database_file) && file_exists($original_database_file)) {
                echo copy($original_database_file, $target_database_file) ? "Database ... OK\n" : "Database ... Chyba\n";
            }
		}

		public function set_environment() {
		    echo 'Súčasné prostredie aplikácie je nastavené na: ' . ENVIRONMENT . PHP_EOL . PHP_EOL;
            echo '(1) production' . PHP_EOL;
            echo '(2) development' . PHP_EOL;
            echo '(3) testing' . PHP_EOL;
            echo '(4) koniec' . PHP_EOL;
            echo PHP_EOL;

            do {
                $choice = $this->_get_cli_user_input('Zvoľte nové prostredie');
            } while (!preg_match('/^[0-9]+$/', $choice) || ((int)$choice < 1 || (int)$choice > 4));

            switch ($choice) {
                case 1: $this->_set_environment('production'); break;
                case 2: $this->_set_environment('development'); break;
                case 3: $this->_set_environment('testing'); break;
            }
        }

        private function _set_environment($environment) {
            $content = '<?php ' . PHP_EOL . 'define(\'ENVIRONMENT\', \'' . $environment . '\');' . PHP_EOL;
            $file = rtrim(APPPATH, '\\/') . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'environment.php';

            try {
                $f = fopen($file, 'w');
                fwrite($f, $content);
                fclose($f);
                echo PHP_EOL . 'Prostredie prepnuté na "' . $environment . '". Je treba opäť zjednotiť konfiguráciu a vykonať úpravy.' . PHP_EOL;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

		/**
		 * Displays standard input prompt with message and return answer.
		 *
		 * @param string $msg message.
		 *
		 * @return string answer.
		 */
		private function _get_cli_user_input($msg) {
			fwrite(STDOUT, "$msg: ");
			$varin = trim(fgets(STDIN));

			return $varin;
		}

		private function _get_cli_user_input_silently($prompt) {
			if (preg_match('/^win/i', PHP_OS)) {
				$vbscript = sys_get_temp_dir() . 'prompt_password.vbs';
				file_put_contents($vbscript, 'wscript.echo(InputBox("' . addslashes("$prompt: ") . '", "", "password here"))');
				$command  = "cscript //nologo " . escapeshellarg($vbscript);
				$password = rtrim(shell_exec($command));
				unlink($vbscript);

				return $password;
			} else {
				$command = "/usr/bin/env bash -c 'echo OK'";
				if (rtrim(shell_exec($command)) !== 'OK') {
					trigger_error("Can't invoke bash");

					return '';
				}
				$command  = "/usr/bin/env bash -c 'read -s -p \"" . addslashes("$prompt: ") . "\" mypassword && echo \$mypassword'";
				$password = rtrim(shell_exec($command));
				echo "\n";

				return $password;
			}
		}

		/**
		 * Clear production cache for DataMapper if it is enabled.
		 * @return integer number of deleted cache files.
		 */
		private function _clear_production_cache() {
			$count = 0;
			$this->config->load('datamapper', TRUE);
			$production_cache = $this->config->item('production_cache', 'datamapper');
			if (!empty($production_cache) && file_exists(APPPATH . $production_cache) && is_dir(APPPATH . $production_cache)) {
				echo "\nVymazava sa produkcna cache pre DataMapper ...\n\n";
				$production_cache = rtrim(APPPATH . $production_cache, '/\\') . DIRECTORY_SEPARATOR;
				$dir_content      = scandir($production_cache);
				foreach ($dir_content as $item) {
					if (is_file($production_cache . $item) && substr($item, -4) == '.php') {
						if (@unlink($production_cache . $item)) {
							$count++;
						}
					}
				}
			}

			return $count;
		}

	}

