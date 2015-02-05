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
class Persons extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        auth_redirect_if_not_admin('error/no_admin');
    }

    public function index() {
        $this->load->helper('filter');
                
        $persons = new Person();
        $persons->include_related('group', 'title');
        $persons->order_by('admin', 'asc')->order_by_related('group', 'title', 'asc')->order_by('name', 'asc');
        $persons->get_iterated();
        
        $this->parser->parse('web/controllers/persons/index.tpl', array('title' => 'Administrácia / Ľudia', 'persons' => $persons, 'new_item_url' => site_url('persons/new_person')));
    }
    
    public function new_person() {
        $this->parser->parse('web/controllers/persons/new_person.tpl', array('title' => 'Administrácia / Ľudia / Nový človek', 'back_url' => site_url('persons'), 'form' => $this->get_form()));
    }
    
    public function create_person() {
        $form = $this->get_form();
        build_validator_from_form($form);
        
        if ($this->form_validation->run()) {
            $this->db->trans_begin();
            $person_data = $this->input->post('person');
            
            $person = new Person();
            $person->from_array($person_data, array('name', 'surname', 'login', 'organisation', 'admin'));
            $person->password = sha1($person_data['password']);
            $person->enabled = 1;
            
            $group = new Group();
            $group->get_by_id((int)$person_data['group_id']);
            
            if ($person->save($group) && $this->db->trans_status()) {
                $this->db->trans_commit();
                add_success_flash_message('Osoba menom <strong>' . $person_data['name'] . ' ' . $person_data['surname'] . '</strong> s loginom <strong>' . $person_data['login'] . '</strong> bola vytvorená s ID <strong>' . $person->id . '</strong>.');
                redirect(site_url('persons'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Osobu sa nepodarilo vytvoriť, skúste to znovu neskôr.');
                redirect(site_url('persons/new_person'));
            }
        } else {
            $this->new_person();
        }
    }
    
    public function edit_person($person_id = NULL) {
        if (is_null($person_id)) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        $person = new Person();
        $person->get_by_id((int)$person_id);
        
        if (!$person->exists()) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        $this->parser->assign('person', $person);
        
        $this->parser->parse('web/controllers/persons/edit_person.tpl', array('title' => 'Administrácia / Ľudia / Úprava osoby', 'back_url' => site_url('persons'), 'form' => $this->get_edit_form()));
    }
    
    public function update_person($person_id = NULL) {
        if (is_null($person_id)) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        $this->db->trans_begin();
        $person = new Person();
        $person->get_by_id((int)$person_id);
        
        if (!$person->exists()) {
            $this->db->trans_rollback();
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        $form = $this->get_edit_form($person);
        build_validator_from_form($form);
        
        if ($this->form_validation->run()) {
            $person_data = $this->input->post('person');
            if (auth_get_id() == $person->id && $person_data['admin'] != 1) {
                $this->db->trans_rollback();
                add_error_flash_message('Nie je možné odobrať oprávnenie administrátora vlastnému účtu.');
                redirect(site_url('persons/edit_person/' . $person->id));
            } 
            if (auth_get_id() == $person->id && $person_data['enabled'] != 1) {
                $this->db->trans_rollback();
                add_error_flash_message('Nie je možné odobrať oprávnenie na prihlasovanie sa vlastnému účtu.');
                redirect(site_url('persons/edit_person/' . $person->id));
            }
            if ($person_data['password'] != '') {
                $person->password = sha1($person_data['password']);
            }
            $person->from_array($person_data, array('name', 'surname', 'login', 'organisation', 'admin', 'enabled', 'number', 'email')); //edit
            
            $group = new Group();
            if ($person_data['group_id'] != '') {
                $group->get_by_id((int)$person_data['group_id']);
            }
            
            if ($person->save($group) && $this->db->trans_status()) {
                $this->db->trans_commit();
                add_success_flash_message('Osoba s ID <strong>' . $person->id . '</strong> bola úspešne aktualizovaná.');
                redirect(site_url('persons'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Osobu s ID <strong>' . $person->id . '</strong> sa nepodarilo aktualizovať.');
                redirect(site_url('persons/edit_person/' . (int)$person->id));
            }
        } else {
            $this->db->trans_rollback();
            $this->edit_person($person_id);
        }
    }

    public function delete_person($person_id = NULL) {
        if (is_null($person_id)) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        $person = new Person();
        $person->get_by_id((int)$person_id);
        
        if (!$person->exists()) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        if ($person->id == auth_get_id()) {
            add_error_flash_message('Nemôžete vymazať vlastný účet.');
            redirect(site_url('persons'));
        }
        
        $success_message = 'Osoba <strong>' . $person->name . ' ' . $person->surname . '</strong> s loginom <strong>' . $person->login . '</strong>, a s ID <strong>' . $person->id . '</strong> bola úspešne vymazaná.';
        $error_message = 'Osobu <strong>' . $person->name . ' ' . $person->surname . '</strong> s loginom <strong>' . $person->login . '</strong>, a s ID <strong>' . $person->id . '</strong> sa nepodarilo vymazať.';
        
        if ($person->delete()) {
            unlink_recursive('user/photos/data/' . (int)$person_id . '/', TRUE);
            add_success_flash_message($success_message);
        } else {
            add_error_flash_message($error_message);
        }
        
        redirect(site_url('persons'));
    }
    
    public function edit_photo($person_id = NULL) {
        if (is_null($person_id)) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        $person = new Person();
        $person->get_by_id((int)$person_id);
        
        if (!$person->exists()) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        $current_photo = base_url('user/photos/data/' . (int)$person->id . '/photo.png');
        if (!file_exists('user/photos/data/' . (int)$person->id . '/photo.png')) {
            $current_photo = base_url('user/photos/default/photo.png');
        }
        
        $this->parser->parse('web/controllers/persons/edit_photo.tpl', array(
            'title' => 'Administrácia / Ľudia / Fotografia',
            'back_url' => site_url('persons'),
            'form' => $this->get_photo_edit_form($current_photo),
            'person' => $person,
        ));
    }
    
    public function upload_photo($person_id = NULL) {
        if (is_null($person_id)) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        $person = new Person();
        $person->get_by_id((int)$person_id);
        
        if (!$person->exists()) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('persons'));
        }
        
        
        $upload_config = array(
            'upload_path' => 'user/photos/data/' . (int)$person->id . '/',
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
                redirect(site_url('persons/edit_photo/' . (int)$person->id));
            } else {
                @unlink($resize_config['source_image']);
                add_error_flash_message('Súbor sa nepodarilo preškálovať:' . $this->image_lib->display_errors('<br /><br />', ''));
                redirect(site_url('persons/edit_photo/' . (int)$person->id));
            }
        } else {
            add_error_flash_message('Súbor sa nepodarilo nahrať, vznikla nasledujúca chyba:' . $this->upload->display_errors('<br /><br />', ''));
            redirect(site_url('persons/edit_photo/' . (int)$person->id));
        }
    }
    
    protected function get_form() {
        $groups = new Group();
        $groups->order_by('title', 'asc');
        $groups->get_iterated();
        
        $groups_to_form = array(
            '' => '',
        );
        
        foreach ($groups as $group) {
            $groups_to_form[$group->id] = $group->title;
        }
        
        $form = array(
            'fields' => array(
                'name' => array(
                    'name' => 'person[name]',
                    'type' => 'text_input',
                    'label' => 'Meno',
                    'id' => 'person-name',
                    'validation' => 'required',
                    'object_property' => 'name',
                ),
                'surname' => array(
                    'name' => 'person[surname]',
                    'type' => 'text_input',
                    'label' => 'Priezvisko',
                    'id' => 'person-surname',
                    'validation' => 'required',
                    'object_property' => 'surname',
                ),
                'login' => array(
                    'name' => 'person[login]',
                    'type' => 'text_input',
                    'label' => 'Prihlasovacie meno',
                    'id' => 'person-login',
                    'validation' => 'required|is_unique[persons.login]',
                    'object_property' => 'login',
                ),
                'password' => array(
                    'name' => 'person[password]',
                    'type' => 'password_input',
                    'label' => 'Heslo',
                    'id' => 'person-password',
                    'validation' => 'required|min_length[6]|max_length[20]',
                ),
                'password_check' => array(
                    'name' => 'person_password_check',
                    'type' => 'password_input',
                    'label' => 'Heslo pre kontrolu',
                    'id' => 'person_password_check',
                    'hint' => 'Heslá sa musia zhodovať.',
                    'validation' => 'required|matches[person[password]]',
                ),
                'organisation' => array(
                    'name' => 'person[organisation]',
                    'type' => 'text_input',
                    'label' => 'Škola / organizácia',
                    'id' => 'person-organisation',
                    'validation' => 'required',
                    'object_property' => 'organisation',
                ),
                'group_id' => array(
                    'name' => 'person[group_id]',
                    'type' => 'select',
                    'label' => 'Skupina',
                    'id' => 'person-group_id',
                    'values' => $groups_to_form,
                    'validation' => array(
                        array(
                            'if-field-equals' => array('field' => 'person[admin]', 'value' => '0'),
                            'rules' => 'required',
                        ),
                    ),
                    'object_property' => 'group_id',
                ),
                'admin' => array(
                    'name' => 'person[admin]',
                    'type' => 'flipswitch',
                    'label' => 'Administrátor',
                    'value_off' => '0',
                    'text_off' => 'Nie',
                    'value_on' => '1',
                    'text_on' => 'Áno',
                    'id' => 'person-admin',
                    'default' => '0',
                    'object_property' => 'admin',
                    'hint' => 'Administrátor spravuje všetok obsah a udeluje strojový čas, nedávajte tieto práva účastníkom!',
                ),
				'number' => array(  //edit
                    'name' => 'person[number]',
                    'type' => 'text_input',
                    'label' => 'Telefónne čislo',
                    'id' => 'person-number',
                    'object_property' => 'number',
                ),
				'email' => array(
                    'name' => 'person[email]',
                    'type' => 'text_input',
                    'label' => 'Email',
                    'id' => 'person-email',
                    'object_property' => 'email',
                ),
            ),
            'arangement' => array(
                'name', 'surname', 'login', 'password', 'password_check', 'organisation', 'group_id', 'admin', 'number', 'email'
            ),
        );
        return $form;
    }
    
    protected function get_edit_form($person = NULL) {
        $form = $this->get_form();
        $form['fields']['password']['validation'] = array(
            array(
                'if-field-not-equals' => array('field' => 'person[password]', 'value' => ''),
                'rules' => 'required|min_length[6]|max_length[20]',
            ),
        );
        $form['fields']['password']['hint'] = 'Heslá vypisujte iba v prípade ak ich chcete zmeniť.';
        $form['fields']['password_check']['validation'] = array(
            array(
                'if-field-not-equals' => array('field' => 'person[password]', 'value' => ''),
                'rules' => 'required|matches[person[password]]',
            ),
        );
        if ($person instanceof Person) {
            $form['fields']['login']['validation'] = array(
                array(
                    'if-field-equals' => array('field' => 'person[login]', 'value' => $person->login),
                    'rules' => 'required',
                ),
                array(
                    'otherwise' => '',
                    'rules' => 'required|is_unique[persons.login]',
                ),
            );
        }
        $form['fields']['enabled'] = array(
            'name' => 'person[enabled]',
            'type' => 'flipswitch',
            'label' => 'Povolenie prihlásenia',
            'value_off' => '0',
            'text_off' => 'Nie',
            'value_on' => '1',
            'text_on' => 'Áno',
            'id' => 'person-enabled',
            'default' => '1',
            'object_property' => 'enabled',
            'hint' => 'Zakázaním prihlásenia odopriete tejto osobe prístup k aplikácii.',
        );
        $form['arangement'][] = 'enabled';
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
