<?php

function build_validator_from_form($form) {
    $rules = array();
    $CI =& get_instance();

    $CI->load->library('form_validation');
    
    if (is_array($form) && isset($form['fields']) && isset($form['arangement']) && is_array($form['fields']) && is_array($form['arangement']) 
            && count($form['fields']) > 0 && count($form['arangement']) > 0) {
        foreach ($form['arangement'] as $index) {
            $form_element = isset($form['fields'][$index]) ? $form['fields'][$index] : NULL;
            if (!is_null($form_element) && is_array($form_element)) {
                if (array_key_exists('validation', $form_element) && isset($form_element['name']) && trim($form_element['name']) != '' && (!isset($form_element['disabled']) || $form_element['disabled'] === FALSE)) {
                    if (is_string($form_element['validation'])) {
                        $rules[] = array(
                            'field' => $form_element['name'],
                            'label' => @$form_element['label'],
                            'rules' => $form_element['validation'],
                        );
                    } elseif (is_array($form_element['validation'])) {
                        $rules_from_tree = recurse_validation_condition_tree($form_element['validation']);
                        if (!is_null($rules_from_tree)) {
                            $rules[] = array(
                                'field' => $form_element['name'],
                                'label' => @$form_element['label'],
                                'rules' => $rules_from_tree,
                            );
                        }
                    }
                }
                if (array_key_exists('validation_messages', $form_element) && isset($form_element['name']) && trim($form_element['name']) != '') {
                    if (is_array($form_element['validation_messages']) && count($form_element['validation_messages'])) {
                        foreach ($form_element['validation_messages'] as $rule => $message) {
                            $CI->form_validation->set_message($rule, $message);
                        }
                    }
                }
            }
        }
    }

    if (count($rules) > 0) {
        $CI->form_validation->set_rules($rules);
    }
}

function recurse_validation_condition_tree($condition_tree) {
    $CI =& get_instance();
    $default = NULL;
    $post = $CI->input->post();
    
    if (is_array($condition_tree) && count($condition_tree) > 0) {
        foreach ($condition_tree as $tree_item) {
            if (array_key_exists('rules', $tree_item)) {
                if (array_key_exists('if-field-equals', $tree_item) && is_array($tree_item['if-field-equals'])) {
                    if (array_key_exists('field', $tree_item['if-field-equals']) && is_string($tree_item['if-field-equals']['field']) && trim($tree_item['if-field-equals']['field']) != ''
                        && array_key_exists('value', $tree_item['if-field-equals'])) {
                        $field_value = get_value_of_field($tree_item['if-field-equals']['field'], $post);
                        if (!is_null($field_value) && $field_value == $tree_item['if-field-equals']['value']) {
                            if (is_string($tree_item['rules'])) {
                                return $tree_item['rules'];
                            } elseif (is_array($tree_item['rules'])) {
                                return recurse_validation_condition_tree($tree_item['rules']);
                            }
                        }
                    } 
                }
                if (array_key_exists('if-field-not-equals', $tree_item) && is_array($tree_item['if-field-not-equals'])) {
                    if (array_key_exists('field', $tree_item['if-field-not-equals']) && is_string($tree_item['if-field-not-equals']['field']) && trim($tree_item['if-field-not-equals']['field']) != ''
                        && array_key_exists('value', $tree_item['if-field-not-equals'])) {
                        $field_value = get_value_of_field($tree_item['if-field-not-equals']['field'], $post);
                        if (!is_null($field_value) && $field_value != $tree_item['if-field-not-equals']['value']) {
                            if (is_string($tree_item['rules'])) {
                                return $tree_item['rules'];
                            } elseif (is_array($tree_item['rules'])) {
                                return recurse_validation_condition_tree($tree_item['rules']);
                            }
                        }
                    }
                } elseif (array_key_exists('otherwise', $tree_item) && is_string($tree_item['rules'])) {
                    $default = $tree_item['rules'];
                }
            }
        }
    }
    
    return $default;
}

function get_value_of_field($field, $array) {
    if (trim($field) == '') { return NULL; }
    $path = explode('[', str_replace(']', '', $field));
    $current_value = $array;
    foreach ($path as $path_segment) {
        if (is_array($current_value) && array_key_exists($path_segment, $current_value)) {
            $current_value = $current_value[$path_segment];
        } else {
            return NULL;
        }
    }
    return $current_value;
}