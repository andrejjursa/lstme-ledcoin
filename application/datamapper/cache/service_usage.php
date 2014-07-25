<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'service_usages',
  'fields' => 
  array (
    0 => 'id',
    1 => 'created',
    2 => 'updated',
    3 => 'operation_id',
    4 => 'service_id',
    5 => 'quantity',
    6 => 'price',
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
    'operation_id' => 
    array (
      'field' => 'operation_id',
      'rules' => 
      array (
      ),
    ),
    'service_id' => 
    array (
      'field' => 'service_id',
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
    'service' => 
    array (
      'field' => 'service',
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
    'service' => 
    array (
      'class' => 'service',
      'other_field' => 'service_usage',
      'join_self_as' => 'service_usage',
      'join_other_as' => 'service',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'operation' => 
    array (
      'class' => 'operation',
      'other_field' => 'service_usage',
      'join_self_as' => 'service_usage',
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