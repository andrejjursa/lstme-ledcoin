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

    public static function get_upload_temp_id()
    {
        $path = Questionnaire::PATH_TO_UPLOAD_FOLDER;
        do {
            $temp_id = 'temp_' . substr(sha1(date('U') . memory_get_usage(true)), rand(0, 31), 8);
        } while (file_exists($path . $temp_id));
        return $temp_id;
    }
}
