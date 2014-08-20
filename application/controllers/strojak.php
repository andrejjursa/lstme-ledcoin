<?php

class Strojak extends CI_Controller {
    
    const FILTER_PERSONS_TABLE = 'strojak_persons_table_filter';
    const FILTER_MY_TIME_TABLE = 'strojak_my_time_table_filter';
    
    const MY_TIME_TABLE_ROWS_PER_PAGE = 30;
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index() {
        $this->load->helper('filter');
        
        $post = $this->input->post();
        
        if ($post !== FALSE) {
            $post_filter = $this->input->post('filter');
            if ($post_filter !== FALSE) {
                if (@$post_filter['renderas'] == 'graph' && (@$post_filter['orderby'] == 'fullname' || @$post_filter['orderby'] == 'group' || @$post_filter['orderby'] == 'school')) {
                    $post_filter['orderby'] = 'time_left';
                }
                filter_store_filter(self::FILTER_PERSONS_TABLE, $post_filter);
            }
            redirect('strojak');
        }
        
        $filter = filter_get_filter(self::FILTER_PERSONS_TABLE, array('orderby' => 'time_left', 'renderas' => 'table', 'graph_type' => 'column'));
        
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
        
        $persons_non_admins = new Person();
        $persons_non_admins->where('admin', 0);
        $persons_non_admins->select('*');
        $persons_non_admins->select_subquery($operations_addition, 'plus_time');
        $persons_non_admins->select_subquery($operations_subtraction_direct, 'minus_time_direct');
        $persons_non_admins->select_subquery($operations_subtraction_products, 'minus_time_products');
        $persons_non_admins->select_subquery($operations_subtraction_services, 'minus_time_services');
        $persons_non_admins->include_related('group', 'title');
        if ($filter['orderby'] == 'time_left') {
            $persons_non_admins->db->ar_orderby[] = '(IFNULL(`plus_time`, 0) - IFNULL(`minus_time_direct`, 0) - IFNULL(`minus_time_products`, 0) - IFNULL(`minus_time_services`, 0)) DESC';
        } elseif ($filter['orderby'] == 'time_acquired') {
            $persons_non_admins->db->ar_orderby[] = 'IFNULL(`plus_time`, 0) DESC';
        } elseif ($filter['orderby'] == 'time_used') {
            $persons_non_admins->db->ar_orderby[] = '(IFNULL(`minus_time_direct`, 0) + IFNULL(`minus_time_products`, 0) + IFNULL(`minus_time_services`, 0)) DESC';
        } elseif ($filter['orderby'] == 'fullname') {
            $persons_non_admins->order_by('surname', 'asc')->order_by('name', 'asc');
        } elseif ($filter['orderby'] == 'group') {
            $persons_non_admins->order_by_related('group', 'title', 'asc');
        } elseif ($filter['orderby'] == 'school') {
            $persons_non_admins->order_by('organisation', 'asc');
        }
        $persons_non_admins->get_iterated();
        $this->parser->parse('web/controllers/strojak/index.tpl', array(
            'persons' => $persons_non_admins,
            'title' => 'Účastníci',
            'form' => $this->get_persons_filter_form($filter),
            'filter' => $filter,
        ));
    }
    
    public function bufet() {
        $quantity_addition = new Product_quantity();
        $quantity_addition->select_sum('quantity', 'quantity_sum');
        $quantity_addition->where('type', Product_quantity::TYPE_ADDITION);
        $quantity_addition->where_related('product', 'id', '${parent}.id');
        
        $quantity_subtraction = new Product_quantity();
        $quantity_subtraction->select_sum('quantity', 'quantity_sum');
        $quantity_subtraction->where('type', Product_quantity::TYPE_SUBTRACTION);
        $quantity_subtraction->where_related('product', 'id', '${parent}.id');
        
        $products = new Product();
        $products->order_by('price', 'asc');
        $products->select('*');
        $products->select_subquery($quantity_addition, 'plus_quantity');
        $products->select_subquery($quantity_subtraction, 'minus_quantity');
        $products->get_iterated();
        $this->parser->parse('web/controllers/strojak/bufet.tpl', array('products' => $products, 'title' => 'Bufet'));
    }
    
