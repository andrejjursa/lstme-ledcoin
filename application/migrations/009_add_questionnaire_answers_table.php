<?php

class Migration_add_questionnaire_answers_table extends CI_Migration {

    public function up() {
        $this->db->query('CREATE TABLE `questionnaire_answers` ( `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , `created` TIMESTAMP NOT NULL DEFAULT \'0000-00-00 00:00:00\' , `updated` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `person_id` INT(11) UNSIGNED NULL DEFAULT NULL , `questionnaire_id` INT(11) UNSIGNED NULL DEFAULT NULL , `answers` MEDIUMTEXT NOT NULL , `answer_number` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_slovak_ci;');

        $this->db->query('ALTER TABLE `questionnaire_answers` ADD INDEX(`person_id`);');

        $this->db->query('ALTER TABLE `questionnaire_answers` ADD INDEX(`questionnaire_id`);');

        $this->db->query('ALTER TABLE `questionnaire_answers` ADD CONSTRAINT `qa_person_id` FOREIGN KEY (`person_id`) REFERENCES `persons`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;');

        $this->db->query('ALTER TABLE `questionnaire_answers` ADD UNIQUE `person_answer_number` (`person_id`, `answer_number`, `questionnaire_id`);');

        $this->db->query('ALTER TABLE `questionnaire_answers` ADD CONSTRAINT `qa_questionnaire_id` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;');
    }

    public function down() {
        $this->db->query('ALTER TABLE `questionnaire_answers` DROP FOREIGN KEY `qa_questionnaire_id`;');

        $this->db->query('ALTER TABLE `questionnaire_answers` DROP INDEX `person_answer_number`;');

        $this->db->query('ALTER TABLE `questionnaire_answers` DROP FOREIGN KEY `qa_person_id`;');

        $this->db->query('ALTER TABLE `questionnaire_answers` DROP INDEX `questionnaire_id`;');

        $this->db->query('ALTER TABLE `questionnaire_answers` DROP INDEX `person_id`;');

        $this->db->query('DROP TABLE `questionnaire_answers`;');
    }

}
