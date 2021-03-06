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
class Errormessage extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('datamapper');
    }

    public function index() {
        redirect('/');
    }
    
    public function no_auth() {
        $this->parser->parse('web/controllers/errormessage/no_auth.tpl', array('title' => 'Chyba prihlásenia'));
    }
    
    public function no_admin() {
        $this->parser->parse('web/controllers/errormessage/no_admin.tpl', array('title' => 'Chyba prihlásenia'));
    }
    
    public function page_not_found() {
        $this->parser->parse('web/controllers/errormessage/page_not_found.tpl', array('title' => 'Stránka neexistuje'));
    }
    
}

