<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'apartments',
  'fields' => 
  array (
    0 => 'id',
    1 => 'created',
    2 => 'updated',
    3 => 'title',
    4 => 'points',
    /*5 => 'login',
    6 => 'enabled',
    7 => 'password',
    8 => 'group_id',
    9 => 'admin',
    10 => 'organisation',
	11 => 'number',
	12 => 'email',*/
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
	'points' => 
    array (
      'field' => 'points',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_many' => 
  array (
    'operation' => 
    array (
      'class' => 'operation',
      'other_field' => 'person',
      'join_self_as' => 'person',
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