<?php

function smarty_function_form_value($params, $template) {
    if (isset($params['name']) && trim($params['name']) != '') {
        $name = str_replace(']', '', $params['name']);
        $name_arr = explode('[', $name);
        $CI =& get_instance();
        $post = $CI->input->post();
        $value = _smarty_function_form_value_get_from_array($name_arr, $post);
        if (empty($value) && isset($params['source'])) {
            if (is_array($params['source']) || is_object($params['source'])) {
                $source = $params['source'];
            } else {
                $source = $template->getTemplateVars($params['source']);
            }
            if (is_array($source)) {
                $value = _smarty_function_form_value_get_from_array($name_arr, $source);
            } elseif (is_object($source) && $source instanceOf DataMapper) {
                if (isset($params['property']) && is_string($params['property']) && trim($params['property']) == $params['property'] && property_exists($source, $params['property'])) {
                    $value = $source->$params['property'];
                }
            }
        }
        if (empty($value) && isset($params['default'])) {
            $value = $params['default'];
        }
        return $value;
    } elseif (isset($params['default'])) {
        return $params['default'];
    }
    return '';
}

function _smarty_function_form_value_get_from_array($path, $array) {
    $current_value = $array;
    foreach ($path as $path_segment) {
        if (is_array($current_value) && array_key_exists($path_segment, $current_value)) {
            $current_value = $current_value[$path_segment];
        } else {
            return '';
        }
    }
    return $current_value;
}