    public function my_time() {
        auth_redirect_if_not_authentificated('error/no_auth');
        
        $this->load->helper('filter');
        
        $post = $this->input->post();
        if ($post !== FALSE) {
            $post_filter = $this->input->post('filter');
            if ($post_filter !== FALSE) {
                filter_store_filter(self::FILTER_MY_TIME_TABLE, $post_filter);
            }
            redirect('strojak/my_time');
        }
        
        $filter = filter_get_filter(self::FILTER_MY_TIME_TABLE, array('page' => 1));
        
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
        
        $person = new Person();
        $person->where('admin', 0);
        $person->select('*');
        $person->select_subquery($operations_addition, 'plus_time');
        $person->select_subquery($operations_subtraction_direct, 'minus_time_direct');
        $person->select_subquery($operations_subtraction_products, 'minus_time_products');
        $person->select_subquery($operations_subtraction_services, 'minus_time_services');
        $person->include_related('group', 'title');
        $person->get_by_id(auth_get_id());
        
        if (!$person->exists()) {
            add_error_flash_message('Nenašla sa informácia o prihlásenom používateľovi. Nemôžete si pozrieť svoj strojový čas.');
            redirect(site_url('strojak'));
        }
        
        $operations = new Operation();
        $operations->select('id, created, time, type, subtraction_type, comment');
        $operations->include_related('admin', array('name', 'surname'));
        $operations->include_related('workplace', 'title');
        $operations->where_related_person($person);
        $operations->order_by('created', 'asc');
        $operations->get_paged_iterated($filter['page'], self::MY_TIME_TABLE_ROWS_PER_PAGE);
        
        $this->parser->parse('web/controllers/strojak/my_time.tpl', array(
            'title' => 'Môj strojový čas',
            'operations' => $operations,
            'person' => $person,
            'form' => $this->get_my_time_filter_form($filter, $operations->paged),
        ));
    }
    
    protected function get_my_time_filter_form($filter, $paged) {
        $pages = array();
        for ($i = 1; $i <= $paged->total_pages; $i++) {
            $pages[$i] = $i . '. strana';
        }
        
        $form = array(
            'fields' => array(
                'page' => array(
                    'name' => 'filter[page]',
                    'id' => 'filter-page',
                    'label' => 'Strana',
                    'type' => 'select',
                    'values' => $pages,
                    'default' => isset($filter['page']) ? $filter['page'] : 1,
                ),
            ),
            'arangement' => array(
                'page'
            ),
        );
        
        return $form;
    }
    
    protected function get_persons_filter_form($filter) {
        $orderby = array(
            'fullname' => 'mena účastníka',
            'group' => 'skupiny',
            'school' => 'školy',
            'time_left' => 'zostávajúceho času',
            'time_acquired' => 'získaného času',
            'time_used' => 'použitého času',
        );
        if (isset($filter['renderas']) && $filter['renderas'] == 'graph') {
            unset($orderby['fullname']);
            unset($orderby['group']);
            unset($orderby['school']);
        }
        $form = array(
            'fields' => array(
                'orderby' => array(
                    'name' => 'filter[orderby]',
                    'id' => 'filter-orderby',
                    'type' => 'select',
                    'label' => 'Zoradiť podľa',
                    'values' => $orderby,
                    'default' => isset($filter['orderby']) ? $filter['orderby'] : 'time_left',
                ),
                'renderas' => array(
                    'name' => 'filter[renderas]',
                    'id' => 'filter-renderas',
                    'type' => 'select',
                    'label' => 'Zobraziť ako',
                    'values' => array(
                        'table' => 'tabuľku',
                        'graph' => 'graf',
                    ),
                    'default' => isset($filter['renderas']) ? $filter['renderas'] : 'table',
                ),
                'graph_type' => array(
                    'name' => 'filter[graph_type]',
                    'id' => 'filter-graph_type',
                    'type' => 'select',
                    'label' => 'Typ grafu',
                    'values' => array(
                        'column' => 'stĺpcový',
                        'pie' => 'koláčový',
                    ),
                    'default' => isset($filter['graph_type']) ? $filter['graph_type'] : 'column',
                ),
            ),
            'arangement' => array(  'renderas', 'orderby' ),
        );
        if ($filter['renderas'] == 'graph') {
            $form['fields']['orderby']['label'] = 'Zobraziť graf podľa';
            $form['arangement'] = array( 'renderas', 'graph_type', 'orderby' );
        }
        return $form;
    }
    
