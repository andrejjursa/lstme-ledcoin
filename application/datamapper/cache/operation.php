<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'operations',
  'fields' => 
  array (
    0 => 'id',
    1 => 'created',
    2 => 'updated',
    3 => 'person_id',
    4 => 'admin_id',
    5 => 'workplace_id',
    6 => 'time',
    7 => 'type',
    8 => 'subtraction_type',
    9 => 'comment',
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
    'person_id' => 
    array (
      'field' => 'person_id',
      'rules' => 
      array (
      ),
    ),
    'admin_id' => 
    array (
      'field' => 'admin_id',
      'rules' => 
      array (
      ),
    ),
    'workplace_id' => 
    array (
      'field' => 'workplace_id',
      'rules' => 
      array (
      ),
    ),
    'time' => 
    array (
      'field' => 'time',
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
    'subtraction_type' => 
    array (
      'field' => 'subtraction_type',
      'rules' => 
      array (
      ),
    ),
    'comment' => 
    array (
      'field' => 'comment',
      'rules' => 
      array (
      ),
    ),
    'person' => 
    array (
      'field' => 'person',
      'rules' => 
      array (
      ),
    ),
    'workplace' => 
    array (
      'field' => 'workplace',
      'rules' => 
      array (
      ),
    ),
    'apartment' => 
    array (
      'field' => 'apartment',
      'rules' => 
      array (
      ),
    ),
    'admin' => 
    array (
      'field' => 'admin',
      'rules' => 
      array (
      ),
    ),
    'product_quantity' => 
    array (
      'field' => 'product_quantity',
      'rules' => 
      array (
      ),
    ),
    'service_usage' => 
    array (
      'field' => 'service_usage',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'admin' => 
    array (
      'class' => 'person',
      'other_field' => 'operation',
      'join_self_as' => 'operation',
      'join_other_as' => 'admin',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'person' => 
    array (
      'class' => 'person',
      'other_field' => 'operation',
      'join_self_as' => 'operation',
      'join_other_as' => 'person',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'workplace' => 
    array (
      'class' => 'workplace',
      'other_field' => 'operation',
      'join_self_as' => 'operation',
      'join_other_as' => 'workplace',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'apartment' => 
    array (
      'class' => 'apartment',
      'other_field' => 'operation',
      'join_self_as' => 'operation',
      'join_other_as' => 'apartment',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'product_quantity' => 
    array (
      'class' => 'product_quantity',
      'other_field' => 'operation',
      'join_self_as' => 'operation',
      'join_other_as' => 'product_quantity',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'service_usage' => 
    array (
      'class' => 'service_usage',
      'other_field' => 'operation',
      'join_self_as' => 'operation',
      'join_other_as' => 'service_usage',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
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