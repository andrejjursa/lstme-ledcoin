<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of persons
 *
 * @author Andrej
 * @edit Ferdinand Križan
 */
class Notes extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        auth_redirect_if_not_admin('error/no_admin');
    }

	public function index() {
        $this->load->helper('filter');
              
        $notes = new Program();
        $notes->order_by('datum_pridania', 'desc');
        $notes->get_iterated();
        
        $this->parser->parse('web/controllers/notes/index.tpl', array(
            'title' => 'Administrácia / Denný program',
            'new_item_url' => site_url('notes/new_notes'),
            'notes' => $notes,
        ));        
    }
	
	public function new_notes() {
        $this->parser->parse('web/controllers/notes/new_note.tpl', array('title' => 'Administrácia / Denný program / Nový záznam', 'back_url' => site_url('notes'), 'form' => $this->get_form()));
    }
	
	public function create_notes() {
        $form = $this->get_form();
        build_validator_from_form($form);
        
        if ($this->form_validation->run()) {
            $this->db->trans_begin();
            $notes_data = $this->input->post('note');
            
            $notes = new Program();
            $notes->from_array($notes_data, array('time', 'date', 'action_name', 'text'));
            
            if ($notes->save() && $this->db->trans_status()) {
                $this->db->trans_commit();
                add_success_flash_message('Udalosť s názvom <strong>' . $notes_data['action_name'] . '</strong> bola vytvorená.');
                redirect(site_url('notes'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Udalosť sa nepodarilo vytvoriť, skúste to znovu neskôr.');
                redirect(site_url('notes'));
            }
        } else {
            $this->new_notes();
        }
    }
	
    public function delete_note($note_id = NULL) {
        if (is_null($note_id)) {
            add_error_flash_message('Udalosť sa nenašla.');
            redirect(site_url('notes'));
        }
        
        $notes = new Program();

        $notes->get_by_id((int)$note_id);
		//$notes->where('program.id', $note_id);
		//print_r($notes);
        //die();		

        if (!$notes->exists()) {
            add_error_flash_message('Udalosť sa nenašla.');
            redirect(site_url('notes'));
        }
        
        
        $success_message = 'Udalosť <strong>' . $notes->action_name .'</strong> bola úspešne vymazaná.';
        $error_message = 'Udalosť <strong>' . $notes->action_name . '</strong> sa nepodarilo vymazať.';
        
        if ($notes->delete()) {
            add_success_flash_message($success_message);
        } else {
            add_error_flash_message($error_message);
        }
        
        redirect(site_url('notes'));
    }
	
    public function edit_note($note_id = NULL) {
        if (is_null($note_id)) {
            add_error_flash_message('Udalosť sa nenašla.');
            redirect(site_url('notes'));
        }
        
        $note = new Program();
        $note->get_by_id((int)$note_id);
        
        if (!$note->exists()) {
            add_error_flash_message('Udalosť sa nenašla.');
            redirect(site_url('notes'));
        }
        
        $this->parser->assign('note', $note);
        
        $this->parser->parse('web/controllers/notes/edit_note.tpl', array('title' => 'Administrácia / Denný program / Úprava programu', 'back_url' => site_url('notes'), 'form' => $this->get_form()));
    }
    
    public function update_note($note_id = NULL) {
        if (is_null($note_id)) {
            add_error_flash_message('Udalosť sa nenašla.');
            redirect(site_url('notes'));
        }
        
        $this->db->trans_begin();
        $note = new Program();
        $note->get_by_id((int)$note_id);
        
        if (!$note->exists()) {
            $this->db->trans_rollback();
            add_error_flash_message('Udalosť sa nenašla.');
            redirect(site_url('notes'));
        }
        
        $form = $this->get_form($note);
        build_validator_from_form($form);
        
        if ($this->form_validation->run()) {
            $note_data = $this->input->post('note');

            $note->from_array($note_data, array('time', 'date', 'action_name', 'text'));

            if ($note->save() && $this->db->trans_status()) {
                $this->db->trans_commit();
                add_success_flash_message('Udalosť <strong>' . $note->action_name . '</strong> bola úspešne aktualizovaná.');
                redirect(site_url('notes'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Udalosť <strong>' . $note->action_name . '</strong> sa nepodarilo aktualizovať.');
                redirect(site_url('notes/edit_note' . (int)$note->id));
            }
        } else {
            $this->db->trans_rollback();
            $this->edit_note($note_id);
        }
    }
	
     protected function get_form() {
        $form = array(
            'fields' => array(
                'time' => array(
                    'name' => 'note[time]',
                    'type' => 'text_input',
                    'label' => 'Čas',
                    'id' => 'note-time',
                    'validation' => 'required',
                    'object_property' => 'time',
                ),                
				'date' => array(
                    'name' => 'note[date]',
                    'type' => 'text_input',
                    'label' => 'Dátum',
                    'id' => 'note-date',
                    'validation' => 'required',
                    'object_property' => 'date',
                ),
                'action_name' => array(
                    'name' => 'note[action_name]',
                    'type' => 'text_input',
                    'label' => 'Názov',
                    'id' => 'note-name',
                    'validation' => 'required',
                    'object_property' => 'action_name',
                ),  
				'text' => array(
                    'name' => 'note[text]',
                    'type' => 'text_input',
                    'label' => 'Text',
                    'id' => 'note-text',
                    'validation' => 'required',
                    'object_property' => 'text',
                ),  
            ),
            'arangement' => array(
                'time', 'date', 'action_name', 'text'
            ),
        );
        return $form;
    }


}