<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Workplace
 *
 * @author Andrej
 */
class Workplace extends DataMapper {
    public $table_name = 'workspaces';
    
    public $has_many = array('operation');
}

?>
