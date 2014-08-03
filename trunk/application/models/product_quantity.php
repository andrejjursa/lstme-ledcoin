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
class Product_quantity extends DataMapper {
    const TYPE_ADDITION = 'addition';
    const TYPE_SUBTRACTION = 'subtraction';
    
    public $table_name = 'product_quantities';
    
    public $has_one = array(
        'product',
        'operation',
    );
}

?>
