<?php

class Strojak extends CI_Controller {
    
    public function index() {
        $operations_addition = new Operation();
        $operations_addition->where('type', 'addition');
        $operations_addition->select_sum('time', 'time_sum');
        $operations_addition->where_related_person('id', '${parent}.id');
        
        $operations_subtraction_simple = new Operation();
        $operations_subtraction_simple->where('type', 'subtraction');
        $operations_subtraction_simple->select_sum('time', 'time_sum');
        $operations_subtraction_simple->where_related_person('id', '${parent}.id');
        
        $operations_subtraction_advanced = new Operation();
        $operations_subtraction_advanced->where('type', 'subtraction');
        $operations_subtraction_advanced->where_related('quantity/product', 'price >', 0);
        unset($operations_subtraction_advanced->db->ar_select[0]);
        $operations_subtraction_advanced->select_func('SUM', array('@quantities.quantity', '*', '@quantity_products.price'), 'time_sum');
        $operations_subtraction_advanced->where_related_person('id', '${parent}.id');
        
        $persons_non_admins = new Person();
        $persons_non_admins->where('admin', 0);
        $persons_non_admins->select('*');
        $persons_non_admins->select_subquery($operations_addition, 'plus_time');
        $persons_non_admins->select_subquery($operations_subtraction_simple, 'minus_time_1');
        $persons_non_admins->select_subquery($operations_subtraction_advanced, 'minus_time_2');
        $persons_non_admins->include_related('group', 'title');
        $persons_non_admins->order_by_func('', array('@plus_time', '-', '@minus_time_1', '-', '@minus_time_2'), 'asc');
        $persons_non_admins->get_iterated();
        $this->parser->parse('web/controllers/strojak/index.tpl', array('persons' => $persons_non_admins, 'title' => 'Účastníci'));
    }
    
    public function bufet() {
        $quantity_addition = new Quantity();
        $quantity_addition->select_sum('quantity', 'quantity_sum');
        $quantity_addition->where('type', 'addition');
        $quantity_addition->where_related('product', 'id', '${parent}.id');
        
        $quantity_subtraction = new Quantity();
        $quantity_subtraction->select_sum('quantity', 'quantity_sum');
        $quantity_subtraction->where('type', 'subtraction');
        $quantity_subtraction->where_related('product', 'id', '${parent}.id');
        
        $products = new Product();
        $products->order_by('price', 'asc');
        $products->select('*');
        $products->select_subquery($quantity_addition, 'plus_quantity');
        $products->select_subquery($quantity_subtraction, 'minus_quantity');
        $products->get_iterated();
        $this->parser->parse('web/controllers/strojak/bufet.tpl', array('products' => $products, 'title' => 'Bufet'));
    }
    
    public function jozkotest() {
        echo '<pre>';
        /*$andrej = new Person();
        $andrej->get_by_id(2);*/
        $jozko = new Person();
        $jozko->get_by_id(3);
        $jozkov_strojak = 0.0;
        
        $jozko_addition_operations = new Operation();
        $jozko_addition_operations->where_related_person($jozko);
        $jozko_addition_operations->where('type', 'addition');
        $jozko_addition_operations->select_sum('time', 'sum_time');
        $jozko_addition_operations->get();
        
        $jozkov_strojak += (double)$jozko_addition_operations->sum_time;
        
        $jozko_subtract_operations_simple = new Operation();
        $jozko_subtract_operations_simple->where_related_person($jozko);
        $jozko_subtract_operations_simple->where('type', 'subtraction');
        $jozko_subtract_operations_simple->select_sum('time', 'sum_time');
        
        $jozko_subtract_operations_advanced = new Operation();
        $jozko_subtract_operations_advanced->where_related_person($jozko);
        $jozko_subtract_operations_advanced->where('type', 'subtraction');
        $jozko_subtract_operations_advanced->include_related('quantity', 'id');
        $jozko_subtract_operations_advanced->include_related('quantity/product', 'id');
        $jozko_subtract_operations_advanced->where_related_quantity('type', 'subtraction');
        $jozko_subtract_operations_advanced->select_func('SUM', array('@quantities.quantity', '*', '@quantity_products.price'), 'sum_time');
        
        $query = $this->db->query('SELECT SUM(`ufs`.`sum_time`) AS `sum_time` FROM ((SELECT `fs`.`sum_time` FROM (' . $jozko_subtract_operations_advanced->get_sql() . ') as `fs`) UNION ALL (SELECT `fs`.`sum_time` FROM (' . $jozko_subtract_operations_simple->get_sql() . ') as `fs`)) `ufs`');
        echo $this->db->last_query() . "\n\n";
        $jozkov_strojak -= $query->row_object()->sum_time;
        echo 'Jozkov sucasny strojak je: ' . $jozkov_strojak;
        echo '</pre>';
    }
    
}