<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Service
 *
 * @author Andrej
 */
class Service extends DataMapper {
    public $table_name = 'services';
    
    public $has_many = array('service_usage');
}

?>
