<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Apartment
 *
 * @author Ferdinand Krizan
 */
class Apartment extends DataMapper {
    public $table_name = 'apartments';
    
    public $has_many = array('operation');
}

?>
