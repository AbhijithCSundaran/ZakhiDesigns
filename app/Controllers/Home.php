<?php

namespace App\Controllers;
use App\Models\Admin\ProductModel;

class Home extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->productModel = new \App\Models\Admin\ProductModel();
    }

    public function index(): string
    {
       $allproducts = $this->productModel->getAllProducts();
		$data['product'] =  $allproducts;

	 	    $template = view('common/header');
            $template.= view('banner');
            $template.= view('category');
            $template.= view('top_products',$data);
            $template.= view('common/footer');       
			return $template;
            
	
    }
}