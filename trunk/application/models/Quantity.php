<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Quantity
 *
 * @author Andrej
 */
class Quantity extends DataMapper {
    public $table_name = 'quantities';
    
    public $has_one = array(
        'product',
        'operation',
    );
}

?>
