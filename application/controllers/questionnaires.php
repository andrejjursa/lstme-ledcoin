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

        $upload_temp_id = $this->get_upload_temp_id();

        $this->parser->parse('web/controllers/questionnaires/new_questionnaire.tpl',
            array(
                'title' => 'Administrácia / Dotazníky / Nový dotazník',
                'back_url' => site_url('questionnaires'),
                'form' => $this->get_edit_form(),
            )
        );
    }

    public function get_edit_form() {
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
            ),
            'arangement' => array(
                'title',
            ),
        );
        return $form;
    }

    protected function get_upload_temp_id() {
        $path = Questionnaire::PATH_TO_UPLOAD_FOLDER;
        do {
            $temp_id = substr(sha1(date('U') . memory_get_usage(true)), rand(0,31), 8);
        } while (file_exists($path . 'temp_' . $temp_id));
        return $temp_id;
    }

}