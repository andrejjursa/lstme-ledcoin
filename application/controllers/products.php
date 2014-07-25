<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of products
 *
 * @author Andrej
 */
class Products extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        auth_redirect_if_not_admin('error/no_admin');
    }
    
    public function index() {
        $quantity_addition = new Product_quantity();
        $quantity_addition->select_sum('quantity', 'quantity_sum');
        $quantity_addition->where('type', 'addition');
        $quantity_addition->where_related('product', 'id', '${parent}.id');
        
        $quantity_subtraction = new Product_quantity();
        $quantity_subtraction->select_sum('quantity', 'quantity_sum');
        $quantity_subtraction->where('type', 'subtraction');
        $quantity_subtraction->where_related('product', 'id', '${parent}.id');
        
        $products = new Product();
        $products->order_by('title', 'asc');
        $products->select('*');
        $products->select_subquery($quantity_addition, 'plus_quantity');
        $products->select_subquery($quantity_subtraction, 'minus_quantity');
        $products->get_iterated();
        
        $this->parser->parse('web/controllers/products/index.tpl', array(
            'title' => 'Administrácia / Bufet',
            'new_item_url' => site_url('products/new_product'),
            'products' => $products,
        ));
    }
    
    public function new_product() {
        $this->parser->parse('web/controllers/products/new_product.tpl', array(
            'title' => 'Administrácia / Bufet / Nový produkt',
            'back_url' => site_url('products'),
            'form' => $this->get_product_form(),
        ));
    }
    
    public function create_product() {
        build_validator_from_form($this->get_product_form());
        if ($this->form_validation->run()) {
            $product_data = $this->input->post('product');
            $product = new Product();
            $product->from_array($product_data, array('title', 'price'));
            if ($product->save()) {
                add_success_flash_message('Produkt <strong>' . $product->title . '</strong> s cenou <strong>' . $product->price . '</strong> a s ID <strong>' . $product->id . '</strong> bol úspešne vytvorený.');
                redirect(site_url('products'));
            } else {
                add_error_flash_message('Produkt <strong>' . $product->title . '</strong> s cenou <strong>' . $product->price . '</strong> sa nepodarilo vytvoriť.');
                redirect(site_url('products/new_product'));
            }
        } else {
            $this->new_product();
        }
    }
    
    public function edit_product($product_id = NULL) {
        if (is_null($product_id)) {
            add_error_flash_message('Produkt sa nenašiel.');
            redirect(site_url('products'));
        }
        
        $product = new Product();
        $product->get_by_id((int)$product_id);
        
        if (!$product->exists()) {
            add_error_flash_message('Produkt sa nenašiel.');
            redirect(site_url('products'));
        }
        
        $this->parser->parse('web/controllers/products/edit_product.tpl', array(
            'product' => $product,
            'title' => 'Administrácia / Bufet / Úprava produktu',
            'form' => $this->get_product_form(),
            'back_url' => site_url('products'),
        ));
    }
    
    public function update_product($product_id = NULL) {
        if (is_null($product_id)) {
            add_error_flash_message('Produkt sa nenašiel.');
            redirect(site_url('products'));
        }
        
        $this->db->trans_begin();
        $product = new Product();
        $product->get_by_id((int)$product_id);
        
        if (!$product->exists()) {
            $this->db->trans_rollback();
            add_error_flash_message('Produkt sa nenašiel.');
            redirect(site_url('products'));
        }
        
        build_validator_from_form($this->get_product_form());
        if ($this->form_validation->run()) {
            $product_data = $this->input->post('product');
            $product->from_array($product_data, array('title', 'price'));
            if ($product->save() && $this->db->trans_status()) {
                $this->db->trans_commit();
                add_success_flash_message('Produkt s ID <strong>' . $product->id . '</strong> bol úspešne upravený.');
                redirect(site_url('products'));
            } else {
                $this->db->trans_rollback();
                add_error_flash_message('Produk s ID <strong>' . $product->id . '</strong> sa nepodarilo upraviť.');
                redirect(site_url('products/edit_product/' . (int)$product->id));
            }
        } else {
            $this->db->trans_rollback();
            $this->edit_product($product_id);
        }
    }
    
    public function delete_product($product_id = NULL) {
        if (is_null($product_id)) {
            add_error_flash_message('Produkt sa nenašiel.');
            redirect(site_url('products'));
        }
        
        $this->db->trans_begin();
        $product = new Product();
        $product->include_related_count('product_quantity', 'product_quantity_count');
        $product->get_by_id((int)$product_id);
        
        if (!$product->exists()) {
            $this->db->trans_rollback();
            add_error_flash_message('Produkt sa nenašiel.');
            redirect(site_url('products'));
        }
        
        if ((int)$product->product_quantity_count > 0) {
            $this->db->trans_rollback();
            add_error_flash_message('Produkt nie je možné vymazať, keď už obsahuje záznamy o množstve.');
            redirect(site_url('products'));
        }
        
        $success_message = 'Produkt <strong>' . $product->title . '</strong> s ID <strong>' . $product->id . '</strong> bol úspešne vymazaný.';
        $error_message = 'Produkt <strong>' . $product->title . '</strong> s ID <strong>' . $product->id . '</strong> sa nepodarilo vymazať.';
        
        if ($product->delete() && $this->db->trans_status()) {
            $this->db->trans_commit();
            add_success_flash_message($success_message);
            redirect(site_url('products'));
        } else {
            $this->db->trans_rollback();
            add_error_flash_message($error_message);
            redirect(site_url('products'));
        }
    }
    
    public function stock($product_id = NULL) {
        if (is_null($product_id)) {
            add_error_flash_message('Produkt sa nenašiel.');
            redirect(site_url('products'));
        }
        
        $product = new Product();
        $product->get_by_id((int)$product_id);
        
        if (!$product->exists()) {
            add_error_flash_message('Produkt sa nenašiel.');
            redirect(site_url('products'));
        }
        
        $product_quantities = new Product_quantity();
        $product_quantities->where_related_product($product);
        $product_quantities->where('type', 'addition');
        $product_quantities->order_by('created', 'desc');
        $product_quantities->get_iterated();
        
        $this->parser->parse('web/controllers/products/stock.tpl', array(
            'title' => 'Administrácia / Bufet / Sklad produktu / ' . $product->title,
            'product_quantities' => $product_quantities,
            'product' => $product,
            'new_item_url' => site_url('products/new_product_quantity/' . $product->id),
        ));
    }

    public function get_product_form() {
        $form = array(
            'fields' => array(
                'title' => array(
                    'name' => 'product[title]',
                    'id' => 'product-title',
                    'type' => 'text_input',
                    'label' => 'Názov',
                    'object_property' => 'title',
                    'validation' => 'required',
                ),
                'price' => array(
                    'name' => 'product[price]',
                    'id' => 'product-price',
                    'type' => 'text_input',
                    'label' => 'Cena',
                    'object_property' => 'price',
                    'hint' => 'Cena musí byť celé číslo vačšie ako nula.',
                    'validation' => 'required|integer|greater_than[0]',
                ),
            ),
            'arangement' => array(
                'title', 'price',
            ),
        );
        return $form;
    }
    
}

?>
