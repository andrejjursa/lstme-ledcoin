<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'services',
  'fields' => 
  array (
    0 => 'id',
    1 => 'created',
    2 => 'updated',
    3 => 'title',
    4 => 'price',
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
    'title' => 
    array (
      'field' => 'title',
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
  ),
  'has_many' => 
  array (
    'service_usage' => 
    array (
      'class' => 'service_usage',
      'other_field' => 'service',
      'join_self_as' => 'service',
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