<?php

use Symfony\Component\Yaml\Yaml;
use Knp\Bundle\MarkdownBundle\Parser\MarkdownParser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Description of Questionnaire
 *
 * @author Andrej
 */
class Questionnaire extends DataMapper {

    const PATH_TO_UPLOAD_FOLDER = APPPATH . '..' . DIRECTORY_SEPARATOR . 'questionnaires' . DIRECTORY_SEPARATOR;

    const KEY_QUESTIONS = 'questions';

    public $table_name = 'questionnaires';

    /**
     * @return array
     */
    public function get_form_config() {
        $form = array(
            'fields' => array(),
            'arangement' => array(),
        );

        if (!isset($this->configuration)) {
            return $form;
        }

        try {
            $parsed = Yaml::parse($this->configuration);
        } catch (ParseException $pe) {
            return $form;
        }

        if (!is_array($parsed) || !isset($parsed['questions']) || empty($parsed['questions'])) {
            return $form;
        }

        $types = self::get_question_types();

        $question_id = 0;

        foreach ($parsed['questions'] as $question) {
            if (!isset($question['type']) || !array_key_exists($question['type'], $types)) {
                continue;
            }

            $method = $types[$question['type']]['convertor'];

            $this->$method($form, $question, ++$question_id);
        }

        return $form;
    }

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

    public static function is_configuration_valid($configuration, &$error = '') {
        try {
            $parsed = Yaml::parse($configuration);
        } catch (ParseException $pe) {
            $error = $pe->getMessage();
            return false;
        }

        echo '<pre>' . htmlspecialchars(print_r($parsed, true)) . '</pre>';

        if (is_array($parsed)) {
            if (isset($parsed[self::KEY_QUESTIONS]) && is_array($parsed[self::KEY_QUESTIONS]) && !empty($parsed[self::KEY_QUESTIONS])) {
                return self::are_questions_valid($parsed[self::KEY_QUESTIONS], $error);
            } else {
                $error = 'Konfigurácia neobsahuje pole otázok.';
            }
        } else {
            $error = 'Konfigurácia sa nedá preložiť na pole.';
        }

        return false;
    }

    private static function are_questions_valid(array $questions, &$error = '') {
        $types = self::get_question_types();

        foreach ($questions as $int => $question) {
            if (!is_int($int)) {
                $error = 'Zoznam otázok nemôže byť asociatívne pole.';
                return false;
            }

            if (!is_array($question)) {
                $error = 'Otázka musí byť pole.';
                return false;
            }

            if (!isset($question['question']) || empty($question['question'])) {
                $error = 'Otázka musí obsahovať kľúč "question" s vyplnenou hodnotou.';
                return false;
            }

            if (!isset($question['type']) || empty($question['type'])) {
                $error = 'Otázka musí obsahovať kľúč "type" s vyplnenou hodnotou.';
                return false;
            }

            if (!array_key_exists($question['type'], $types)) {
                $error = 'Otázka typu "' . htmlspecialchars($question['type']) . '" neexistuje.';
                return false;
            }

            $callback = $types[$question['type']]['validator'];

            if (!self::$callback($question, $error)) {
                return false;
            }
        }

        return true;
    }

    private static function get_question_types() {
        return array(
            'input' => array(
                'validator' => 'validate_input',
                'convertor' => 'convert_input',
            ),
            'select' => array(
                'validator' => 'validate_select',
                'convertor' => 'convert_select',
            ),
        );
    }

    private function convert_input(&$form, &$question, $id) {
        if (!isset($question['question']) || !is_string($question['question']) || empty($question['question'])) {
            return;
        }

        $image = '';

        if (isset($question['image']) && file_exists(realpath(__DIR__ . '/../../' . self::PATH_TO_UPLOAD_FOLDER . $this->id . DIRECTORY_SEPARATOR . $question['image']))) {
            $image = '<br /><br /><img src="' . base_url(self::PATH_TO_UPLOAD_FOLDER . $this->id . DIRECTORY_SEPARATOR . $question['image']) . '" alt="" />';
        }

        $question_text = $this->markdown_parse($question['question']) . $image;

        $form['fields']['question_' . $id] = array(
            'type' => 'text_input',
            'name' => 'question[question_' . $id . ']',
            'id' => 'question-' . $id,
            'label' => 'Odpoveď',
            'validation' => 'required',
            'question_text' => $question_text,
        );
        $form['arangement'][] = 'question_' . $id;
    }

