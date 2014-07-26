<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sevices
 *
 * @author Andrej
 */
class Services extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        auth_redirect_if_not_admin('error/no_admin');
    }
    
    public function index() {
        $services = new Service();
        $services->order_by('title', 'asc');
        $services->get_iterated();
        
        $this->parser->parse('web/controllers/services/index.tpl', array(
            'title' => 'Administrácia / Služby',
            'new_item_url' => site_url('services/new_service'),
            'services' => $services,
        ));
    }
    
}

?>
