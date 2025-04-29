<?php
namespace App\Controllers;
use App\Models\ProductModel;

class Product extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
       // $this->ProductModel = new ProductModel();
    }

    public function index()
    {
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('product');
		$template.= view('common/footer');
        return $template;

        
    }
}
