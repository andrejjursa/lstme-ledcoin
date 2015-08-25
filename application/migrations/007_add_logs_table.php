<?php

class Migration_add_logs_table extends CI_Migration {

	public function up() {
		$this->db->query('CREATE TABLE IF NOT EXISTS `logs` (
			`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
			`created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
			`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
			`log_data` TEXT NOT NULL,
			PRIMARY KEY ( `id` )
		) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_slovak_ci;');
	}

	public function down() {
		$this->db->query('DROP TABLE IF EXISTS `logs`');
	}

}
