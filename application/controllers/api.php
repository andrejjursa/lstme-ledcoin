<?php
	class Api extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->library('datamapper');
        }

        public function bufet(){
			$this->load->helper('operations');

			return $this->output
	            ->set_content_type('application/json')
	            ->set_output(json_encode(array(
	                    'multiplier' => operations_ledcoin_multiplier()
	            )));
		}
	}

