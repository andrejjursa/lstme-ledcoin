<?php

	class Migration_alter_operations_3 extends CI_Migration {

		public function up() {
			$this->db->query('ALTER TABLE `operations` ADD `addition_type` ENUM( \'transfer\', \'mining\' ) NOT NULL DEFAULT \'transfer\' AFTER `subtraction_type`;');
		}

		public function down() {
			$this->db->query('ALTER TABLE `operations` DROP `addition_type`;');
		}

	}
