<?php

function filter_get_filter($filter_name, $default = array()) {
    $default_filters = is_array($default) ? $default : array();
    if (trim($filter_name) == '') { return $default_filters; }
    $CI =& get_instance();
    $CI->load->library('session');
    
    $filters = $CI->session->userdata('filters');
    if (is_array($filters) && array_key_exists($filter_name, $filters)) {
        return $filters[$filter_name];
    } else {
        return $default_filters;
    }
}

function filter_store_filter($filter_name, $data = array()) {
    if (!is_array($data)) { return; }
    if (trim($filter_name) == '') { return; }
    
    $CI =& get_instance();
    $CI->load->library('session');
    
    $filters = $CI->session->userdata('filters');
    
    if (!is_array($filters)) {
        $filters = array();
    }
    
    $filters[$filter_name] = $data;
    
    $CI->session->set_userdata('filters', $filters);
}