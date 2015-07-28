<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'persons',
  'fields' => 
  array (
    0 => 'id',
    1 => 'created',
    2 => 'updated',
    3 => 'name',
    4 => 'surname',
    5 => 'login',
    6 => 'enabled',
    7 => 'password',
    8 => 'group_id',
    9 => 'admin',
    10 => 'organisation',
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
    'name' => 
    array (
      'field' => 'name',
      'rules' => 
      array (
      ),
    ),
    'surname' => 
    array (
      'field' => 'surname',
      'rules' => 
      array (
      ),
    ),
    'login' => 
    array (
      'field' => 'login',
      'rules' => 
      array (
      ),
    ),
    'enabled' => 
    array (
      'field' => 'enabled',
      'rules' => 
      array (
      ),
    ),
    'password' => 
    array (
      'field' => 'password',
      'rules' => 
      array (
      ),
    ),
    'group_id' => 
    array (
      'field' => 'group_id',
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
    'organisation' => 
    array (
      'field' => 'organisation',
      'rules' => 
      array (
      ),
    ),
    'group' => 
    array (
      'field' => 'group',
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
    'group' => 
    array (
      'class' => 'group',
      'other_field' => 'person',
      'join_self_as' => 'person',
      'join_other_as' => 'group',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
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