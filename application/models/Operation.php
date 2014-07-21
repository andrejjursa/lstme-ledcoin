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
    public $table_name = 'operations';
    
    public $has_many = array('quantity');
    public $has_one = array(
        'person',
        'workplace',
        'admin' => array(
            'class' => 'person',
        ),
    );
}

?>
