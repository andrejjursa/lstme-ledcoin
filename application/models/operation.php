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

    const ADDITION_TYPE_TRANSFER = 'transfer';
    const ADDITION_TYPE_MINING = 'mining';
    
    public $table_name = 'operations';
    
    public $has_many = array('product_quantity', 'service_usage');
    public $has_one = array(
        'person',
        'workplace',
		'apartment',
        'admin' => array(
            'class' => 'person',
        ),
    );
}

?>
