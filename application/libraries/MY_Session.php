<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extended MY_Session library.
 * @author Andrej Jursa
 */
class MY_Session extends CI_Session {
    
    public function sess_update() {
        if (!$this->CI->input->is_ajax_request()) {
            parent::sess_update();
        }
    }
    
}