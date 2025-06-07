<?php

namespace App\Controllers;
use App\Models\ProductDisplayModel;

class ProductDetails extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->productModel = new \App\Models\ProductDisplayModel();
    }

    public function index(): string
    {
       $allproducts = $this->productModel->getAllProducts();
		$data['product'] =  $allproducts;
          $template = view('common/header');
            $template.= view('product_details',$data);
            $template.= view('top_products',$data);
            $template.= view('common/footer');       
			return $template;
            
	
    }
	
}