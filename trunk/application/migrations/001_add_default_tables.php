<?php

class Migration_add_default_tables extends CI_Migration {
    
    public function up() {
        $this->db->query('CREATE TABLE IF NOT EXISTS `ci_sessions` (
                            `session_id` varchar(40) COLLATE utf8_slovak_ci NOT NULL DEFAULT \'0\',
                            `ip_address` varchar(45) COLLATE utf8_slovak_ci NOT NULL DEFAULT \'0\',
                            `user_agent` varchar(120) COLLATE utf8_slovak_ci NOT NULL,
                            `last_activity` int(10) unsigned NOT NULL DEFAULT \'0\',
                            `user_data` text COLLATE utf8_slovak_ci NOT NULL,
                            PRIMARY KEY (`session_id`),
                            KEY `last_activity_idx` (`last_activity`)
                          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;');
        
        $this->db->query('CREATE TABLE IF NOT EXISTS `groups` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                            `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `title` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
                            PRIMARY KEY (`id`)
                          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;');
        
        $this->db->query('CREATE TABLE IF NOT EXISTS `operations` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                            `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `person_id` int(11) unsigned DEFAULT NULL,
                            `admin_id` int(10) unsigned DEFAULT NULL,
                            `workplace_id` int(10) unsigned DEFAULT NULL,
                            `time` int(11) NOT NULL DEFAULT \'0\',
                            `type` enum(\'addition\',\'subtraction\') COLLATE utf8_slovak_ci NOT NULL,
                            `comment` varchar(255) COLLATE utf8_slovak_ci DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            KEY `person_id` (`person_id`),
                            KEY `admin_id` (`admin_id`),
                            KEY `workplace_id` (`workplace_id`)
                          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;');
        
        $this->db->query('CREATE TABLE IF NOT EXISTS `persons` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                            `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `name` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
                            `surname` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
                            `login` varchar(32) COLLATE utf8_slovak_ci NOT NULL,
                            `enabled` int(1) NOT NULL DEFAULT \'1\',
                            `password` varchar(40) COLLATE utf8_slovak_ci NOT NULL,
                            `group_id` int(10) unsigned DEFAULT NULL,
                            `admin` int(1) NOT NULL DEFAULT \'0\',
                            `organisation` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
                            PRIMARY KEY (`id`),
                            UNIQUE KEY `login` (`login`),
                            KEY `group_id` (`group_id`)
                          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;');
        
        $this->db->query('CREATE TABLE IF NOT EXISTS `products` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                            `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `title` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
                            `price` int(11) NOT NULL,
                            PRIMARY KEY (`id`)
                          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;');
        
        $this->db->query('CREATE TABLE IF NOT EXISTS `product_quantities` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                            `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `product_id` int(10) unsigned DEFAULT NULL,
                            `operation_id` int(10) unsigned DEFAULT NULL,
                            `quantity` int(11) NOT NULL,
                            `price` int(11) DEFAULT NULL,
                            `type` enum(\'addition\',\'subtraction\') COLLATE utf8_slovak_ci NOT NULL,
                            PRIMARY KEY (`id`),
                            KEY `product_id` (`product_id`),
                            KEY `operation_id` (`operation_id`)
                          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;');
        
        $this->db->query('CREATE TABLE IF NOT EXISTS `services` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                            `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `title` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
                            `price` int(11) NOT NULL,
                            PRIMARY KEY (`id`)
                          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;');
        
        $this->db->query('CREATE TABLE IF NOT EXISTS `service_usages` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                            `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `operation_id` int(10) unsigned DEFAULT NULL,
                            `service_id` int(10) unsigned DEFAULT NULL,
                            `quantity` int(11) NOT NULL,
                            `price` int(11) NOT NULL,
                            PRIMARY KEY (`id`),
                            KEY `service_id` (`service_id`),
                            KEY `operation_id` (`operation_id`)
                          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;');
        
        $this->db->query('CREATE TABLE IF NOT EXISTS `workplaces` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
                            `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `title` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
                            PRIMARY KEY (`id`)
                          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;');
        
        $this->db->query('ALTER TABLE `operations`
                            ADD CONSTRAINT `workplace_id_constr` FOREIGN KEY (`workplace_id`) REFERENCES `workplaces` (`id`) ON UPDATE CASCADE,
                            ADD CONSTRAINT `admin_id_constr` FOREIGN KEY (`admin_id`) REFERENCES `persons` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                            ADD CONSTRAINT `person_id_constr` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
        
        $this->db->query('ALTER TABLE `persons`
                            ADD CONSTRAINT `group_id_constr` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON UPDATE CASCADE;');
        
        $this->db->query('ALTER TABLE `product_quantities`
                            ADD CONSTRAINT `operation_id_constr2` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`) ON UPDATE CASCADE,
                            ADD CONSTRAINT `product_id_constr` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;');
        
        $this->db->query('ALTER TABLE `service_usages`
                            ADD CONSTRAINT `service_id_constr` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON UPDATE CASCADE,
                            ADD CONSTRAINT `operation_id_constr` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`) ON UPDATE CASCADE;');
    }
    
    public function down() {
        $this->db->query('ALTER TABLE `operations` DROP FOREIGN KEY `person_id_constr`;');
        $this->db->query('ALTER TABLE `operations` DROP FOREIGN KEY `admin_id_constr`;');
        $this->db->query('ALTER TABLE `operations` DROP FOREIGN KEY `workplace_id_constr`;');
        
        $this->db->query('ALTER TABLE `persons` DROP FOREIGN KEY `group_id_constr`;');
        
        $this->db->query('ALTER TABLE `product_quantities` DROP FOREIGN KEY `operation_id_constr2`;');
        $this->db->query('ALTER TABLE `product_quantities` DROP FOREIGN KEY `product_id_constr`;');
        
        $this->db->query('ALTER TABLE `service_usages` DROP FOREIGN KEY `service_id_constr`;');
        $this->db->query('ALTER TABLE `service_usages` DROP FOREIGN KEY `operation_id_constr`;');
        
        $this->db->query('DROP TABLE IF EXISTS `ci_sessions`;');
        $this->db->query('DROP TABLE IF EXISTS `groups`;');
        $this->db->query('DROP TABLE IF EXISTS `operations`;');
        $this->db->query('DROP TABLE IF EXISTS `persons`;');
        $this->db->query('DROP TABLE IF EXISTS `products`;');
        $this->db->query('DROP TABLE IF EXISTS `product_quantities`;');
        $this->db->query('DROP TABLE IF EXISTS `services`;');
        $this->db->query('DROP TABLE IF EXISTS `service_usages`;');
        $this->db->query('DROP TABLE IF EXISTS `workplaces`;');
    }
    
}