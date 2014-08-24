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
        $this->load->library('session');
        
        auth_redirect_if_not_admin('error/no_admin');
    }
    
    public function index() {
        $this->load->helper('filter');
        
        $services = new Service();
        $services->order_by('title', 'asc');
        $services->get_iterated();
        
        $this->parser->parse('web/controllers/services/index.tpl', array(
            'title' => 'Administrácia / Služby',
            'new_item_url' => site_url('services/new_service'),
            'services' => $services,
        ));
    }
    
    public function new_service() {
        $this->parser->parse('web/controllers/services/new_service.tpl', array(
            'title' => 'Administrácia / Služby / Nová služba',
            'back_url' => site_url('services'),
            'form' => $this->get_form(),
        ));
    }
    
    public function create_service() {
        build_validator_from_form($this->get_form());
        if ($this->form_validation->run()) {
            $service_data = $this->input->post('service');
            $service = new Service();
            $service->from_array($service_data, array('title', 'price'));
            if ($service->save()) {
                add_success_flash_message('Služba <strong>' . $service->title . '</strong> s cenou za minútu <strong>' . $service->price . '</strong> a ID <strong>' . $service->id . '</strong> bola úspešne vytvorená.');
                redirect(site_url('services'));
            } else {
                add_error_flash_message('Nepodarilo sa vytvoriť službu <strong>' . $service->title . '</strong> s cenou za minútu <strong>' . $service->price . '</strong>.');
                redirect(site_url('services/new_service'));
            }
        } else {
            $this->new_service();
        }
    }
    
    public function edit_service($service_id = NULL) {
        if (is_null($service_id)) {
            add_error_flash_message('Služba sa nenašla.');
            redirect(site_ur('services'));
        }
        
        $service = new Service();
        $service->get_by_id((int)$service_id);
        
        if (!$service->exists()) {
            add_error_flash_message('Služba sa nenašla.');
            redirect(site_ur('services'));
        }
        
        $this->parser->parse('web/controllers/services/edit_service.tpl', array(
            'service' => $service,
            'title' => 'Administrácia / Služby / Úprava sluźby',
            'back_url' => site_url('services'),
            'form' => $this->get_form(),
        ));
    }
    
    public function update_service($service_id = NULL) {
        if (is_null($service_id)) {
            add_error_flash_message('Služba sa nenašla.');
            redirect(site_ur('services'));
        }
        
        $this->db->trans_begin();
        $service = new Service();
        $service->get_by_id((int)$service_id);
        
        if (!$service->exists()) {
            $this->db->trans_rollback();
            add_error_flash_message('Služba sa nenašla.');
            redirect(site_ur('services'));
        }
        
        build_validator_from_form($this->get_form());
        if ($this->form_validation->run()) {
            $service_data = $this->input->post('service');
            $service->from_array($service_data, array('title', 'price'));
            if ($service->save() && $this->db->trans_status()) {
                $this->db->trans_commit();
                add_success_flash_message('Služba s ID <strong>' . $service->id . '</strong> bola úspešne upravená.');
                redirect(site_url('services'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Službu s ID <strong>' . $service->id . '</strong> sa nepodarilo upraviť.');
                redirect(site_url('services/edit_service/' . (int)$service->id));
            }
        } else {
            $this->db->trans_rollback();
            $this->edit_service($service->id);
        }
    }


    public function delete_service($service_id = NULL) {
        if (is_null($service_id)) {
            add_error_flash_message('Služba sa nenašla.');
            redirect(site_ur('services'));
        }
        
        $this->db->trans_begin();
        $service = new Service();
        $service->include_related_count('service_usage', 'service_usages_count');
        $service->get_by_id((int)$service_id);
        
        if (!$service->exists()) {
            $this->db->trans_rollback();
            add_error_flash_message('Služba sa nenašla.');
            redirect(site_ur('services'));
        }
        
        if ((int)$service->service_usages_count > 0) {
            $this->db->trans_rollback();
            add_error_flash_message('Nie je možné vymazať službu, ktorá bola už použitá v operáciách so strojovým časom.');
            redirect(site_url('services'));
        }
        
        $success_message = 'Služba <strong>' . $service->title . '</strong> s ID <strong>' . $service->id . '</strong> bola úspešne vymazaná.';
        $error_message = 'Službu <strong>' . $service->title . '</strong> s ID <strong>' . $service->id . '</strong> sa nepodarilo vymazať.';
        
        if ($service->delete() && $this->db->trans_status()) {
            $this->db->trans_commit();
            add_success_flash_message($success_message);
        } else {
            $this->db->trans_rollback();
            add_error_flash_message($error_message);
        }
        redirect(site_url('services'));
    }
    
    public function overview($service_id = NULL) {
        if (is_null($service_id)) {
            add_error_flash_message('Služba sa nenašla.');
            redirect(site_ur('services'));
        }
        
        $service = new Service();
        $service->get_by_id((int)$service_id);
        
        if (!$service->exists()) {
            add_error_flash_message('Služba sa nenašla.');
            redirect(site_ur('services'));
        }
        
        $service_usages = new Service_usage();
        $service_usages->where_related_service($service);
        $service_usages->include_related('operation', array('id', 'type', 'created'));
        $service_usages->include_related('operation/person', array('name', 'surname'));
        $service_usages->include_related('operation/admin', array('name', 'surname'));
        $service_usages->include_related('operation/workplace', array('title'));
        $service_usages->order_by('created', 'desc');
        $service_usages->order_by_related('operation', 'created', 'desc');
        $service_usages->get_iterated();
        
        $this->parser->parse('web/controllers/services/overview.tpl', array(
            'title' => 'Administrácia / Služby / Prehľad služby / ' . $service->title,
            'service' => $service,
            'service_usages' => $service_usages,
            'back_url' => site_url('services'),
        ));
    }

    protected function get_form() {
        $form = array(
            'fields' => array(
                'title' => array(
                    'name' => 'service[title]',
                    'type' => 'text_input',
                    'label' => 'Názov',
                    'id' => 'service-title',
                    'object_property' => 'title',
                    'validation' => 'required',
                ),
                'price' => array(
                    'name' => 'service[price]',
                    'type' => 'text_input',
                    'label' => 'Cena za minútu',
                    'id' => 'service-price',
                    'object_property' => 'price',
                    'validation' => 'required|integer|greater_than[0]',
                ),
            ),
            'arangement' => array(
                'title', 'price',
            ),
        );
        return $form;
    }
    
}

?>
