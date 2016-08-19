<?php
	
	/**
	 * Created by PhpStorm.
	 * User: andrej
	 * Date: 10.8.2015
	 * Time: 20:46
	 */
	class Limits extends CI_Controller {

		public function __construct() {
			parent::__construct();
            $this->load->database();
            $this->load->library('datamapper');
			$this->load->library('session');

			auth_redirect_if_not_admin('error/no_admin');
		}

		public function index() {
			$limits = new Limit();
			$limits->order_by('date', 'DESC');
			$limits->get_iterated();

			$this->parser->assign('limits', $limits);

			$this->parser->parse('web/controllers/limits/index.tpl', array('title' => 'Administrácia / Denné limity', 'new_item_url' => site_url('limits/new_limit')));
		}

		public function new_limit() {
			$this->parser->parse('web/controllers/limits/new_limit.tpl', array(
				'title' => 'Administrácia / Denné limity / Nový denný limit',
				'back_url' => site_url('limits'),
				'form' => $this->get_form(),
			));
		}

		public function create_limit() {
			build_validator_from_form($this->get_form());

			if ($this->form_validation->run()) {
				$this->db->trans_begin();
				$limit_data = $this->input->post('limit');
				$exists_limit = new Limit();
				$exists_limit->where('date', $limit_data['date']);
				$exists_limit->get();

				if ($exists_limit->exists()) {
					$this->db->trans_rollback();
					add_error_flash_message('Už existuje limit pre dátum <strong>' . date('d. m. Y', strtotime($limit_data['date'])) . '</strong>, preto nemožno vytvoriť nový.');
					redirect(site_url('limits'));
					return;
				}

				$limit = new Limit();
				$limit->from_array($limit_data, array('date', 'daily_limit'));
				if ($limit->save()) {
					$this->db->trans_commit();
					add_success_flash_message('Bol vytvorený limit pre dátum <strong>' . date('d. m. Y', strtotime($limit_data['date'])) . '</strong> s počtom <strong>' . $limit_data['daily_limit'] . '</strong> LEDCOIN-ov.');
				} else {
					$this->db->trans_rollback();
					add_error_flash_message('Nastala chyba pri zápise limitu do databázy.');
				}
				redirect(site_url('limits'));
			} else {
				$this->new_limit();
			}
		}

		public function edit_limit($limit_id = null) {
			if (is_null($limit_id)) {
				add_error_flash_message('Denný limit sa nenašiel.');
				redirect(site_url('limits'));
			}

			$limit = new Limit();
			$limit->get_by_id((int)$limit_id);

			if (!$limit->exists()) {
				add_error_flash_message('Denný limit sa nenašiel.');
				redirect(site_url('limits'));
			}

			$this->parser->assign('limit', $limit);
			$this->parser->parse('web/controllers/limits/edit_limit.tpl', array(
				'title' => 'Administrácia / Denné limity / Úprava denného limitu',
				'back_url' => site_url('limits'),
				'form' => $this->get_form(TRUE),
			));
		}

		public function update_limit($limit_id = null) {
			if (is_null($limit_id)) {
				add_error_flash_message('Denný limit sa nenašiel.');
				redirect(site_url('limits'));
			}

			$this->db->trans_begin();

			$limit = new Limit();
			$limit->get_by_id((int)$limit_id);

			if (!$limit->exists()) {
				$this->db->trans_rollback();
				add_error_flash_message('Denný limit sa nenašiel.');
				redirect(site_url('limits'));
			}

			if (date('Y-m-d') > $limit->date) {
				$this->db->trans_rollback();
				add_error_flash_message('Nie je povolené upravovať staršie limity ako dnešné.');
				redirect(site_url('limits'));
			}

			build_validator_from_form($this->get_form(TRUE));

			if ($this->form_validation->run()) {
				$limit_data = $this->input->post('limit');
				$limit->daily_limit = $limit_data['daily_limit'];
				if ($limit->save()) {
					$this->db->trans_commit();
					add_success_flash_message('Limit na dátum <strong>' . date('d. m. Y', strtotime($limit->date)) . '</strong> bol nastavený na <strong>' . $limit->daily_limit . '</strong> LEDCOIN-ov.');
				} else {
					$this->db->trans_rollback();
					add_error_flash_message('Limit na dátum <strong>' . date('d. m. Y', strtotime($limit->date)) . '</strong> sa nepodarilo uložiť pri úprave.');
				}
				redirect(site_url('limits'));
			} else {
				$this->db->trans_rollback();
				$this->edit_limit($limit_id);
			}
		}

		public function delete_limit($limit_id = null) {
			if (is_null($limit_id)) {
				add_error_flash_message('Denný limit sa nenašiel.');
				redirect(site_url('limits'));
			}

			$this->db->trans_begin();

			$limit = new Limit();
			$limit->get_by_id((int)$limit_id);

			if (!$limit->exists()) {
				$this->db->trans_rollback();
				add_error_flash_message('Denný limit sa nenašiel.');
				redirect(site_url('limits'));
			}

			if (date('Y-m-d') > $limit->date) {
				$this->db->trans_rollback();
				add_error_flash_message('Nie je povolené vymazávať staršie limity ako dnešné.');
				redirect(site_url('limits'));
			}

			$date = date('d. m. Y', strtotime($limit->date));
			$daily_limit = $limit->daily_limit;

			if ($limit->delete() && $this->db->trans_status()) {
				$this->db->trans_commit();
				add_success_flash_message('Limit s dátumom <strong>' . $date . '</strong> a hodnotou <strong>' . $daily_limit . '</strong> bol úspešne vymazaný.');
			} else {
				$this->db->trans_rollback();
				add_error_flash_message('Nepodarilo sa vymazať limit s dátumom <strong>' . $date . '</strong> a hodnotou <strong>' . $daily_limit . '</strong>!');
			}
			redirect(site_url('limits'));
		}

		private function get_form($edit = FALSE) {
			$form = array(
				'fields' => array(
					'date' => array(
						'name' => 'limit[date]',
						'type' => 'text_input',
						'id' => 'limit-date',
						'label' => 'Dátum',
						'object_property' => 'date',
						'role' => 'date',
						'role_config' => array(
							'date-format' => 'yy-mm-dd',
						),
						'validation' => 'required|callback__date_check',
						'validation_messages' => array(
							'_date_check' => 'Nesprávny formát alebo hodnota dátumu.',
						),
					),
					'daily_limit' => array(
						'name' => 'limit[daily_limit]',
						'type' => 'text_input',
						'id' => 'limit-daily_limit',
						'label' => 'Denný limit',
						'object_property' => 'daily_limit',
						'validation' => 'required|floatpoint|greater_than[0]',
					),
				),
				'arangement' => array(
					'date', 'daily_limit'
				),
			);
			if ($edit) {
				$form['fields']['date']['disabled'] = TRUE;
			}
			return $form;
		}

		public function _date_check($str) {
			if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $str)) {
				list($y, $m, $d) = explode('-', $str);
				if (checkdate($m, $d, $y)) {
					return TRUE;
				}
			}
			return FALSE;
		}
	}