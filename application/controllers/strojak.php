<?php

class Strojak extends CI_Controller {
    
    const FILTER_PERSONS_TABLE = 'strojak_persons_table_filter';
    
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
        
        $filter = filter_get_filter(self::FILTER_PERSONS_TABLE, array('orderby' => 'time_left', 'renderas' => 'table'));
        
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
        
        $this->parser->parse('web/controllers/strojak/my_time.tpl');
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
            ),
            'arangement' => array( 'orderby', 'renderas' ),
        );
        return $form;
    }
    
}