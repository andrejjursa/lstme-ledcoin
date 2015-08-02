<?php

class Migration_alter_operations_2 extends CI_Migration {
    
    public function up() {
	$this->db->query('ALTER TABLE `operations` CHANGE `time` `amount` INT( 11 ) NOT NULL DEFAULT \'0\';');
    }
    
    public function down() {
	$this->db->query('ALTER TABLE `operations` CHANGE `amount` `time` INT( 11 ) NOT NULL DEFAULT \'0\';');
    }
    
}
