<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Andrej
 */
class User extends CI_Controller {
    
    public function login() {
        $redirect_url = $this->input->post('return_url');
        
        $login = $this->input->post('login');
        
        auth_authentificate($login['login'], $login['password']);
        
        redirect($redirect_url);
    }
    
    public function logout() {
        auth_remove_authentification();
        
        redirect('/');
    }
    
}

?>
