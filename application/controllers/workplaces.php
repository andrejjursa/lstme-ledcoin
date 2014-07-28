<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of workplaces
 *
 * @author Andrej
 */
class Workplaces extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        auth_redirect_if_not_admin('error/no_admin');
    }
    
    public function index() {
        $workplaces = new Workplace();
        $workplaces->order_by('title', 'asc');
        $workplaces->include_related_count('operation', 'operations_count');
        $workplaces->get_iterated();
        $this->parser->assign('workplaces', $workplaces);
        $this->parser->parse('web/controllers/workplaces/index.tpl', array(
            'title' => 'Administrácia / Zamestnania',
            'new_item_url' => site_url('workplaces/new_workplace'),
        ));
    }
    
    public function new_workplace() {
        $this->parser->parse('web/controllers/workplaces/new_workplace.tpl', array(
            'title' => 'Administrácia / Zamestnania / Nové zamestnanie',
            'back_url' => site_url('workplaces'),
            'form' => $this->get_form(),
        ));
    }
    
    public function create_workplace() {
        build_validator_from_form($this->get_form());
        if ($this->form_validation->run()) {
            $workplace_data = $this->input->post('workplace');
            $workplace = new Workplace();
            $workplace->from_array($workplace_data, array('title'));
            if ($workplace->save()) {
                add_success_flash_message('Zamestnanie <strong>' . $workplace->title . '</strong> s ID <strong>' . $workplace->id . '</strong> bolo vytvorené úspešne.');
                redirect(site_url('workplaces'));
            } else {
                add_error_flash_message('Zamestnanie <strong>' . $workplace->title . '</strong> nebolo vytvorené.');
                redirect(site_url('workplaces/new_workplace'));
            }
        } else {
            $this->new_workplace();
        }
    }

    public function edit_workplace($workplace_id = NULL) {
        if (is_null($workplace_id)) {
            add_error_flash_message('Zamestnanie sa nenašlo.');
            redirect(site_url('workplaces'));
        }
        
        $workplace = new Workplace();
        $workplace->get_by_id((int)$workplace_id);
        
        if (!$workplace->exists()) {
            add_error_flash_message('Zamestnanie sa nenašlo.');
            redirect(site_url('workplaces'));
        }
        
        $this->parser->assign('workplace', $workplace);
        $this->parser->parse('web/controllers/workplaces/edit_workplace.tpl', array(
            'title' => 'Administrácia / Zamestnania / Úprava zamestnania',
            'form' => $this->get_form(),
            'back_url' => site_url('workplaces'),
        ));
    }
    
    public function update_workplace($workplace_id = NULL) {
        if (is_null($workplace_id)) {
            add_error_flash_message('Zamestnanie sa nenašlo.');
            redirect(site_url('workplaces'));
        }
        
        $this->db->trans_begin();
        $workplace = new Workplace();
        $workplace->get_by_id((int)$workplace_id);
        
        if (!$workplace->exists()) {
            $this->db->trans_rollback();
            add_error_flash_message('Zamestnanie sa nenašlo.');
            redirect(site_url('workplaces'));
        }
        
        build_validator_from_form($this->get_form());
        if ($this->form_validation->run()) {
            $workplace_data = $this->input->post('workplace');
            $workplace->from_array($workplace_data, array('title'));
            if ($workplace->save() && $this->db->trans_status()) {
                $this->db->trans_commit();
                add_success_flash_message('Zamestnanie s ID <strong>' . $workplace->id . '</strong> bolo úspešne upravené.');
                redirect(site_url('workplaces'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Zamestnanie s ID <strong>' . $workplace->id . '</strong> sa nepodarilo upraviť.');
                redirect(site_url('workplaces/edit_workspace/' . (int)$workplace->id));
            }
        } else {
            $this->db->trans_rollback();
            $this->edit_workplace($workplace_id);
        }
    }
    
    public function delete_workplace($workplace_id = NULL) {
        if (is_null($workplace_id)) {
            add_error_flash_message('Zamestnanie sa nenašlo.');
            redirect(site_url('workplaces'));
        }
        
        $this->db->trans_begin();
        $workplace = new Workplace();
        $workplace->include_related_count('operation', 'operations_count');
        $workplace->get_by_id((int)$workplace_id);
        
        if (!$workplace->exists()) {
            $this->db->trans_rollback();
            add_error_flash_message('Zamestnanie sa nenašlo.');
            redirect(site_url('workplaces'));
        }
        
        if ((int)$workplace->operations_count > 0) {
            $this->db->trans_rollback();
            add_error_flash_message('Nie je možné vymazať zamestnanie ak bolo použité v operácii so strojovým časom.');
            redirect(site_url('workplaces'));
        }
        
        $success_message = 'Zamestnanie <strong>' . $workplace->title . '</strong> s ID <strong>' . $workplace->id . '</strong> bolo úspešne vymazané.';
        $error_message = 'Zamestnanie <strong>' . $workplace->title . '</strong> s ID <strong>' . $workplace->id . '</strong> sa nepodarilo vymazať.';
        
        if ($workplace->delete() && $this->db->trans_status()) {
            $this->db->trans_commit();
            add_success_flash_message($success_message);
        } else {
            $this->db->trans_rollback();
            add_error_flash_message($error_message);
        }
        redirect(site_url('workplaces'));
    }

    private function get_form() {
        $form = array(
            'fields' => array(
                'title' => array(
                    'name' => 'workplace[title]',
                    'type' => 'text_input',
                    'id' => 'workplace-title',
                    'label' => 'Názov',
                    'object_property' => 'title',
                    'validation' => 'required',
                ),
            ),
            'arangement' => array(
                'title',
            ),
        );
        return $form;
    }
    
}

?>
