<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group
 *
 * @author Andrej
 */
class Group extends DataMapper {
    public $table_name = 'groups';
    
    public $has_many = array('person');
}

?>
