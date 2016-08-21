<?php

class Migration_add_questionnaires_table extends CI_Migration {

    public function up() {
        $this->db->query('CREATE TABLE `questionnaires` ( `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , `created` TIMESTAMP NOT NULL DEFAULT \' 0000-00-00 00:00:00\' , `updated` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `title` VARCHAR(255) NOT NULL , `configuration` MEDIUMTEXT NOT NULL , `published` BOOLEAN NOT NULL DEFAULT FALSE , `attempts` INT(8) NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_slovak_ci;');

        $this->db->query('ALTER TABLE `questionnaires` ADD UNIQUE(`title`);');
    }

    public function down() {
        $this->db->query('ALTER TABLE `questionnaires` DROP INDEX `title`;');

        $this->db->query('DROP TABLE `questionnaires`;');
    }

}
