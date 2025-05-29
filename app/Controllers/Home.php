<?php

namespace App\Controllers;
use App\Models\Admin\ProductModel;
use App\Models\Admin\Theme_Model;

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
      
         $themeModel = new \App\Models\Admin\Theme_Model();
    $themes = $themeModel->fetchTheme();
    if (!empty($themes)) {
        $data['themes'] = $themes[0]; 
    }


	 	    $template = view('common/header');
            $template.= view('banner', $data);
            $template.= view('category');
            $template.= view('top_products',$data);
             $template.= view('footer_banner',$data);
            $template.= view('common/footer');       
			return $template;
    }
}