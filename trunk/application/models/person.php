<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Person
 *
 * @author Andrej
 */
class Person extends DataMapper {
    public $table_name = 'persons';
    
    public $has_one = array('group');
    public $has_many = array('operation');
}

?>
