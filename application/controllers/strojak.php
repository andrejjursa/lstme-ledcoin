<?php

class Strojak extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index() {
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
        $persons_non_admins->db->ar_orderby[] = '(IFNULL(`plus_time`, 0) - IFNULL(`minus_time_direct`, 0) - IFNULL(`minus_time_products`, 0) - IFNULL(`minus_time_services`, 0)) DESC';
        $persons_non_admins->get_iterated();
        $this->parser->parse('web/controllers/strojak/index.tpl', array('persons' => $persons_non_admins, 'title' => 'Účastníci'));
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
    
}