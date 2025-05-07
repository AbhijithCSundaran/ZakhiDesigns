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
    public function addProduct($pr_id = null)
	{
		if (!$this->session->get('zd_uid')) 
		{
			return redirect()->to(base_url());
		}

		$data = [];
		 if ($pr_id) {
			//$cate = $this->categoryModel->getCategoryByid($cat_id);
		
			// if (!$cate) {
			// 	return redirect()->to('category')->with('error', 'Category not found');
			// }
			
			// $data['category'] = (array) $cate;
			
			
			$template = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('product_add', $data);
			$template .= view('common/footer');
			//$template .= view('page_scripts/productjs');
			return $template;
		}
		else
		{
			$template = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('product_add');
			$template .= view('common/footer');
			//$template .= view('page_scripts/productjs');
			return $template;
		}
		
	}
}
