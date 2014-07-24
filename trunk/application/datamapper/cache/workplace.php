<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'workplaces',
  'fields' => 
  array (
    0 => 'id',
    1 => 'created',
    2 => 'updated',
    3 => 'title',
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
  ),
  'has_many' => 
  array (
    'operation' => 
    array (
      'class' => 'operation',
      'other_field' => 'workplace',
      'join_self_as' => 'workplace',
      'join_other_as' => 'operation',
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