<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Andrej
 * @edit Ferdinand Križan
 */
class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function login() {
        $redirect_url = $this->input->post('return_url');
        
        $login = $this->input->post('login');
        
        if (auth_authentificate($login['login'], $login['password'])) {
            add_success_flash_message('Prihlásenie úspešné. Vitaj ' . auth_get_name() . '!');
        } else {
            add_error_flash_message('Prihlásenie neúspešné. Chybné meno alebo heslo.');
        }
        
        redirect($redirect_url);
    }
	
	public function register() {
        $redirect_url = $this->input->post('return_url');
        
        
        redirect($redirect_url);
    }
    
    public function logout() {
        auth_remove_authentification();
        add_success_flash_message('Odhlásenie úspešné.');
        
        redirect('/');
    }
    
}

