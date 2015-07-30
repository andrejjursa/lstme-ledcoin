<?php

define('LEDCOIN_FLASHDATA_FLASH_MESSAGE_KEY', '_ledcoin_flashdata_flash_message_key');
define('LEDCOIN_FLASHDATA_FLASH_MESSAGE_TYPE_SUCCESS', 'success');
define('LEDCOIN_FLASHDATA_FLASH_MESSAGE_TYPE_ERROR', 'error');
define('LEDCOIN_FLASHDATA_FLASH_MESSAGE_TYPE_COMMON', 'common');

/**
 * Add new flash message into list of flash messages.
 * @param string $message_text flash message text.
 * @param string $message_type type of flash message, one of LEDCOIN_FLASHDATA_FLASH_MESSAGE_TYPE_*.
 */
function add_flash_message($message_text, $message_type = LEDCOIN_FLASHDATA_FLASH_MESSAGE_TYPE_COMMON) {
    $CI =& get_instance();
    $CI->load->library('session');
    $current_messages = $CI->session->flashdata(LEDCOIN_FLASHDATA_FLASH_MESSAGE_KEY);
    $message = new stdClass();
    $message->text = $message_text;
    $message->type = $message_type;
    $current_messages[] = $message;
    $CI->session->set_flashdata(LEDCOIN_FLASHDATA_FLASH_MESSAGE_KEY, $current_messages);
}

/**
 * Returns all flash messages.
 * @return array<stdClass> flash messages.
 */
function get_flash_messages() {
    $CI =& get_instance();
    $CI->load->library('session');
    return $CI->session->flashdata(LEDCOIN_FLASHDATA_FLASH_MESSAGE_KEY);
}

/**
 * Add new success flash message.
 * @param string $message_text flash message text.
 */
function add_success_flash_message($message_text) {
    add_flash_message($message_text, LEDCOIN_FLASHDATA_FLASH_MESSAGE_TYPE_SUCCESS);
}

/**
 * Add new error flash message.
 * @param string $message_text flash message text.
 */
function add_error_flash_message($message_text) {
    add_flash_message($message_text, LEDCOIN_FLASHDATA_FLASH_MESSAGE_TYPE_ERROR);
}

/**
 * Add new common flash message.
 * @param string $message_text flash message text.
 */
function add_common_flash_message($message_text) {
    add_flash_message($message_text, LEDCOIN_FLASHDATA_FLASH_MESSAGE_TYPE_COMMON);
}