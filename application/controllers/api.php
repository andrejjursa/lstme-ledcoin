<?php
	class Api extends CI_Controller {
		public function bufet(){
			$this->load->helper('operations');

			return $this->output
	            ->set_content_type('application/json')
	            ->set_output(json_encode(array(
	                    'multiplier' => operations_ledcoin_multiplier()
	            )));
		}
	}

