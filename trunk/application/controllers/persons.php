<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of persons
 *
 * @author Andrej
 */
class Persons extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        auth_redirect_if_not_admin('error/no_admin');
    }

    public function index() {
        $this->inject_persons();
        $this->parser->parse('web/controllers/persons/index.tpl', array('title' => 'Administrácia / Ľudia'));
    }
    
    protected function inject_persons() {
        $persons = new Person();
        $persons->order_by('admin', 'DESC')->order_by('name', 'ASC');
        $persons->get_iterated();
        $this->parser->assign('persons', $persons);
    }
    
}

?>
