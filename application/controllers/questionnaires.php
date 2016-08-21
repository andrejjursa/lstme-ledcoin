<?php

/**
 * Description of Questionnaires
 *
 * @author Andrej
 */
class Questionnaires extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('datamapper');
        $this->load->library('session');

        auth_redirect_if_not_admin('errormessage/no_admin');
    }

    public function index() {
        $this->load->helper('filter');

        $questionnaires = Questionnaire::get_all_questionnaires();

        $this->parser->parse('web/controllers/questionnaires/index.tpl',
            array(
                'title' => 'Administrácia / Dotazníky',
                'new_item_url' => site_url('questionnaires/new_questionnaire'),
                'questionnaires' => $questionnaires,
            )
        );
    }

    public function new_questionnaire() {
        $questionnaire_data = $this->input->post('questionnaire');

        $upload_temp_id = isset($questionnaire_data['upload_id']) ? $questionnaire_data['upload_id'] : Questionnaire::get_upload_temp_id();

        $this->parser->parse('web/controllers/questionnaires/new_questionnaire.tpl',
            array(
                'title' => 'Administrácia / Dotazníky / Nový dotazník',
                'back_url' => site_url('questionnaires'),
                'form' => $this->get_edit_form($upload_temp_id),
                'files' => $this->get_files($upload_temp_id),
            )
        );
    }

    public function create_questionnaire() {
        build_validator_from_form($this->get_edit_form());

        $questionnaire_data = $this->input->post('questionnaire');
        if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
            $this->upload_file($questionnaire_data['upload_id']);
            $this->new_questionnaire();
            return;
        }

        $this->db->trans_begin();

        if ($this->form_validation->run()) {
            $questionnaire = new Questionnaire();
            $questionnaire->from_array($questionnaire_data, array('title', 'configuration'));
            if (isset($questionnaire_data['published']) && (int)$questionnaire_data['published'] == 1) {
                $questionnaire->published = true;
            } else {
                $questionnaire->published = false;
            }
            if (isset($questionnaire_data['attempts']) && $questionnaire_data['attempts'] !== '') {
                $questionnaire->attempts = (int)$questionnaire_data['attempts'];
            } else {
                $questionnaire->attempts = null;
            }
            if ($questionnaire->save() && $this->rename_upload_folder($questionnaire_data['upload_id'], $questionnaire->id)) {
                $this->db->trans_commit();
                add_success_flash_message('Dotazník <strong>' . $questionnaire->title . '</strong> s ID <strong>' . $questionnaire->id . '</strong> bol úspešne vytvorený.');
                redirect(site_url('questionnaires'));
            } else {
                $this->db->trans_rollback();
                $this->delete_upload_folder($questionnaire_data['upload_id']);
                add_error_flash_message('Dotazník <strong>' . $questionnaire->title . '</strong> sa nepodarilo vytvoriť.');
                redirect(site_url('questionnaires/new_questionnaire'));
            }
        } else {
            $this->new_questionnaire();
        }
    }

    public function edit_questionnaire($id) {
        $questionnaire = new Questionnaire();
        $questionnaire->get_by_id((int)$id);
        if (!$questionnaire->exists()) {
            add_error_flash_message('Dotazník sa nenašiel.');
            redirect('questionnaires');
        }

        $this->parser->assign('questionnaire', $questionnaire);

        $this->parser->parse('web/controllers/questionnaires/edit_questionnaire.tpl',
            array(
                'title' => 'Administrácia / Dotazníky / Úprava dotazníka',
                'back_url' => site_url('questionnaires'),
                'form' => $this->get_edit_form($questionnaire->id),
                'files' => $this->get_files($questionnaire->id),
            )
        );
    }

    public function update_questionnaire($id) {
        $questionnaire = new Questionnaire();
        $questionnaire->get_by_id((int)$id);
        if (!$questionnaire->exists()) {
            add_error_flash_message('Dotazník sa nenašiel.');
            redirect('questionnaires');
        }

        build_validator_from_form($this->get_edit_form(null, $questionnaire));

        $questionnaire_data = $this->input->post('questionnaire');
        if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
            $this->upload_file($questionnaire->id);
            $this->edit_questionnaire($questionnaire->id);
            return;
        }

        $this->db->trans_begin();

        if ($this->form_validation->run()) {
            $questionnaire->from_array($questionnaire_data, array('title', 'configuration'));
            if (isset($questionnaire_data['published']) && (int)$questionnaire_data['published'] == 1) {
                $questionnaire->published = true;
            } else {
                $questionnaire->published = false;
            }
            if (isset($questionnaire_data['attempts']) && $questionnaire_data['attempts'] !== '') {
                $questionnaire->attempts = (int)$questionnaire_data['attempts'];
            } else {
                $questionnaire->attempts = null;
            }
            if ($questionnaire->save()) {
                $this->db->trans_commit();
                add_success_flash_message('Dotazník <strong>' . $questionnaire->title . '</strong> s ID <strong>' . $questionnaire->id . '</strong> bol úspešne upravený.');
                redirect(site_url('questionnaires'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Dotazník <strong>' . $questionnaire->title . '</strong> sa nepodarilo vytvoriť.');
                redirect(site_url('questionnaires/update_questionnaire/' . (int)$questionnaire->id));
            }
        } else {
            $this->edit_questionnaire($questionnaire->id);
        }
    }

    public function delete_questionnaire($id) {
        $questionnaire = new Questionnaire();
        $questionnaire->get_by_id((int)$id);
        if (!$questionnaire->exists()) {
            add_error_flash_message('Dotazník sa nenašiel.');
            redirect('questionnaires');
        }

        $questionnaire_answers = new Questionnaire_answer();
        $questionnaire_answers->where_related($questionnaire);
        $count_answers = $questionnaire_answers->count();

        if ($count_answers > 0) {
            add_error_flash_message(sprintf('Nie je možné vymazať dotazník <strong>%s</strong>, pretože obsahuje <strong>%d</strong> odpovedí.', $questionnaire->title, $count_answers));
            redirect('questionnaires');
        }

        $success_message = sprintf('Dotazník <strong>%s</strong> s id <strong>%d</strong> bol vymazaný.', $questionnaire->title, $questionnaire->id);
        $error_message = sprintf('Dotazník <strong>%s</strong> s id <strong>%d</strong> sa nepodarilo vymazať.', $questionnaire->title, $questionnaire->id);

        $folder_id = $questionnaire->id;

        if ($questionnaire->delete()) {
            $this->delete_upload_folder($folder_id);
            add_success_flash_message($success_message);
        } else {
            add_error_flash_message($error_message);
        }
        redirect('questionnaires');
    }

    public function show_questionnaire($id) {
        $questionnaire = new Questionnaire();
        $questionnaire->get_by_id((int)$id);
        if (!$questionnaire->exists()) {
            add_error_flash_message('Dotazník sa nenašiel.');
            redirect('questionnaires');
        }

        $form = $questionnaire->get_form_config();

        if (!empty($this->input->post())) {
            build_validator_from_form($form);
            $this->form_validation->run();
        }

        $this->parser->parse('web/controllers/questionnaires/show_questionnaire.tpl',
            array(
                'form' => $form,
                'title' => 'Administrácia / Dotazníky / Náhľad dotazníka',
                'back_url' => site_url('questionnaires'),
                'questionnaire' => $questionnaire,
            )
        );
    }

    public function download_questionnaire($id) {
        $questionnaire = new Questionnaire();
        $questionnaire->get_by_id((int)$id);
        if (!$questionnaire->exists()) {
            add_error_flash_message('Dotazník sa nenašiel.');
            redirect('questionnaires');
        }

        $questionnaire_answer_max = new Questionnaire_answer();
        $questionnaire_answer_max->select_func('MAX', '@answer_number', 'max_answer_number');
        $questionnaire_answer_max->where('${parent}.id', 'questionnaire_answers_subquery.id', false);

        $questionnaire_answers = new Questionnaire_answer();
        $questionnaire_answers->where_related($questionnaire);
        $questionnaire_answers->where_subquery('answer_number', $questionnaire_answer_max);
        $questionnaire_answers->include_related('person', array('name', 'surname', 'admin'));
        $questionnaire_answers->order_by_related('person', 'admin', 'asc');
        $questionnaire_answers->order_by_related('person', 'surname', 'asc');
        $questionnaire_answers->order_by_related('person', 'name', 'asc');
        $questionnaire_answers->get_iterated();

        $this->parser->parse('web/controllers/questionnaires/download_questionnaire.tpl', array(
            'questionnaire' => $questionnaire,
            'questionnaire_answers' => $questionnaire_answers,
        ));
    }

    protected function get_files($id) {
        $path = Questionnaire::PATH_TO_UPLOAD_FOLDER . $id . DIRECTORY_SEPARATOR;

        $output = array();

        if (file_exists($path) && is_dir($path)) {
            $files = scandir($path);

            if (is_array($files) && !empty($files)) {
                foreach ($files as $file) {
                    $full_path = $path . $file;
                    if (is_file($full_path)) {
                        $output[] = array(
                            'filename' => $file,
                            'link' => base_url($full_path),
                        );
                    }
                }
            }
        }

        return $output;
    }

    protected function get_edit_form($temp_id = null, $questionnaire = null) {
        $form = array(
            'fields' => array(
                'title' => array(
                    'name' => 'questionnaire[title]',
                    'type' => 'text_input',
                    'id' => 'questionnaire-title',
                    'label' => 'Názov',
                    'object_property' => 'title',
                    'validation' => 'required|is_unique[questionnaires.title]',
                ),
                'configuration' => array(
                    'name' => 'questionnaire[configuration]',
                    'type' => 'textarea',
                    'id' => 'questionnaire-configuration',
                    'label' => 'Konfigurácia',
                    'object_property' => 'configuration',
                    'validation' => 'required|callback__validate_configuration',
                    'monospace' => true,
                ),
                'published' => array(
                    'name' => 'questionnaire[published]',
                    'type' => 'flipswitch',
                    'id' => 'questionnaire-published',
                    'label' => 'Zverejnené',
                    'object_property' => 'published',
                    'value_off' => '0',
                    'text_off' => 'Nie',
                    'value_on' => '1',
                    'text_on' => 'Áno',
                    'default' => '0',
                    'hint' => 'Nezabudnite povoliť, aby bolo dotazník vidieť!',
                ),
                'attempts' => array(
                    'name' => 'questionnaire[attempts]',
                    'type' => 'text_input',
                    'id' => 'questionnaire-attempts',
                    'label' => 'Počet pokusov',
                    'placeholder' => 'Zadajte počet pokusov alebo nechajte prázdne pre neobmedzezne.',
                    'object_property' => 'attempts',
                    'validation' => array(
                        array(
                            'if-field-not-equals' => array('field' => 'questionnaire[attempts]', 'value' => ''),
                            'rules' => 'integer|greater_than[0]',
                        ),
                    ),
                ),
                'upload_id' => array(
                    'name' => 'questionnaire[upload_id]',
                    'type' => 'hidden',
                    'id' => 'questionnaire-upload_id',
                    'default' => $temp_id,
                ),
                'file' => array(
                    'name' => 'file',
                    'type' => 'upload',
                    'id' => 'file-id',
                    'label' => 'Nahrať obrázok',
                    'hint' => 'Povolené typy súborov sú: gif, png, jpeg',
                ),
            ),
            'arangement' => array(
                'title', 'configuration', 'published', 'attempts', 'upload_id', 'file'
            ),
        );

        if ($questionnaire instanceof Questionnaire) {
            $form['fields']['title']['validation'] = array(
                array(
                    'if-field-equals' => array('field' => 'questionnaire[title]', 'value' => $questionnaire->title),
                    'rules' => 'required',
                ),
                array(
                    'otherwise' => '',
                    'rules' => 'required|is_unique[questionnaires.title]',
                ),
            );
        }

        return $form;
    }

    public function _validate_configuration($string) {
        $error = '';
        if (!Questionnaire::is_configuration_valid($string, $error)) {
            $this->form_validation->set_message('_validate_configuration', $error);
            return false;
        }
        return true;
    }

    protected function upload_file($id) {
        $upload_config = array(
            'upload_path' => Questionnaire::PATH_TO_UPLOAD_FOLDER . $id . DIRECTORY_SEPARATOR,
            'allowed_types' => 'gif|jpg|png',
            'max_size' => '1024',
            'max_width' => '1024',
            'max_height' => '1024',
            'overwrite' => true,
        );

        $this->load->library('upload', $upload_config);
        @mkdir($upload_config['upload_path'], DIR_WRITE_MODE, TRUE);

        if ($this->upload->do_upload('file')) {
            add_success_flash_message('Súbor sa úspešne podarilo nahrať.');
            return true;
        } else {
            add_error_flash_message('Súbor sa nepodarilo nahrať, vznikla nasledujúca chyba:' . $this->upload->display_errors('<br /><br />', ''));
            return false;
        }
    }

    protected function rename_upload_folder($old_id, $new_id) {
        $old_folder = Questionnaire::PATH_TO_UPLOAD_FOLDER . $old_id;
        $new_folder = Questionnaire::PATH_TO_UPLOAD_FOLDER . $new_id;

        if (file_exists($old_folder) && is_dir($old_folder)) {
            if (!file_exists($new_folder)) {
                if (@rename($old_folder, $new_folder)) {
                    return true;
                }
            }
        } else {
            return true;
        }

        add_error_flash_message('Nie je možné premenovať adresár so súbormi. Pravdepodobne sa stratia všetky väzby na súbory.');
        return false;

    }

    protected function delete_upload_folder($id) {
        $path = Questionnaire::PATH_TO_UPLOAD_FOLDER . $id;

        @unlink_recursive($path, true);
    }

}