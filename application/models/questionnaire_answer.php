<?php


/**
 * Description of Questionnaire_answer
 *
 * @author Andrej
 */
class Questionnaire_answer extends DataMapper {

    public $has_one = array('questionnaire', 'person');

}
