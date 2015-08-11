<?php

	class Migration_alter_tables_1 extends CI_Migration {

		public function up() {
			// Groups
			$this->db->query('ALTER TABLE `groups` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			// Limits
			$this->db->query('ALTER TABLE `limits` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			// Operations
			$this->db->query('ALTER TABLE `operations` CHANGE `amount` `amount` DOUBLE NOT NULL DEFAULT \'0\';');
			$this->db->query('ALTER TABLE `operations` CHANGE `admin_id` `admin_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `operations` CHANGE `workplace_id` `workplace_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `operations` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			// Persons
			$this->db->query('ALTER TABLE `persons` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			$this->db->query('ALTER TABLE `persons` CHANGE `group_id` `group_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;');
			// Products
			$this->db->query('ALTER TABLE `products` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			$this->db->query('ALTER TABLE `products` CHANGE `price` `price` DOUBLE NOT NULL DEFAULT \'0\';');
			// Product_quantities
			$this->db->query('ALTER TABLE `product_quantities` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			$this->db->query('ALTER TABLE `product_quantities` CHANGE `product_id` `product_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `product_quantities` CHANGE `operation_id` `operation_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `product_quantities` CHANGE `price` `price` DOUBLE NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `product_quantities` ADD `multiplier` DOUBLE NULL DEFAULT NULL AFTER `price`;');
			// Services
			$this->db->query('ALTER TABLE `services` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			$this->db->query('ALTER TABLE `services` CHANGE `price` `price` DOUBLE NOT NULL DEFAULT \'0\';');
			// Service_usages
			$this->db->query('ALTER TABLE `service_usages` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			$this->db->query('ALTER TABLE `service_usages` CHANGE `operation_id` `operation_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `service_usages` CHANGE `service_id` `service_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `service_usages` CHANGE `price` `price` DOUBLE NOT NULL;');
			$this->db->query('ALTER TABLE `service_usages` ADD `multiplier` DOUBLE NOT NULL DEFAULT \'1.0\' AFTER `price`;');
			// Workplaces
			$this->db->query('ALTER TABLE `workplaces` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
		}

		public function down() {
			// Groups
			$this->db->query('ALTER TABLE `groups` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			// Limits
			$this->db->query('ALTER TABLE `limits` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			// Operations
			$this->db->query('ALTER TABLE `operations` CHANGE `amount` `amount` INT( 11 ) NOT NULL DEFAULT \'0\';');
			$this->db->query('ALTER TABLE `operations` CHANGE `admin_id` `admin_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `operations` CHANGE `workplace_id` `workplace_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `operations` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			// Persons
			$this->db->query('ALTER TABLE `persons` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			$this->db->query('ALTER TABLE `persons` CHANGE `group_id` `group_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL;');
			// Products
			$this->db->query('ALTER TABLE `products` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			$this->db->query('ALTER TABLE `products` CHANGE `price` `price` INT( 11 ) NOT NULL;');
			// Product_quantities
			$this->db->query('ALTER TABLE `product_quantities` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			$this->db->query('ALTER TABLE `product_quantities` CHANGE `product_id` `product_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `product_quantities` CHANGE `operation_id` `operation_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `product_quantities` CHANGE `price` `price` INT( 11 ) NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `product_quantities` DROP `multiplier`;');
			// Services
			$this->db->query('ALTER TABLE `services` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			$this->db->query('ALTER TABLE `services` CHANGE `price` `price` INT( 11 ) NOT NULL;');
			// Service_usages
			$this->db->query('ALTER TABLE `service_usages` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
			$this->db->query('ALTER TABLE `service_usages` CHANGE `operation_id` `operation_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `service_usages` CHANGE `service_id` `service_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL;');
			$this->db->query('ALTER TABLE `service_usages` CHANGE `price` `price` INT( 11 ) NOT NULL;');
			$this->db->query('ALTER TABLE `service_usages` DROP `multiplier`;');
			// Workplaces
			$this->db->query('ALTER TABLE `workplaces` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;');
		}

	}