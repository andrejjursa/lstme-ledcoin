<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of apartments
 *
 * @author Andrej
 * @edit Ferdinand Križan
 */
class Apartments extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        auth_redirect_if_not_admin('error/no_admin');
    }

	public function index() {
        $this->load->helper('filter');
                
        $apartments = new Apartment();
        $apartments->order_by('title', 'asc');
        $apartments->get_iterated();
        
        $this->parser->parse('web/controllers/apartments/index.tpl', array(
            'title' => 'Administrácia / Izby',
            'new_item_url' => site_url('apartments/new_apartments'),
            'apartments' => $apartments,
        ));        
    }
	
    public function new_apartments() {
        $this->parser->parse('web/controllers/apartments/new_apartment.tpl', array('title' => 'Administrácia / Izby', 'back_url' => site_url('apartments'), 'form' => $this->get_form()));
    }
    
    public function create_apartments() {
        $form = $this->get_form();
        build_validator_from_form($form);
        
        if ($this->form_validation->run()) {
            $this->db->trans_begin();
            $apartment_data = $this->input->post('apartment');
            
            $apartment = new Apartment();
            $apartment->from_array($apartment_data, array('title'));
            
            if ($apartment->save() && $this->db->trans_status()) {
                $this->db->trans_commit();
                add_success_flash_message('Izba menom <strong>' . $apartment_data['title'] . '</strong> bola vytvorená.');
                redirect(site_url('apartments'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Izbu sa nepodarilo vytvoriť, skúste to znovu neskôr.');
                redirect(site_url('apartments/new_apartment'));
            }
        } else {
            $this->new_apartments();
        }
    }

    public function edit_apartment($apartment_id = NULL) {
        if (is_null($apartment_id)) {
            add_error_flash_message('Izba sa nenašla.');
            redirect(site_url('apartments'));
        }
        
        $apartment = new Apartment();
        $apartment->get_by_id((int)$apartment_id);
        
        if (!$apartment->exists()) {
            add_error_flash_message('Izba sa nenašla.');
            redirect(site_url('apartments'));
        }
        
        $this->parser->assign('apartment', $apartment);
        
        $this->parser->parse('web/controllers/apartments/edit_apartment.tpl', array('title' => 'Administrácia / Izby / Úprava izby', 'back_url' => site_url('apartments'), 'form' => $this->get_edit_form()));
    }
    
    public function update_apartment($apartment_id = NULL) {
        if (is_null($apartment_id)) {
            add_error_flash_message('Izba sa nenašla.');
            redirect(site_url('apartments'));
        }
        
        $this->db->trans_begin();
        $apartment = new Apartment();
        $apartment->get_by_id((int)$apartment_id);
        
        if (!$apartment->exists()) {
            $this->db->trans_rollback();
            add_error_flash_message('izba sa nenašla. neexistujem');
            redirect(site_url('apartments'));
        }
        
        $form = $this->get_edit_form($apartment);
        build_validator_from_form($form);
        
        if ($this->form_validation->run()) {
            $apartment_data = $this->input->post('apartment');

            $apartment->from_array($apartment_data, array('title')); 

            if ($apartment->save() && $this->db->trans_status()) {
                $this->db->trans_commit();
                add_success_flash_message('Izba s ID <strong>' . $apartment->id . '</strong> bola úspešne aktualizovaná.');
                redirect(site_url('apartments'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Izbu s ID <strong>' . $apartment->id . '</strong> sa nepodarilo aktualizovať.');
                redirect(site_url('apartments/edit_apartment' . (int)$apartment->id));
            }
        } else {
            $this->db->trans_rollback();
            $this->edit_apartment($apartment_id);
        }
    }

    public function delete_apartment($apartment_id = NULL) {
        if (is_null($apartment_id)) {
            add_error_flash_message('Izba sa nenašla.');
            redirect(site_url('apartments'));
        }
        
        $apartment = new Apartment();
        $apartment->get_by_id((int)$apartment_id);
        
        if (!$apartment->exists()) {
            add_error_flash_message('Izba sa nenašla.');
            redirect(site_url('apartments'));
        }
        
        
        $success_message = 'Izba <strong>' . $apartment->title .'</strong> bola úspešne vymazaná.';
        $error_message = 'Izbu <strong>' . $apartment->tite . '</strong> sa nepodarilo vymazať.';
        
        if ($apartment->delete()) {
            unlink_recursive('user/photos/data/' . (int)$apartment_id . '/', TRUE);
            add_success_flash_message($success_message);
        } else {
            add_error_flash_message($error_message);
        }
        
        redirect(site_url('apartments'));
    }
	
    public function edit_photo($apartment_id = NULL) {
        if (is_null($apartment_id)) {
            add_error_flash_message('Izba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        $apartment = new Apartment();
        $apartment->get_by_id((int)$apartment_id);
        
        if (!$apartment->exists()) {
            add_error_flash_message('Izba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        $current_photo = base_url('user/photos/data/' . (int)$apartment->id . '/photo.png');
        if (!file_exists('user/photos/data/' . (int)$apartment->id . '/photo.png')) {
            $current_photo = base_url('user/photos/default/photo.png');
        }
        
        $this->parser->parse('web/controllers/apartments/edit_photo.tpl', array(
            'title' => 'Administrácia / Izby / Fotografia',
            'back_url' => site_url('apartments'),
            'form' => $this->get_photo_edit_form($current_photo),
            'apartment' => $apartment,
        ));
    }
    
    public function upload_photo($apartment_id = NULL) {
        if (is_null($apartment_id)) {
            add_error_flash_message('Izba sa nenašla.');
            redirect(site_url('apartments'));
        }
        
        $apartment = new Apartment();
        $apartment->get_by_id((int)$apartment_id);
        
        if (!$apartment->exists()) {
            add_error_flash_message('Izba sa nenašla.');
            redirect(site_url('apartments'));
        }
        
        
        $upload_config = array(
            'upload_path' => 'user/photos/data/' . (int)$apartment->id . '/',
            'allowed_types' => 'jpg|png',
            'max_size' => '1024',
            'max_width' => '1024',
            'max_height' => '1024',
            'file_name' => 'temp_photo.png',
            'overwrite' => TRUE,
        );
        $this->load->library('upload', $upload_config);
        @mkdir($upload_config['upload_path'], DIR_WRITE_MODE, TRUE);
        
        if ($this->upload->do_upload('photo')) {
            $resize_config = array(
                'image_library' => 'gd2',
                'source_image' => $upload_config['upload_path'] . $upload_config['file_name'],
                'create_thumb' => FALSE,
                'maintain_ratio' => TRUE,
                'width' => 256,
                'height' => 256,
                'quality' => '90%',
                'new_image' => $upload_config['upload_path'] . 'photo.png',
            );
            $this->load->library('image_lib', $resize_config);
            if ($this->image_lib->resize()) {
                $resize_config['width'] = 64;
                $resize_config['height'] = 64;        
                $resize_config['new_image'] = $upload_config['upload_path'] . 'photo_min.png';
                @unlink($upload_config['new_image']);
                $this->image_lib->initialize($resize_config);
                $this->image_lib->resize();
                @unlink($resize_config['source_image']);
                add_success_flash_message('Súbor úspešne nahraný.');
                redirect(site_url('apartments/edit_photo/' . (int)$apartment->id));
            } else {
                @unlink($resize_config['source_image']);
                add_error_flash_message('Súbor sa nepodarilo preškálovať:' . $this->image_lib->display_errors('<br /><br />', ''));
                redirect(site_url('apartments/edit_photo/' . (int)$apartment->id));
            }
        } else {
            add_error_flash_message('Súbor sa nepodarilo nahrať, vznikla nasledujúca chyba:' . $this->upload->display_errors('<br /><br />', ''));
            redirect(site_url('apartments/edit_photo/' . (int)$apartment->id));
        }
    }

     protected function get_form() {
        $form = array(
            'fields' => array(
                'title' => array(
                    'name' => 'apartment[title]',
                    'type' => 'text_input',
                    'label' => 'Nazov',
                    'id' => 'apartment-name',
                    'validation' => 'required',
                    'object_property' => 'title',
                ),
            ),
            'arangement' => array(
                'title'
            ),
        );
        return $form;
    }

    protected function get_edit_form($apartment = NULL) {
        $form = $this->get_form();
        return $form;
    }	
	
    protected function get_photo_edit_form($current_photo) {
        $form = array(
            'fields' => array(
                'current_photo' => array(
                    'type' => 'imagepreview',
                    'label' => 'Súčasná fotografia',
                    'path' => $current_photo,
                ),
                'photo' => array(
                    'type' => 'upload',
                    'label' => 'Nová fotografia',
                    'name' => 'photo',
                    'id' => 'photo',
                    'hint' => 'Fotografia vo formáte jpg alebo png.',
                ),
            ),
            'arangement' => array(
                'current_photo', 'photo',
            ),
        );
        return $form;
    }
}

?>
