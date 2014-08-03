<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Service_quantity
 *
 * @author Andrej
 */
class Service_usage extends DataMapper {
    public $table_name = 'service_quantities';
    
    public $has_one = array('service', 'operation');
}

?>
