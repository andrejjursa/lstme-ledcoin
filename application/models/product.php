<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Product
 *
 * @author Andrej
 */
class Product extends DataMapper {
    public $table_name = 'products';
    
    public $has_many = array(
        'product_quantity',
    );
}

?>
