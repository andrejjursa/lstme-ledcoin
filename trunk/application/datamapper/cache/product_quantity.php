<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'product_quantities',
  'fields' => 
  array (
    0 => 'id',
    1 => 'created',
    2 => 'updated',
    3 => 'product_id',
    4 => 'operation_id',
    5 => 'quantity',
    6 => 'price',
    7 => 'type',
  ),
  'validation' => 
  array (
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'created' => 
    array (
      'field' => 'created',
      'rules' => 
      array (
      ),
    ),
    'updated' => 
    array (
      'field' => 'updated',
      'rules' => 
      array (
      ),
    ),
    'product_id' => 
    array (
      'field' => 'product_id',
      'rules' => 
      array (
      ),
    ),
    'operation_id' => 
    array (
      'field' => 'operation_id',
      'rules' => 
      array (
      ),
    ),
    'quantity' => 
    array (
      'field' => 'quantity',
      'rules' => 
      array (
      ),
    ),
    'price' => 
    array (
      'field' => 'price',
      'rules' => 
      array (
      ),
    ),
    'type' => 
    array (
      'field' => 'type',
      'rules' => 
      array (
      ),
    ),
    'product' => 
    array (
      'field' => 'product',
      'rules' => 
      array (
      ),
    ),
    'operation' => 
    array (
      'field' => 'operation',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'product' => 
    array (
      'class' => 'product',
      'other_field' => 'product_quantity',
      'join_self_as' => 'product_quantity',
      'join_other_as' => 'product',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'operation' => 
    array (
      'class' => 'operation',
      'other_field' => 'product_quantity',
      'join_self_as' => 'product_quantity',
      'join_other_as' => 'operation',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
  ),
  '_field_tracking' => 
  array (
    'get_rules' => 
    array (
    ),
    'matches' => 
    array (
    ),
    'intval' => 
    array (
      0 => 'id',
    ),
  ),
);