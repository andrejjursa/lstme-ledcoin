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
		    $options = array(
		        1 => array(
		            'desc' => 'zmeniť prostredie aplikácie',
                    'cmd' => 'set_environment',
                ),
                2 => array(
                    'desc' => 'zjednotiť konfiguráciu',
                    'cmd' => 'merge',
                ),
                3 => array(
                    'desc' => 'konfigurácia pripojenia k databáze',
                    'cmd' => 'configure_database',
                ),
                4 => array(
                    'desc' => 'databazové migrácie',
                    'cmd' => 'migration',
                ),
                5 => array(
                    'desc' => 'vytvorenie administrátora',
                    'cmd' => 'admin',
                ),
                6 => array(
                    'desc' => 'koniec',
                    'cmd' => false
                ),
            );

			echo "Vitajte v konfiguracii aplikacie LEDCOIN.\n\n";
			echo "Prosim vyberte si z nasledujucej ponuky:\n\n";
            for ($i=1;$i<=count($options);$i++) {
                echo $i . ' - ' . $options[$i]['desc'] . PHP_EOL;
            }
			echo "\n";
			do {
				$choice = $this->_get_cli_user_input('Volba');
			} while (!preg_match('/^[0-9]+$/', $choice) || !array_key_exists((int)$choice, $options));

            $cmd = $options[(int)$choice]['cmd'];

            if ($cmd !== false) {
                call_user_func(array($this, $cmd));
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

        public function configure_database() {
            $file = APPPATH . 'config/' . ENVIRONMENT . '/database.php';

            if (!file_exists($file)) {
                echo 'Konfiguračný súbor databázy sa nenašiel, najskôr zjednotte konfiguráciu.' . PHP_EOL;
                return;
            }

            $db = array();
            $active_group = 'default';

            include $file;

            $bools = array('pconnect', 'db_debug', 'cache_on', 'autoinit', 'stricton');

            if (isset($db) && isset($active_group) && is_array($db) && isset($db[$active_group]) && is_array($db[$active_group]) && !empty($db[$active_group])) {
                $exit = false;
                do {
                    echo "Nastavenie databázovej konfigurácie\n\n";

                    foreach ($db[$active_group] as $item => $current_value) {
                        if (in_array($item, $bools)) {
                            do {
                                $new_value = $this->_get_cli_user_input('Nastavenie ' . $item . ' [' . ($current_value ? 'TRUE' : 'FALSE') . ']');
                            } while ($new_value !== '' && strtoupper($new_value) !== 'TRUE' && strtoupper($new_value) !== 'FALSE');
                        } else {
                            $new_value = $this->_get_cli_user_input('Nastavenie ' . $item . ' [' . $current_value . ']');
                        }
                        if (trim($new_value) !== '') {
                            if (in_array($item, $bools)) {
                                $db[$active_group][$item] = strtoupper($new_value) === 'TRUE' ? TRUE : FALSE;
                            } else {
                                $db[$active_group][$item] = $new_value;
                            }
                        }
                    }

                    echo "\nNová konfigurácia:\n\n";

                    foreach ($db[$active_group] as $item => $value) {
                        if (in_array($item, $bools)) {
                            echo "$item: " . ($value ? 'TRUE' : 'FALSE') . "\n";
                        } else {
                            echo "$item: $value\n";
                        }
                    }

                    echo PHP_EOL;

                    do {
                        $choice = strtolower($this->_get_cli_user_input('Chcete uložiť túto konfiguráciu? [ano/nie]'));
                    } while ($choice !== 'ano' && $choice !== 'nie');

                    if ($choice == 'ano') {
                        if ($this->_save_db_config($file, $db, $active_group)) {
                            echo PHP_EOL . 'Zmeny boli úspešne uložené.' . PHP_EOL;
                        }
                        $exit = true;
                    } else {
                        echo PHP_EOL . 'Zmeny nebudú uložené.' . PHP_EOL . PHP_EOL;
                        do {
                            $exit_choice = strtolower($this->_get_cli_user_input('Chcete zopakovať zadávanie konfiguračných hodnôt? [ano/nie]'));
                        } while($exit_choice !== 'ano' && $exit_choice !== 'nie');

                        if ($exit_choice == 'nie') { $exit = true; } else { echo PHP_EOL; }
                    }
                } while ($exit == false);
            } else {
                echo "Chyba: Konfiguračný súbor nemá správny formát!\n";
            }

        }

        private function _save_db_config($file, $db, $active_group) {
            $content = <<<EOC
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
|				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The \$active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The \$active_record variables lets you determine whether or not to load
| the active record class
*/
EOC;

            $content .= PHP_EOL . PHP_EOL;
            $content .= '$active_group = ' . var_export($active_group, true) . ';' . PHP_EOL;
            $content .= '$active_record = TRUE;' . PHP_EOL . PHP_EOL;
            $content .= '$db = ' . var_export($db, true) . ';' . PHP_EOL . PHP_EOL . PHP_EOL;
            $content .= <<<EOC
            
/* End of file database.php */
/* Location: $file */
EOC;

            try {
                $f = fopen($file, 'w');
                fwrite($f, $content);
                fclose($f);
                return true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
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

