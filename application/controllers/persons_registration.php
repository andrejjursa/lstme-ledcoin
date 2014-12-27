<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of persons
 *
 */
class Persons_registration extends CI_Controller {
    
// new registration	
    public function new_reg_person() {
        $this->parser->parse('web/controllers/registration/reg.tpl', array('title' => 'Registrácia', 'back_url' => site_url('/'), 'form' => $this->get_form_reg()));
    }
    
    public function reg_person() {
        $form = $this->get_form_reg();
        build_validator_from_form($form);
        
        if ($this->form_validation->run()) {
            $this->db->trans_begin();
            $person_data = $this->input->post('person');

            $person = new Person();
            $person->from_array($person_data, array('name', 'surname', 'login', 'organisation', 'admin', 'number', 'email'));
            $person->password = sha1($person_data['password']);
            $person->enabled = 1;
			$person->admin = 0;
			//$person->email = 'pokus@pokus.sk';
            
            $group = new Group();
            $group->get_by_id((int)$person_data['group_id']);
            
            if ($person->save($group) && $this->db->trans_status()) {
                $this->db->trans_commit();
                add_success_flash_message('Registrácia prebehla úspešne. <strong> ' . $person_data['name'] . ' ' . $person_data['surname'] . '</strong>, teraz sa môžeš prihlásiť. Tvoje prihlasovacie meno je <strong>' . $person_data['login']);
                redirect(site_url('/'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Osobu sa nepodarilo vytvoriť, skúste to znovu neskôr.');
                redirect(site_url('registration/reg'));
            }
        } else {
            $this->new_reg_person();
        }
    }
    
// refistration	
    protected function get_form_reg() {
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
                    'label' => 'Meno*',
                    'id' => 'person-name',
                    'validation' => 'required',
                    'object_property' => 'name',
                ),
                'surname' => array(
                    'name' => 'person[surname]',
                    'type' => 'text_input',
                    'label' => 'Priezvisko*',
                    'id' => 'person-surname',
                    'validation' => 'required',
                    'object_property' => 'surname',
                ),
                'login' => array(
                    'name' => 'person[login]',
                    'type' => 'text_input',
                    'label' => 'Prihlasovacie meno*',
                    'id' => 'person-login',
                    'validation' => 'required|is_unique[persons.login]',
                    'object_property' => 'login',
                ),
                'password' => array(
                    'name' => 'person[password]',
                    'type' => 'password_input',
                    'label' => 'Heslo*',
                    'id' => 'person-password',
                    'validation' => 'required|min_length[6]|max_length[20]',
                ),
                'password_check' => array(
                    'name' => 'person_password_check',
                    'type' => 'password_input',
                    'label' => 'Heslo pre kontrolu*',
                    'id' => 'person_password_check',
                    'hint' => 'Heslá sa musia zhodovať.',
                    'validation' => 'required|matches[person[password]]',
                ),
                'organisation' => array(
                    'name' => 'person[organisation]',
                    'type' => 'text_input',
                    'label' => 'Škola / organizácia*',
                    'id' => 'person-organisation',
                    'validation' => 'required',
                    'object_property' => 'organisation',
                ),
                'group_id' => array(
                    'name' => 'person[group_id]',
                    'type' => 'select',
                    'label' => 'Skupina*',
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
				'number' => array(
                    'name' => 'person[number]',
                    'type' => 'text_input',
                    'label' => 'Telefónne čislo',
                    'id' => 'person-number',
                    'object_property' => 'number',
					'hint' => 'Tento údaj je nepovinný.',
                ),
				'email' => array(
                    'name' => 'person[email]',
                    'type' => 'text_input',
                    'label' => 'Email',
                    'id' => 'person-email',
                    'object_property' => 'email',
					'hint' => 'Tento údaj je nepovinný.',
                ),
            ),
            'arangement' => array(
                'name', 'surname', 'login', 'password', 'password_check', 'organisation', 'group_id', 'admin', 'number', 'email'
            ),
        );
        return $form;   
	}
}

?>
