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

        auth_redirect_if_not_admin('error/no_admin');
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

        $upload_temp_id = isset($questionnaire_data['upload_id']) ? $questionnaire_data['upload_id'] : $this->get_upload_temp_id();

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
                    'validation' => 'required',
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

        if (file_exists($old_folder) && is_dir($old_folder) && !file_exists($new_folder)) {
            if (@rename($old_folder, $new_folder)) {
                return true;
            }
        }

        add_error_flash_message('Nie je možné premenovať adresár so súbormi. Pravdepodobne sa stratia všetky väzby na súbory.');
        return false;

    }

    protected function get_upload_temp_id() {
        $path = Questionnaire::PATH_TO_UPLOAD_FOLDER;
        do {
            $temp_id = 'temp_' . substr(sha1(date('U') . memory_get_usage(true)), rand(0,31), 8);
        } while (file_exists($path . $temp_id));
        return $temp_id;
    }

    protected function delete_upload_folder($id) {
        $path = Questionnaire::PATH_TO_UPLOAD_FOLDER . $id;

        @unlink_recursive($path, true);
    }

}