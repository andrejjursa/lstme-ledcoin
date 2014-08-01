<?php

class Migration_alter_operations extends CI_Migration {
    
    public function up() {
        $this->db->query('ALTER TABLE `operations` ADD `subtraction_type` ENUM( \'direct\', \'services\', \'products\' ) NOT NULL DEFAULT \'direct\' AFTER `type`;');
    }
    
    public function down() {
        $this->db->query('ALTER TABLE `operations` DROP `subtraction_type`;');
    }
    
}