<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of error
 *
 * @author Andrej
 */
class Error extends CI_Controller {
    
    public function index() {
        redirect('/');
    }
    
    public function no_auth() {
        $this->parser->parse('web/controllers/error/no_auth.tpl', array('title' => 'Chyba prihlásenia'));
    }
    
    public function no_admin() {
        $this->parser->parse('web/controllers/error/no_admin.tpl', array('title' => 'Chyba prihlásenia'));
    }
    
}

?>