    private function convert_select(&$form, &$question, $id) {
        if (!isset($question['question']) || !is_string($question['question']) || empty($question['question'])) {
            return;
        }

        if (!isset($question['options']) || !is_array($question['options']) || empty($question['options'])) {
            return;
        }

        $image = '';

        if (isset($question['image']) && file_exists(realpath(__DIR__ . '/../../' . self::PATH_TO_UPLOAD_FOLDER . $this->id . DIRECTORY_SEPARATOR . $question['image']))) {
            $image = '<br /><br /><img src="' . base_url(self::PATH_TO_UPLOAD_FOLDER . $this->id . DIRECTORY_SEPARATOR . $question['image']) . '" alt="" />';
        }

        $question_text = $this->markdown_parse($question['question']) . $image;

        $multiple = isset($question['multiple']) ? $question['multiple'] : false;

        $parsedoptions = array();

        foreach ($question['options'] as $oid => $option) {
            if (is_array($option)) {
                if (!isset($option['text']) || !is_string($option['text']) || empty($option['text'])) {
                    continue;
                }

                $image = '';

                if (isset($option['image']) && file_exists(realpath(__DIR__ . '/../../' . self::PATH_TO_UPLOAD_FOLDER . $this->id . DIRECTORY_SEPARATOR . $option['image']))) {
                    $image = '<br /><br /><img src="' . base_url(self::PATH_TO_UPLOAD_FOLDER . $this->id . DIRECTORY_SEPARATOR . $option['image']) . '" alt="" />';
                }

                $parsedoptions[$oid] = $this->markdown_parse($option['text']) . $image;
            } else {
                if (!is_string($option) || empty($option)) {
                    continue;
                }
                $parsedoptions[$oid] = $this->markdown_parse($option);
            }
        }

        $form['fields']['question_' . $id] = array(
            'type' => $multiple ? 'checkboxes' : 'radios',
            'values' => $parsedoptions,
            'question_text' => $question_text,
            'id' => 'question-' . $id,
            'label' => 'Odpoveď',
            'name' => 'question[question_' . $id . ']',
            'validation' => 'required',
        );
        $form['arangement'][] = 'question_' . $id;
    }

    private function markdown_parse($text) {
        $output = MarkdownParser::defaultTransform($text);
        $output = $this->strip_tags($output);
        return $output;
    }

    private function strip_tags($html) {
        $output = str_replace('</p>', '</p>' . PHP_EOL . PHP_EOL, $html);
        $output = strip_tags($output, '<strong><i><u><em><b><br>');
        $output = nl2br(trim($output));
        return $output;
    }

    private static function validate_input($question, &$error = '') {
        if (!self::validate_question_text($question['question'], $error)) {
            return false;
        }

        if (isset($question['image']) && trim($question['image']) == '') {
            $error = 'Hodnota kľúča "image" nemôže byť prázdna v type "input".';
            return false;
        }


        $valid_keys = array('question', 'type', 'image');

        foreach ($question as $key => $value) {
            if (!in_array($key, $valid_keys)) {
                $error = 'Neznámy kľúč "' . htmlspecialchars($key) . '" v otázke typu "input".';
                return false;
            }
        }

        return true;
    }

    private static function validate_select($question, &$error = '') {
        if (!self::validate_question_text($question['question'], $error)) {
            return false;
        }

        if (isset($question['multiple']) && !is_bool($question['multiple'])) {
            $error = 'Položka "multiple" musí byť boolean (true alebo false).';
            return false;
        }

        if (!isset($question['options']) || !is_array($question['options']) || empty($question['options'])) {
            $error = 'Typ "select" musí obsahovať kľúč "options", ktorým musí byť neprázdne pole.';
            return false;
        }

        if (isset($question['image']) && trim($question['image']) == '') {
            $error = 'Hodnota kľúča "image" nemôže byť prázdna v type "select".';
            return false;
        }

        if (!self::validate_select_options($question['options'], $error)) {
            return false;
        }

        $valid_keys = array('question', 'type', 'multiple', 'options', 'image');

        foreach ($question as $key => $value) {
            if (!in_array($key, $valid_keys)) {
                $error = 'Neznámy kľúč "' . htmlspecialchars($key) . '" v otázke typu "select".';
                return false;
            }
        }

        return true;
    }

    private static function validate_select_options($options, &$error = '') {
        foreach ($options as $int => $option) {
            if (!is_int($int)) {
                $error = 'Zoznam možností nemôže byť asociatívne pole.';
                return false;
            }

            if (is_array($option)) {
                $valid_keys = array('text', 'image');

                if (!isset($option['text']) || trim($option['text']) == '') {
                    $error = 'Možnosť musí obsahovať kľúč "text" a tento nesmie byť prázdny.';
                    return false;
                }

                if (isset($option['image']) && trim($option['image']) == '') {
                    $error = 'Hodnota kľúča "image" nemôže byť prázdna v možnosti pre typ "select".';
                    return false;
                }

                foreach ($option as $key => $value) {
                    if (!in_array($key, $valid_keys)) {
                        $error = 'Neznámy kľúč "' . htmlspecialchars($key) . '" v možnosti pre typ "select".';
                        return false;
                    }
                }

            } else {
                if (trim($option) == '') {
                    $error = 'Textová hodnota možnosti nemôže byť prázdna.';
                    return false;
                }
            }
        }

        return true;
    }

    private static function validate_question_text($text, &$error = '') {
        if (trim($text) == '') {
            $error = 'Text otázky nemôže byť prázdny.';
            return false;
        }

        return true;
    }
}
