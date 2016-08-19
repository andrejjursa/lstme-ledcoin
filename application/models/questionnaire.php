<?php

/**
 * Description of Questionnaire
 *
 * @author Andrej
 */
class Questionnaire extends DataMapper {

    const PATH_TO_UPLOAD_FOLDER = APPPATH . '..' . DIRECTORY_SEPARATOR . 'questionnaires' . DIRECTORY_SEPARATOR;

    public $table_name = 'questionnaires';

    /**
     * @return Questionnaire
     */
    public static function get_all_questionnaires()
    {
        $questionnaires = new Questionnaire();
        $questionnaires->get_iterated();
        return $questionnaires;
    }
}
