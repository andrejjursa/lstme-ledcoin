<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of persons
 *
 * @author Andrej
 * @edit Ferdinand Križan
 */
class Points extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        auth_redirect_if_not_admin('error/no_admin');
    }
    
    public function index() {
        $this->load->helper('filter');
        
        $operations_addition = new Operation();
        $operations_addition->where('type', Operation::TYPE_ADDITION);
        $operations_addition->select_sum('time', 'time_sum');
        $operations_addition->where_related_person('id', '${parent}.id');

        $operations_subtraction_direct = new Operation();
        $operations_subtraction_direct->where('type', Operation::TYPE_SUBTRACTION);
        $operations_subtraction_direct->where('subtraction_type', Operation::SUBTRACTION_TYPE_DIRECT);
        $operations_subtraction_direct->select_sum('time', 'time_sum');
        $operations_subtraction_direct->where_related_person('id', '${parent}.id');

        $operations_subtraction_products = new Operation();
        $operations_subtraction_products->where('type', Operation::TYPE_SUBTRACTION);
        $operations_subtraction_products->where('subtraction_type', Operation::SUBTRACTION_TYPE_PRODUCTS);
        $operations_subtraction_products->where_related('product_quantity', 'price >', 0);
        $operations_subtraction_products->group_start(' NOT', 'AND');
        $operations_subtraction_products->where_related('product_quantity', 'product_id', NULL);
        $operations_subtraction_products->group_end();
        unset($operations_subtraction_products->db->ar_select[0]);
        $operations_subtraction_products->select_func('SUM', array('@product_quantities.quantity', '*', '@product_quantities.price'), 'time_sum');
        $operations_subtraction_products->where_related_person('id', '${parent}.id');

        $operations_subtraction_services = new Operation();
        $operations_subtraction_services->where('type', Operation::TYPE_SUBTRACTION);
        $operations_subtraction_services->where('subtraction_type', Operation::SUBTRACTION_TYPE_SERVICES);
        $operations_subtraction_services->where_related('service_usage', 'price >', 0);
        $operations_subtraction_services->group_start(' NOT', 'AND');
        $operations_subtraction_services->where_related('service_usage', 'service_id', NULL);
        $operations_subtraction_services->group_end();
        unset($operations_subtraction_services->db->ar_select[0]);
        $operations_subtraction_services->select_func('SUM', array('@service_usages.quantity', '*', '@service_usages.price'), 'time_sum');
        $operations_subtraction_services->where_related_person('id', '${parent}.id');

        $apartments = new Apartment();
        $apartments->select('*');
        $apartments->select_subquery($operations_addition, 'plus_time');
        $apartments->select_subquery($operations_subtraction_direct, 'minus_time_direct');
        $apartments->select_subquery($operations_subtraction_products, 'minus_time_products');
        $apartments->select_subquery($operations_subtraction_services, 'minus_time_services');
		$apartments->get_iterated();
        
        $this->parser->parse('web/controllers/points/index.tpl', array(
            'title' => 'Administrácia / Izby / Bodovanie izieb',
            'apartments' => $apartments,
        ));
    }
    
    public function new_operation($type_override = NULL, $person_id_override = NULL) {
        $this->load->helper('filter');
        
        $operation_data = $this->input->post('operation'); //?
		
        if (!is_null($type_override) && ($type_override == Operation::TYPE_ADDITION || $type_override == Operation::TYPE_SUBTRACTION)) {
            $operation_data['type'] = $type_override;
            $_POST['operation']['type'] = $type_override;
        }
        
        if (!is_null($person_id_override)) {
            $apartments = new Apartment();
            //$person->where('admin', 0);
            $apartments->get_by_id((int)$person_id_override);
            if ($apartments->exists()) {
                $_POST['operation']['person_id'] = $apartments->id;
            }
        }
        
        $this->parser->parse('web/controllers/points/new_operation.tpl', array(
            'title' => 'Administrácia / Bodovanie izieb / Nový záznam',
            'back_url' => site_url('points'),
            'form' => $this->get_form(@$operation_data['type'], @$operation_data['subtraction_type']),
            'subtype' => @$operation_data['subtraction_type'],
            'type' => @$operation_data['type'],
        ));
    }
    
    public function create_operation() {
        $operation_data_temp = $this->input->post('operation');  //?
        
        $this->db->trans_begin();
        $form = $this->get_form(@$operation_data_temp['type'], @$operation_data_temp['subtraction_type']);
        build_validator_from_form($form);
        if ($this->form_validation->run()) {
            $operation_data = $this->input->post('operation');
            //$operation_service_data = $this->input->post('operation_service');
            //$operation_product_data = $this->input->post('operation_product');
            
            $operations_addition = new Operation();
            $operations_addition->where('type', Operation::TYPE_ADDITION);
            $operations_addition->select_sum('time', 'time_sum');
            $operations_addition->where_related_person('id', '${parent}.id');

            $operations_subtraction_direct = new Operation();
            $operations_subtraction_direct->where('type', Operation::TYPE_SUBTRACTION);
            $operations_subtraction_direct->where('subtraction_type', Operation::SUBTRACTION_TYPE_DIRECT);
            $operations_subtraction_direct->select_sum('time', 'time_sum');
            $operations_subtraction_direct->where_related_person('id', '${parent}.id');
/*
            $operations_subtraction_products = new Operation();
            $operations_subtraction_products->where('type', Operation::TYPE_SUBTRACTION);
            $operations_subtraction_products->where('subtraction_type', Operation::SUBTRACTION_TYPE_PRODUCTS);
            $operations_subtraction_products->where_related('product_quantity', 'price >', 0);
            $operations_subtraction_products->group_start(' NOT', 'AND');
            $operations_subtraction_products->where_related('product_quantity', 'product_id', NULL);
            $operations_subtraction_products->group_end();
            unset($operations_subtraction_products->db->ar_select[0]);
            $operations_subtraction_products->select_func('SUM', array('@product_quantities.quantity', '*', '@product_quantities.price'), 'time_sum');
            $operations_subtraction_products->where_related_person('id', '${parent}.id');

            $operations_subtraction_services = new Operation();
            $operations_subtraction_services->where('type', Operation::TYPE_SUBTRACTION);
            $operations_subtraction_services->where('subtraction_type', Operation::SUBTRACTION_TYPE_SERVICES);
            $operations_subtraction_services->where_related('service_usage', 'price >', 0);
            $operations_subtraction_services->group_start(' NOT', 'AND');
            $operations_subtraction_services->where_related('service_usage', 'service_id', NULL);
            $operations_subtraction_services->group_end();
            unset($operations_subtraction_services->db->ar_select[0]);
            $operations_subtraction_services->select_func('SUM', array('@service_usages.quantity', '*', '@service_usages.price'), 'time_sum');
            $operations_subtraction_services->where_related_person('id', '${parent}.id');
           */ 
            $apartment = new Apartment();
            //$apartment->where('admin', 0);
            $apartment->select('*');
            $apartment->select_subquery($operations_addition, 'plus_time');
            $apartment->select_subquery($operations_subtraction_direct, 'minus_time_direct');
           // $apartment->select_subquery($operations_subtraction_products, 'minus_time_products');
            //$apartment->select_subquery($operations_subtraction_services, 'minus_time_services');
            $apartment->get_by_id((int)$operation_data['person_id']);

            if (!$apartment->exists()) {
                $this->db->trans_rollback();
                add_error_flash_message('Izba sa nenašla.');
                redirect(site_url('points'));
            }
            /*
            $admin = new Person();
            $admin->where('admin', 1);
            $admin->get_by_id((int)auth_get_id());
            
            if (!$admin->exists()) {
                $this->db->trans_rollback();
                add_error_flash_message('Administrátor sa nenašiel.');
                redirect(site_url('operations/new_operation'));
            }
            
            $workplace = new Workplace();
            if ((int)$operation_data['workplace_id'] > 0) {
                $workplace->get_by_id((int)$operation_data['workplace_id']);
                
                if (!$workplace->exists()) {
                    $this->db->trans_rollback();
                    add_error_flash_message('Zamestnanie sa nenašlo.');
                    redirect(site_url('operations/new_operation'));
                }
            }
            */
            if ($operation_data['type'] == Operation::TYPE_ADDITION) {
                $operation = new Operation();
                $operation->from_array($operation_data, array('comment', 'time', 'type'));
                $operation->subtraction_type = Operation::SUBTRACTION_TYPE_DIRECT;
                if ($operation->save(array('apartment' => $apartment)) && $this->db->trans_status()) {
                    $this->db->trans_commit();
                    add_success_flash_message('Izba <strong>' . $apartment->title . '</strong> dostala <strong>' . $operation->time . '</strong> ' . get_inflection_by_numbers((int)$operation->time, 'minút', 'minútu', 'minúty', 'minúty', 'minúty', 'minút') . ' úspešne.');
                    redirect(site_url('points'));
                } else {
                    $this->db->trans_rollback();
                    add_error_flash_message('Účastníkovi <strong>' . $apartment->title .  '</strong> sa nepodarilo prideliť <strong>' . $operation->time . '</strong> ' . get_inflection_by_numbers((int)$operation->time, 'minút', 'minútu', 'minúty', 'minúty', 'minúty', 'minút') . ' strojového času.');
                    redirect(site_url('points/new_operation'));
                }
            } else {
                $time_at_disposal = intval($apartment->plus_time) - intval($apartment->minus_time_direct) - intval($apartment->minus_time_products) - intval($apartment->minus_time_services);
                $total_time = 0;
                
                if ($operation_data['subtraction_type'] == Operation::SUBTRACTION_TYPE_DIRECT) {
                    $total_time += (int)$operation_data['time'];
                }
                /*
                $service_data = array();
                if ($operation_data['subtraction_type'] == Operation::SUBTRACTION_TYPE_SERVICES) {
                    $services = new Service();
                    $services->order_by('title', 'asc');
                    $services->get_iterated();

                    foreach ($services as $service) {
                        if (isset($operation_service_data[$service->id])) {
                            if (isset($operation_service_data[$service->id]['quantity']) && (int)$operation_service_data[$service->id]['quantity'] > 0 &&
                                isset($operation_service_data[$service->id]['price']) && (int)$operation_service_data[$service->id]['price'] > 0) {
                                $service_data[$service->id] = $operation_service_data[$service->id];
                                $total_time += (int)$operation_service_data[$service->id]['quantity'] * (int)$operation_service_data[$service->id]['price'];
                            }
                        }
                    }
                }
                */
                $product_data = array();
                if ($operation_data['subtraction_type'] == Operation::SUBTRACTION_TYPE_PRODUCTS) {
                    $quantity_addition = new Product_quantity();
                    $quantity_addition->select_sum('quantity', 'quantity_sum');
                    $quantity_addition->where('type', Product_quantity::TYPE_ADDITION);
                    $quantity_addition->where_related('product', 'id', '${parent}.id');

                    $quantity_subtraction = new Product_quantity();
                    $quantity_subtraction->select_sum('quantity', 'quantity_sum');
                    $quantity_subtraction->where('type', Product_quantity::TYPE_SUBTRACTION);
                    $quantity_subtraction->where_related('product', 'id', '${parent}.id');

                    $products = new Product();
                    $products->order_by('title', 'asc');
                    $products->select('*');
                    $products->select_subquery($quantity_addition, 'plus_quantity');
                    $products->select_subquery($quantity_subtraction, 'minus_quantity');
                    $products->get_iterated();
                    
                    foreach ($products as $product) {
                        if (isset($operation_product_data[$product->id])) {
                            if (isset($operation_product_data[$product->id]['quantity']) && (int)$operation_product_data[$product->id]['quantity'] > 0 &&
                                isset($operation_product_data[$product->id]['price']) && (int)$operation_product_data[$product->id]['price'] > 0) {
                                $product_data[$product->id] = $operation_product_data[$product->id];
                                $total_time += (int)$operation_product_data[$product->id]['quantity'] * (int)$operation_product_data[$product->id]['price'];
                            }
                        }
                    }
                }
                
                if ($total_time > $time_at_disposal) {
                    $this->db->trans_rollback();
                    add_error_flash_message('Účastník <strong>' . $person->name . ' ' . $person->surname . '</strong> nemá dostatok strojového času. Potrebuje <strong>' . $total_time . '</strong> ' . get_inflection_by_numbers((int)$total_time, 'minút', 'minútu', 'minúty', 'minútu', 'minúty', 'minút') . ' ale má iba <strong>' . $time_at_disposal . '</strong> ' . get_inflection_by_numbers((int)$time_at_disposal, 'minút', 'minútu', 'minúty', 'minútu', 'minúty', 'minút') . '.');
                    redirect(site_url('operations/new_operation'));
                }
                /*
                if ($total_time == 0) {
                    $this->db->trans_rollback();
                    add_error_flash_message('Celková suma strojového času na odobratie je nulová, preto nie je možné pokračovať.');
                    redirect(site_url('operations/new_operation'));
                }
                */
                $operation = new Operation();
                $operation->from_array($operation_data, array('comment', 'type', 'subtraction_type'));
                if ($operation_data['subtraction_type'] == Operation::SUBTRACTION_TYPE_DIRECT) {
                    $operation->time = $operation_data['time'];
                } else {
                    $operation->time = 0;
                }
                if ($operation->save(array('apartments' => $apartment)) && $this->db->trans_status()) {
                    /*if (count($service_data) > 0) {
                        foreach ($service_data as $service_id => $service_post) {
                            $service_usage = new Service_usage();
                            $service_usage->from_array($service_post, array('quantity', 'price'));
                            $service_usage->service_id = (int)$service_id;
                            if (!$service_usage->save(array('operation' => $operation))) {
                                $service = new Service();
                                $service->get_by_id((int)$service_id);
                                $this->db->trans_rollback();
                                add_error_flash_message('Nepodarilo sa uložiť záznam o odobratí strojového času za službu <strong>' . $service->title . '</strong>.');
                                redirect(site_url('operations/new_operation'));
                                die();
                            }
                        }
                    }
                    if (count($product_data) > 0) {
                        foreach ($product_data as $product_id => $product_post) {
                            $product_quantity = new Product_quantity();
                            $product_quantity->type = Product_quantity::TYPE_SUBTRACTION;
                            $product_quantity->from_array($product_post, array('quantity', 'price'));
                            $product_quantity->product_id = (int)$product_id;
                            if (!$product_quantity->save(array('operation' => $operation))) {
                                $product = new Product();
                                $product->get_by_id((int)$product_id);
                                $this->db->trans_rollback();
                                add_error_flash_message('Nepodarilo sa uložiť záznam o odobratí strojového času za produkt <strong>' . $product->title . '</strong>.');
                                redirect(site_url('operations/new_operation'));
                                die();
                            }
                        }
                    }*/
                    $this->db->trans_commit();
                    add_success_flash_message('Účastníkovi <strong>' . $apartment->title . '</strong> sa úspešne podarilo odobrať <strong>' . $total_time . '</strong> ' . get_inflection_by_numbers((int)$total_time, 'minút', 'minútu', 'minúty', 'minúty', 'minúty', 'minút') . ' strojového času.');
                    redirect(site_url('points'));
                } else {
                    $this->db->trans_rollback();
                    add_error_flash_message('Účastníkovi <strong>' . $apartment->title . '</strong> sa nepodarilo odobrať <strong>' . $total_time . '</strong> ' . get_inflection_by_numbers((int)$total_time, 'minút', 'minútu', 'minúty', 'minúty', 'minúty', 'minút') . ' strojového času.');
                    redirect(site_url('points/new_operation'));
                }
            }
        } else {
            $this->db->trans_rollback();
            $this->new_operation();
        }
    }
    
    public function transactions($person_id = NULL, $page_size = 20, $page = 1) {
        if (is_null($person_id)) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('operations'));
        }
        
        $person = new Person();
        $person->where('admin', 0);
        $person->get_by_id((int)$person_id);
        
        if (!$person->exists()) {
            add_error_flash_message('Osoba sa nenašla.');
            redirect(site_url('operations'));
        }
        
        $operations = new Operation();
        $operations->where_related_person($person);
        $operations->include_related('admin', array('name', 'surname'));
        $operations->include_related('workplace', 'title');
        $operations->order_by('created', 'desc');
        $operations->get_paged_iterated($page, $page_size);
        
        $this->parser->parse('web/controllers/operations/transactions.tpl', array(
            'person' => $person,
            'operations' => $operations,
            'title' => 'Administrácia / Strojový čas / Prehľad transakcií / ' . $person->name . ' ' . $person->surname,
            'back_url' => site_url('operations'),
            'form' => $this->get_transaction_pagination_form($operations->paged),
        ));
    }
    
    public function set_transactions_pagination($person_id = NULL) {
        if (is_null($person_id)) {
            redirect(site_url('operations/transactions'));
        }
        
        $pagination_data = $this->input->post('pagination');
        
        if (array_key_exists('page', $pagination_data) && array_key_exists('page_size', $pagination_data) && (int)$pagination_data['page'] > 0 && (int)$pagination_data['page_size'] > 0) {
            redirect(site_url('operations/transactions/' . $person_id . '/' . (int)$pagination_data['page_size'] . '/' . (int)$pagination_data['page']));
        }
        redirect(site_url('operations/transactions/' . $person_id));
    }
    
    public function batch_point_addition() {
        $this->load->helper('filter');
        $this->parser->parse('web/controllers/points/batch_point_addition.tpl', array(
            'title' => 'Administrácia / Izby / Hromadné pridanie bodov',
            'form' => $this->get_batch_point_addition_form(),
            'back_url' => site_url('points'),
        ));
    }
    
    public function do_batch_point_addition() {
        $this->db->trans_begin();
        build_validator_from_form($this->get_batch_point_addition_form());
        if ($this->form_validation->run()) {
            $batch_time_data = $this->input->post('batch_time');
            $person_time_data = $this->input->post('person_time');
            
            
            $apartments = new Apartment();
            $apartments->get_iterated();
            
            $successful_count = 0;
            $error_count = 0;
            $successful_messages = array();
            $error_messages = array();
            
            foreach ($apartments as $apartment) {
                if (array_key_exists($apartment->id, $person_time_data) && (int)$person_time_data[$apartment->id] > 0) {
                    $operation = new Operation();
                    //$operation->admin_id = auth_get_id();
                    $operation->time = (int)$person_time_data[$apartment->id];
                    $operation->type = Operation::TYPE_ADDITION;
                    $operation->subtraction_type = Operation::SUBTRACTION_TYPE_DIRECT;
                    $operation->comment = @$batch_time_data['comment'];
                    if ($operation->save(array('apartment' => $apartment))) {
                        $successful_messages[] = 'Účastník <strong>' . $apartment->title .  '</strong> dostal <strong>' . (int)$operation->time . '</strong> ' . get_inflection_by_numbers((int)$operation->time, 'minút', 'minútu', 'minúty', 'minúty', 'minúty', 'minút') . ' strojového času.';
                        $successful_count++;
                    } else {
                        $error_count++;
                        $error_messages[] = 'Účastníkovi <strong>' . $apartment->title . '</strong> sa nepodarilo prideliť strojový čas.';
                    }
                }
            }
            
            if ($successful_count == 0 && $error_count == 0) {
                $this->db->trans_rollback();
                add_error_flash_message('Nikomu nebol pridelený strojový čas, nakoľko bol odoslaný prázdny formulár.');
                redirect(site_url('operations'));
            } elseif ($successful_count == 0 && $error_count > 0) {
                $this->db->trans_rollback();
                add_error_flash_message('Nepodarilo sa nikomu pridať strojový čas:<br /><br />' . implode('<br />', $error_messages));
            } else {
                $this->db->trans_commit();
                if ($successful_count > 0) {
                    add_success_flash_message('Strojový čas bol pridelený <strong>' . $successful_count . '</strong> ' . get_inflection_by_numbers($successful_count, 'účastníkom', 'účastníkovi', 'účastníkom', 'účastníkom', 'účastníkom', 'účastníkom') . ':<br /><br />' . implode('<br />', $successful_messages));
                }
                if ($error_count > 0) {
                    add_error_flash_message('Strojový čas sa nepodarilo udeliť <strong>' . $error_count . '</strong> ' . get_inflection_by_numbers($error_count, 'účastníkom', 'účastníkovi', 'účastníkom', 'účastníkom', 'účastníkom', 'účastníkom') . ':<br /><br />' . implode('<br />', $error_messages));
                }
                redirect(site_url('points'));
            }
        } else {
            $this->db->trans_rollback();
            $this->batch_point_addition();
        }        
    }
    
    public function get_batch_point_addition_form() {
        
        $apartments = new Apartment();
        //$persons->include_related('group', 'title');
        //$persons->where('admin', '0');
        //$persons->order_by_related('group', 'title', 'asc')->order_by('surname', 'asc')->order_by('name', 'asc');
        $apartments->get_iterated();
        
        if ($apartments->exists()) {
            $form['fields']['persons_divider'] = array(
                'type' => 'divider',
                'data' => array(
                    'stay-visible' => 'true',
                ),
            );
            $form['arangement'][] = 'persons_divider';
        }
        
        $current_group = NULL;
        
        foreach ($apartments as $apartment) {
            if ($apartment->group_id !== $current_group) {
                $form['fields']['divider_group_' . $apartment->group_id] = array(
                    'type' => 'divider',
                    'data' => array(
                        'stay-visible' => 'true',
                    ),
                );
                if (trim($apartment->group_title) !== '') {
                    $form['fields']['divider_group_' . $apartment->group_id]['text'] = 'Skupina: "' . $apartment->group_title . '"';
                }
                $form['arangement'][] = 'divider_group_' . $apartment->group_id;
                $current_group = $apartment->group_id;
                $form['fields']['group_' . $current_group . '_slider'] = array(
                    'name' => 'person_time[' . $apartment->id . ']',
                    'id' => 'person_time-' . $apartment->id,
                    'class' => 'group_common_slider',
                    'data' => array('group_id' => $current_group),
                    'label' => 'Spoločné nastavenie času',
                    'min' => 0,
                    'max' => 240,
                    'default' => 0,
                    'type' => 'slider',
                );
                $form['arangement'][] = 'group_' . $current_group . '_slider';
            }
            $form['fields']['apartment_' . $apartment->id] = array(
                'name' => 'person_time[' . $apartment->id . ']',
                'id' => 'person_time-' . $apartment->id,
                ///'class' => 'group_' . $current_group,
                'label' => '<span class="person_name_label"><img src="' . get_person_image_min($apartment->id) . '" alt="" /><span class="person_name">' . $apartment->title .'</span></span>',
                'type' => 'slider',
                'min' => 0,
                'max' => 240,
                'data' => array(
                    'title' => $apartment->title,
                    //'person-login' => $person->login,
                ),
                'default' => 0,
                'validation' => array(
                    array(
                        'if-field-not-equals' => array('field' => 'person_time[' . $apartment->id . ']', 'value' => 0),
                        'rules' => 'required|integer|greater_than[0]',
                    ),
                ),
            );
            $form['arangement'][] = 'apartment_' . $apartment->id;
        }
        
        return $form;
    }

    public function get_form($type = '', $subtraction_type = '') {
        $operations_addition = new Operation();
        $operations_addition->where('type', Operation::TYPE_ADDITION);
        $operations_addition->select_sum('time', 'time_sum');
        $operations_addition->where_related_person('id', '${parent}.id');
        
        $operations_subtraction_direct = new Operation();
        $operations_subtraction_direct->where('type', Operation::TYPE_SUBTRACTION);
        $operations_subtraction_direct->where('subtraction_type', Operation::SUBTRACTION_TYPE_DIRECT);
        $operations_subtraction_direct->select_sum('time', 'time_sum');
        $operations_subtraction_direct->where_related_person('id', '${parent}.id');
        
        $operations_subtraction_products = new Operation();
        $operations_subtraction_products->where('type', Operation::TYPE_SUBTRACTION);
        $operations_subtraction_products->where('subtraction_type', Operation::SUBTRACTION_TYPE_PRODUCTS);
        $operations_subtraction_products->where_related('product_quantity', 'price >', 0);
        $operations_subtraction_products->group_start(' NOT', 'AND');
        $operations_subtraction_products->where_related('product_quantity', 'product_id', NULL);
        $operations_subtraction_products->group_end();
        unset($operations_subtraction_products->db->ar_select[0]);
        $operations_subtraction_products->select_func('SUM', array('@product_quantities.quantity', '*', '@product_quantities.price'), 'time_sum');
        $operations_subtraction_products->where_related_person('id', '${parent}.id');
        
        $operations_subtraction_services = new Operation();
        $operations_subtraction_services->where('type', Operation::TYPE_SUBTRACTION);
        $operations_subtraction_services->where('subtraction_type', Operation::SUBTRACTION_TYPE_SERVICES);
        $operations_subtraction_services->where_related('service_usage', 'price >', 0);
        $operations_subtraction_services->group_start(' NOT', 'AND');
        $operations_subtraction_services->where_related('service_usage', 'service_id', NULL);
        $operations_subtraction_services->group_end();
        unset($operations_subtraction_services->db->ar_select[0]);
        $operations_subtraction_services->select_func('SUM', array('@service_usages.quantity', '*', '@service_usages.price'), 'time_sum');
        $operations_subtraction_services->where_related_person('id', '${parent}.id');
        
        $apartments = new Apartment();
        //$persons->order_by('surname', 'asc')->order_by('name', 'asc');
        //$persons->where('admin', 0);
        $apartments->select('*');
        $apartments->select_subquery($operations_addition, 'plus_time');
        $apartments->select_subquery($operations_subtraction_direct, 'minus_time_direct');
        $apartments->select_subquery($operations_subtraction_products, 'minus_time_products');
        $apartments->select_subquery($operations_subtraction_services, 'minus_time_services');
        //$apartments->include_related('group', 'title');
        $apartments->get_iterated();
        
        $persons_select = array('' => '');
        
        foreach ($apartments as $apartment) {
            $time = (intval($apartment->plus_time) - intval($apartment->minus_time_direct) - intval($apartment->minus_time_products) - intval($apartment->minus_time_services));
            $persons_select[$apartment->id] = $apartment->title . ' (' .$apartment->title. ' | Čas: ' . $time . ' ' . get_inflection_by_numbers($time, 'minút', 'minúta', 'minúty', 'minúty', 'minúty', 'minút') . ')';
        }
        
        
        $form = array(
            'fields' => array(
                'type' => array(
                    'name' => 'operation[type]',
                    'type' => 'select',
                    'id' => 'operation-type',
                    'label' => 'Typ operácie',
                    'data' => array(
                        'stay-visible' => 'true',
                    ),
                    'values' => array(
                        '' => '',
                        Operation::TYPE_ADDITION => 'Pridanie strojového času',
                        Operation::TYPE_SUBTRACTION => 'Odobratie strojového času',
                    ),
                    'validation' => 'required',
                ),
                'subtraction_type' => array(
                    'name' => 'operation[subtraction_type]',
                    'type' => 'select',
                    'id' => 'operation-subtraction_type',
                    'label' => 'Spôsob odobratia času',
                    'data' => array(
                        'stay-visible' => 'true',
                    ),
                    'values' => array(
                        '' => '',
                        Operation::SUBTRACTION_TYPE_DIRECT => 'Priame odobratie času',
                        Operation::SUBTRACTION_TYPE_PRODUCTS => 'Nákup v bufete',
                        Operation::SUBTRACTION_TYPE_SERVICES => 'Využitie služieb',
                    ),
                    'validation' => 'required',
                ),
                'apartment' => array(
                    'title' => 'operation[person_id]',
                    'type' => 'select',
                    'id' => 'operation-person_id',
                    'label' => 'Izba',
                    'data' => array(
                        'stay-visible' => 'true',
                    ),
                    'values' => $persons_select,
                    'validation' => 'required',
                ),
                'comment' => array(
                    'name' => 'operation[comment]',
                    'type' => 'text_input',
                    'id' => 'comment-id',
                    'label' => 'Komentár',
                    'data' => array(
                        'stay-visible' => 'true',
                    ),
                    'validation' => 'max_length[255]',
                ),
                'time' => array(
                    'name' => 'operation[time]',
                    'type' => 'slider',
                    'id' => 'comment-time',
                    'label' => 'Body',
                    'data' => array(
                        'stay-visible' => 'true',
                    ),
                    'min' => 0,
                    'max' => 240,
                    'default' => 0,
                    'validation' => array(
                        array(
                            'if-field-not-equals' => array('field' => 'operation[time]', 'value' => 0),
                            'rules' => 'required|integer|greater_than[0]',
                        ),
                    ),
                ),
            ),
            'arangement' => array(
                'type', 'apartment', 'comment'
            ),
        );
       
        if ($type == Operation::TYPE_SUBTRACTION) {
            if ($subtraction_type == Operation::SUBTRACTION_TYPE_DIRECT) {
                $form['arangement'] = array('type', 'subtraction_type', 'apartment', 'workplace', 'comment', 'time');
            } elseif ($subtraction_type == Operation::SUBTRACTION_TYPE_SERVICES) {
                $form['arangement'] = array('type', 'subtraction_type', 'apartment', 'comment');
                $services = new Service();
                $services->order_by('title', 'asc');
                $services->get_iterated();

                foreach ($services as $service) {
                    $form['fields']['service_' . $service->id . '_quantity'] = array(
                        'name' => 'operation_service[' . $service->id . '][quantity]',
                        'class' => 'controlls-services',
                        'id' => 'operation_service-' . $service->id . '-quantity',
                        'type' => 'slider',
                        'min' => 0,
                        'max' => 240,
                        'label' => $service->title . ' (čas)',
                        'data' => array(
                            'service-title' => $service->title,
                        ),
                        'default' => 0,
                        'validation' => array(
                            array(
                                'if-field-not-equals' => array('field' => 'operation_service[' . $service->id . '][quantity]', 'value' => 0),
                                'rules' => 'required|integer|greater_than[0]',
                            ),
                        ),
                    );
                    $form['fields']['service_' . $service->id . '_price'] = array(
                        'name' => 'operation_service[' . $service->id . '][price]',
                        'class' => 'controlls-services',
                        'id' => 'operation_service-' . $service->id . '-price',
                        'type' => 'text_input',
                        'label' => $service->title . ' (cena za minútu)',
                        'data' => array(
                            'service-title' => $service->title,
                        ),
                        'default' => $service->price,
                        'validation' => array(
                            array(
                                'if-field-not-equals' => array('field' => 'operation_service[' . $service->id . '][quantity]', 'value' => 0),
                                'rules' => 'required|integer|greater_than[0]',
                            ),
                        ),
                    );

                    $form['arangement'][] = 'service_' . $service->id . '_quantity';
                    $form['arangement'][] = 'service_' . $service->id . '_price';
                }
            } elseif ($subtraction_type == Operation::SUBTRACTION_TYPE_PRODUCTS) {
                $form['arangement'] = array('type', 'subtraction_type', 'person', 'comment');
                
                $quantity_addition = new Product_quantity();
                $quantity_addition->select_sum('quantity', 'quantity_sum');
                $quantity_addition->where('type', Product_quantity::TYPE_ADDITION);
                $quantity_addition->where_related('product', 'id', '${parent}.id');

                $quantity_subtraction = new Product_quantity();
                $quantity_subtraction->select_sum('quantity', 'quantity_sum');
                $quantity_subtraction->where('type', Product_quantity::TYPE_SUBTRACTION);
                $quantity_subtraction->where_related('product', 'id', '${parent}.id');

                $products = new Product();
                $products->order_by('title', 'asc');
                $products->select('*');
                $products->select_subquery($quantity_addition, 'plus_quantity');
                $products->select_subquery($quantity_subtraction, 'minus_quantity');
                $products->get_iterated();

                $p = 1;
                foreach ($products as $product) {
                    $form['fields']['product_' . $product->id . '_quantity'] = array(
                        'name' => 'operation_product[' . $product->id . '][quantity]',
                        'class' => 'controlls-products',
                        'id' => 'operation_product-' . $product->id . '-quantity',
                        'type' => 'slider',
                        'min' => 0,
                        'max' => intval($product->plus_quantity) - intval($product->minus_quantity),
                        'label' => '<span class="product_title_label"><img src="' . get_product_image_min($product->id) . '" alt="" /><span class="product_title">' . $product->title . ' (počet kusov)</span></span>',
                        'default' => 0,
                        'data' => array(
                            'product-title' => $product->title,
                        ),
                        'validation' => array(
                            array(
                                'if-field-not-equals' => array('field' => 'operation_product[' . $product->id . '][quantity]', 'value' => 0),
                                'rules' => 'required|integer|greater_than[0]|less_than_equals[' . (intval($product->plus_quantity) - intval($product->minus_quantity)) . ']',
                            ),
                        ),
                    );
                    $form['fields']['product_' . $product->id . '_price'] = array(
                        'name' => 'operation_product[' . $product->id . '][price]',
                        'class' => 'controlls-products',
                        'id' => 'operation_product-' . $product->id . '-price',
                        'type' => 'text_input',
                        'label' => $product->title . ' (cena za kus)',
                        'default' => $product->price,
                        'data' => array(
                            'product-title' => $product->title,
                        ),
                        'validation' => array(
                            array(
                                'if-field-not-equals' => array('field' => 'operation_product[' . $product->id . '][quantity]', 'value' => 0),
                                'rules' => 'required|integer|greater_than[0]',
                            ),
                        ),
                    );

                    $form['arangement'][] = 'product_' . $product->id . '_quantity';
                    $form['arangement'][] = 'product_' . $product->id . '_price';
                    if ($p < $products->result_count()) {
                        $form['fields']['product_' . $product->id . '_divider'] = array(
                            'type' => 'divider',
                            'data' => array(
                                'product-title' => $product->title,
                            ),
                        );
                        $form['arangement'][] = 'product_' . $product->id . '_divider';
                    }
                    $p++;
                }
            } else {
                $form['arangement'] = array('type', 'subtraction_type', 'person');
            }
        } else {
            $form['arangement'][] = 'time';
        }
        
        if ($type == Operation::TYPE_ADDITION) {
            $form['fields']['time']['validation'] = 'required|integer|greater_than[0]';
        } elseif ($type == Operation::TYPE_SUBTRACTION) {
            
        } else {
            $form['arangement'] = array('type');
        }
        
        return $form;
    }
    
    protected function get_transaction_pagination_form($pagination) {
        $pages = array();
        for ($i = 1; $i <= $pagination->total_pages; $i++) {
            $pages[$i] = $i . '. stránka';
        }
        $form = array(
            'fields' => array(
                'page' => array(
                    'name' => 'pagination[page]',
                    'type' => 'select',
                    'id' => 'pagination-page',
                    'label' => 'Stránka',
                    'values' => $pages,
                    'default' => $pagination->current_page,
                    'object_property' => 'current_page',
                ),
                'page_size' => array(
                    'name' => 'pagination[page_size]',
                    'type' => 'select',
                    'id' => 'pagination-page_size',
                    'label' => 'Veľkosť stránky',
                    'values' => array(
                        10 => '10 záznamov',
                        20 => '20 záznamov',
                        30 => '30 záznamov',
                        40 => '40 záznamov',
                        50 => '50 záznamov',
                    ),
                    'default' => $pagination->page_size,
                    'object_property' => 'page_size',
                ),
            ),
            'arangement' => array(
                'page', 'page_size',
            ),
        );
        return $form;
    }
}
?>
