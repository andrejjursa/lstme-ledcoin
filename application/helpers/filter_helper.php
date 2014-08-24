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

function filter_get_online_filter_form() {
    $form = array(
        'fields' => array(
            'text' => array(
                'name' => 'online_filter_text',
                'id' => 'online_filter_text-' . md5(rand(0, 99999999999999) . microtime() . memory_get_usage(TRUE)),
                'label' => 'Filter',
                'type' => 'text_input',
                'clearbutton' => TRUE,
            ),
        ),
        'arangement' => array(
            'text',
        ),
    );
    return $form;
}