    public function get_persons_graph_json(DataMapper $persons, $filter_orderby, $format_graph_type = 'column') {
        $series = array();
        $drilldown = array();
        
        $dataLabels = new stdClass();
        $dataLabels->enabled = TRUE;
        $dataLabels->format = '{point.name} ({y} min.)';
        if ($format_graph_type == 'column') {
            $dataLabels->format = '{y} min.';
        }
        $dataLabels->align = 'center';
        $dataLabels->style = new stdClass();
        $dataLabels->style->fontSize = '11px';
        $dataLabels->style->fontFamily = 'Verdana, sans-serif';
        $dataLabels->style->fontWeight = 'bold';
        
        foreach ($persons as $person) {
            $series_item = new stdClass();
            $series_item->name = $person->name . ' ' . $person->surname;
            $time_plus = (int)$person->plus_time;
            $time_minus = (int)$person->minus_time_direct + (int)$person->minus_time_products + (int)$person->minus_time_services;
            if ($filter_orderby == 'time_left') {
                $series_item->y = $time_plus - $time_minus;
            } elseif ($filter_orderby == 'time_acquired') {
                $series_item->y = $time_plus;
            } else {
                $series_item->y = $time_minus;
            }
            $drilldown_data = $this->get_persons_graph_drilldown_json($person->id, $filter_orderby);
            if (count($drilldown_data) > 2) {
                $series_item->drilldown = 'person_' . $person->id;
                $drilldown_item = new stdClass();
                $drilldown_item->id = 'person_' . $person->id;
                $drilldown_item->name = $person->name . ' ' . $person->surname;
                $drilldown_item->data = $drilldown_data;
                $drilldown_item->type = 'area';
                $drilldown_item->dataLabels = $dataLabels;
                $drilldown[] = $drilldown_item;
            }
            $series[] = $series_item;
        }
        
        $output = new stdClass();
        $output->series = $series;
        $output->drilldown = $drilldown;
        $output->series_dataLabels = $dataLabels;
        if ($filter_orderby == 'time_left') {
            $output->series_name = 'Zostávajúci čas';
            $output->yAxis = 'Zostávajúci čas';
        } elseif ($filter_orderby == 'time_acquired') {
            $output->series_name = 'Získaný čas';
            $output->yAxis = 'Získaný čas';
        } else {
            $output->series_name = 'Použitý čas';
            $output->yAxis = 'Použitý čas';
        }
        
        return json_encode($output);
    }
    
    protected function get_persons_graph_drilldown_json($person_id, $filter_orderby) {
        $operations = new Operation();
        $operations->select('*');
        $operations->where_related_person('id', (int)$person_id);
        $operations->order_by('created', 'asc');
        $operations->include_related('product_quantity');
        $operations->include_related('product_quantity/product');
        $operations->include_related('service_usage');
        $operations->include_related('service_usage/service');
        $operations->get_iterated();
        
        $series = array();
        
        $days = array();
        $days_plus_time = array();
        $days_minus_time = array();
        
        $current_day_index = '';
        
        foreach ($operations as $operation) {
            $day_index = date('d.m.Y', strtotime($operation->created));
            if ($day_index != $current_day_index) { 
                $days_plus_time[$day_index] = 0;
                $days_minus_time[$day_index] = 0;
                $days[] = $day_index;
                $current_day_index = $day_index;
            }
            if ($operation->type == Operation::TYPE_ADDITION && (int)$operation->time > 0) {
                $days_plus_time[$day_index] += (int)$operation->time;
            } elseif ($operation->type == Operation::TYPE_SUBTRACTION) {
                if ($operation->subtraction_type == Operation::SUBTRACTION_TYPE_DIRECT && (int)$operation->time > 0) {
                    $days_minus_time[$day_index] += (int)$operation->time;
                } elseif ($operation->subtraction_type == Operation::SUBTRACTION_TYPE_PRODUCTS && !is_null($operation->product_quantity_id) && !is_null($operation->product_quantity_product_id)
                          && (int)$operation->product_quantity_quantity * (int)$operation->product_quantity_price > 0) {
                    $days_minus_time[$day_index] += (int)$operation->product_quantity_quantity * (int)$operation->product_quantity_price;
                } elseif ($operation->subtraction_type == Operation::SUBTRACTION_TYPE_SERVICES && !is_null($operation->service_usage_id) && !is_null($operation->service_usage_service_id)
                          && (int)$operation->service_usage_quantity * (int)$operation->service_usage_price > 0) {
                    $days_minus_time[$day_index] += (int)$operation->service_usage_quantity * (int)$operation->service_usage_price;
                }
            }
        }
        
        $total_plus = 0;
        $total_minus = 0;
        
        $series_item_start = new stdClass();
        $series_item_start->name = 'Začiatok sústredenia';
        $series_item_start->y = 0;
        
        $series[] = $series_item_start;
        
        if (count($days) > 0) { foreach ($days as $day) {
            $series_item = new stdClass();
            $series_item->name = $day;
            if ($filter_orderby == 'time_left') {
                $total_plus += $days_plus_time[$day];
                $total_minus += $days_minus_time[$day];
                $series_item->y = $total_plus - $total_minus;
            } elseif ($filter_orderby == 'time_acquired') {
                $series_item->y = $days_plus_time[$day];
            } else {
                $series_item->y = $days_minus_time[$day];
            }
            if ($series_item->y > 0 || $filter_orderby == 'time_left') {
                $series[] = $series_item;
            }
        }}
        
        $series_item_end = new stdClass();
        $series_item_end->name = 'Koniec sústredenia';
        $series_item_end->y = 0;
        
        $series[] = $series_item_end;
        
        return $series;
    }
    
}