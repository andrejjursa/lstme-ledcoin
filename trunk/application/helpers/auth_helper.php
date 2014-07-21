<?php

/**
 * Tests if there is valid user authentification.
 * @return boolean returns TRUE when there is valid authentification, FALSE otherwise.
 */
function auth_is_authentificated() {
    if (array_key_exists('strojak-user-auth', $GLOBALS)) {
        if ($GLOBALS['strojak-user-auth'] === TRUE) { return TRUE; }
        if ($GLOBALS['strojak-user-auth'] === FALSE) { return FALSE; }
    }
    $CI =& get_instance();
    $uid = $CI->session->userdata('user-id');
    if (!is_null($uid)) {
        $person = new Person();
        $person->get_by_id((int)$uid);
        if ($person->exists() && $person->id == (int)$uid) {
            $GLOBALS['strojak-user-data'] = $person->to_array();
            unset($GLOBALS['strojak-user-data']['password']);
            unset($GLOBALS['strojak-user-data']['created']);
            unset($GLOBALS['strojak-user-data']['updated']);
            $GLOBALS['strojak-user-auth'] = TRUE;
            return TRUE;
        }
    }
    $GLOBALS['strojak-user-auth'] = FALSE;
    if (isset($GLOBALS['strojak-user-data'])) {
        unset($GLOBALS['strojak-user-data']);
    }
    return FALSE;
};

/**
 * Tests if login and password match one and only one person record.
 * @param string $login user login.
 * @param type $password user password (plain).
 * @return boolean returns TRUE on successful or existing authentification, FALSE otherwise.
 */
function auth_authentificate($login, $password) {
    if (auth_is_authentificated()) { return TRUE; }
    
    $CI =& get_instance();
    
    $person = new Person();
    $person->where('login', $login);
    $person->where('password', sha1($password));
    $person->get();
    
    if ($person->exists() && $person->result_count() == 1) {
        $GLOBALS['strojak-user-data'] = $person->to_array();
        unset($GLOBALS['strojak-user-data']['password']);
        unset($GLOBALS['strojak-user-data']['created']);
        unset($GLOBALS['strojak-user-data']['updated']);
        $GLOBALS['strojak-user-auth'] = TRUE;
        $CI->session->set_userdata('user-id', $person->id);
        return TRUE;
    }
    return FALSE;
};

/**
 * Deletes authentification record from session.
 * @return void
 */
function auth_remove_authentification() {
    $CI =& get_instance();
    $CI->session->unset_userdata('user-id');
    $GLOBALS['strojak-user-auth'] = FALSE;
    if (isset($GLOBALS['strojak-user-data'])) {
        unset($GLOBALS['strojak-user-data']);
    }
}

/**
 * Tests if authentificated user is administrator.
 * @return boolean TRUE if user is administrator, FALSE otherwise.
 */
function auth_is_admin() {
    if (!auth_is_authentificated()) { return FALSE; }
    return $GLOBALS['strojak-user-data']['admin'] == 1;
}

/**
 * Returns user real name when user is authentificated.
 * @return string user real name.
 */
function auth_get_name() {
    if (!auth_is_authentificated()) { return ''; }
    return $GLOBALS['strojak-user-data']['name'];
}

/**
 * Redirect browser request to specified URL when no authentification is found.
 * @param string $url relative URL to redirect to.
 */
function auth_redirect_if_not_authentificated($url = '/') {
    if (!auth_is_authentificated()) {
        $CI =& get_instance();
        $CI->load->helper('url');
        redirect($url);
    }
}

/**
 * Redirect browser request to specified URL when no administrator authentification is found.
 * @param string $url relative URL to redirect to.
 */
function auth_redirect_if_not_admin($url = '/') {
    if (!auth_is_admin()) {
        $CI =& get_instance();
        $CI->load->helper('url');
        redirect($url);
    }
}