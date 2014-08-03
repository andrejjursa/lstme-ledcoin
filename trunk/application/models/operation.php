<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Operation
 *
 * @author Andrej
 */
class Operation extends DataMapper {
    const TYPE_ADDITION = 'addition';
    const TYPE_SUBTRACTION = 'subtraction';
    
    const SUBTRACTION_TYPE_DIRECT = 'direct';
    const SUBTRACTION_TYPE_SERVICES = 'services';
    const SUBTRACTION_TYPE_PRODUCTS = 'products';
    
    public $table_name = 'operations';
    
    public $has_many = array('product_quantity', 'service_usage');
    public $has_one = array(
        'person',
        'workplace',
        'admin' => array(
            'class' => 'person',
        ),
    );
}

?>
