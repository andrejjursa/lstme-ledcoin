<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of groups
 *
 * @author Andrej
 */
class Groups extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        auth_redirect_if_not_admin('error/no_admin');
    }
    
    public function index() {
        $groups = new Group();
        $persons_count = $groups->person;
        $persons_count->select_func('COUNT', array('@id'), 'persons_count');
        $persons_count->where_related_group('id', '${parent}.id');
        $groups->select_subquery($persons_count, 'persons_count');
        $groups->select('*');
        $groups->order_by('title', 'asc');
        $groups->get_iterated();
        
        $this->parser->assign('groups', $groups);
        
        $this->parser->parse('web/controllers/groups/index.tpl', array('title' => 'Administrácia / Skupiny', 'new_item_url' => site_url('groups/new_group')));
    }
    
    public function new_group() {
        $this->parser->parse('web/controllers/groups/new_group.tpl', array(
            'title' => 'Administrácia / Skupiny / Nová skupina',
            'back_url' => site_url('groups'),
            'form' => $this->get_form(),
        ));
    }
    
    public function create_group() {
        build_validator_from_form($this->get_form());
        
        if ($this->form_validation->run()) {
            $group_data = $this->input->post('group');
            $group = new Group();
            $group->from_array($group_data, array('title'));
            if ($group->save()) {
                add_success_flash_message('Skupina <strong>' . $group->title . '</strong> s ID <strong>' . $group->id . '</strong> bola úspešne vytvorená.');
                redirect(site_url('groups'));
            } else {
                add_error_flash_message('Skupinu <strong>' . $group->title . '</strong> sa nepodarilo vytvoriť.');
                redirect(site_url('groups/new_group'));
            }
        } else {
            $this->new_group();
        }
    }

    public function edit_group($group_id = NULL) {
        if (is_null($group_id)) {
            add_error_flash_message('Skupina sa nenašla.');
            redirect(site_url('groups'));
        }
        
        $group = new Group();
        $group->get_by_id((int)$group_id);
        
        if (!$group->exists()) {
            add_error_flash_message('Skupina sa nenašla.');
            redirect(site_url('groups'));
        }
        
        $this->parser->assign('group', $group);
        $this->parser->parse('web/controllers/groups/edit_group.tpl', array(
            'title' => 'Administrácia / Skupiny / Úprava skupiny',
            'back_url' => site_url('groups'),
            'form' => $this->get_form(),
        ));
    }
    
    public function update_group($group_id = NULL) {
        if (is_null($group_id)) {
            add_error_flash_message('Skupina sa nenašla.');
            redirect(site_url('groups'));
        }
        
        $group = new Group();
        $group->get_by_id((int)$group_id);
        
        if (!$group->exists()) {
            add_error_flash_message('Skupina sa nenašla.');
            redirect(site_url('groups'));
        }
        
        build_validator_from_form($this->get_form());
        if ($this->form_validation->run()) {
            $group_data = $this->input->post('group');
            $group->from_array($group_data, array('title'));
            if ($group->save()) {
                add_success_flash_message('Skupina s ID <strong>' . $group->id . '</strong> bola úspešne upravená.');
                redirect(site_url('groups'));
            } else {
                add_error_flash_message('Skupina s ID <strong>' . $group->id . '</strong> nebola upravená.');
                redirect(site_url('groups/edit_group/' . (int)$group_id));
            }
        } else {
            $this->edit_group($group_id);
        }
    }

    public function delete_group($group_id = NULL) {
        if (is_null($group_id)) {
            add_error_flash_message('Skupina sa nenašla.');
            redirect(site_url('groups'));
        }
        
        $this->db->trans_begin();
        
        $group = new Group();
        $persons_count = $group->person;
        $persons_count->select_func('COUNT', array('@id'), 'persons_count');
        $persons_count->where_related_group('id', '${parent}.id');
        $group->select_subquery($persons_count, 'persons_count');
        $group->select('*');
        $group->get_by_id((int)$group_id);
        
        if (!$group->exists()) {
            $this->db->trans_rollback();
            add_error_flash_message('Skupina sa nenašla.');
            redirect(site_url('groups'));
        }
        
        if ((int)$group->persons_count > 0) {
            $this->db->trans_rollback();
            add_error_flash_message('Nie je možné vymazať skupinu, ktorá má členov.');
            redirect(site_url('groups'));
        }
        
        $success_message = 'Skupina <strong>' . $group->title . '</strong> s ID <strong>' . $group->id . '</strong> bola vymazaná úspešne.';
        $error_message = 'Skupinu <strong>' . $group->title . '</strong> s ID <strong>' . $group->id . '</strong> sa nepodarilo vymazať.';
        
        if ($group->delete() && $this->db->trans_status()) {
            $this->db->trans_commit();
            add_success_flash_message($success_message);
        } else {
            $this->db->trans_rollback();
            add_error_flash_message($error_message);
        }
        
        redirect(site_url('groups'));
    }
    
    private function get_form() {
        $form = array(
            'fields' => array(
                'title' => array(
                    'name' => 'group[title]',
                    'type' => 'text_input',
                    'id' => 'group-title',
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
