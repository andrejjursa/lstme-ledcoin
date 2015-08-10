<?php

	class Migration_add_new_tables_1 extends CI_Migration {

		public function up() {
			$this->db->query('CREATE TABLE IF NOT EXISTS `limits` (
				`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
				`created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
				`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
				`daily_limit` double NOT NULL ,
				`date` date NOT NULL ,
				PRIMARY KEY ( `id` ) ,
				UNIQUE KEY `unique_date` ( `date` ) COMMENT \'Datum musi byt unikatny!\'
				) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_slovak_ci;');
		}

		public function down() {
			$this->db->query('DROP TABLE IF EXISTS `limits`');
		}

	}
