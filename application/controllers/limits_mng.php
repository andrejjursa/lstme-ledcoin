<?php
	
	/**
	 * Created by PhpStorm.
	 * User: andrej
	 * Date: 10.8.2015
	 * Time: 20:46
	 */
	class Limits_mng extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->load->library('session');

			auth_redirect_if_not_admin('error/no_admin');
		}

		public function index() {
			$limits = new Limits();
			$limits->order_by('daily_limit', 'ASC');
			$limits->get_iterated();

			$this->parser->assign('limits', $limits);

			$this->parser->parse('web/controllers/limits_mng/index.tpl', array('title' => 'Administrácia / Denné limity', 'new_item_url' => site_url('limits_mng/new_limit')));
		}
	}