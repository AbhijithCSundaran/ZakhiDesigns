<?php
namespace App\Controllers;
use App\Models\ProductImageModel;

class ProductImage extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->productimageModel = new ProductImageModel();
    }

    public function index()
    {

        // $allproducts = $this->productModel->getAllProducts();
		
       
        // $data['product'] =  $allproducts;
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('productimage' );
		$template.= view('common/footer');
        return $template;

    }
    public function addProductImage($pri_id = null)
    {
        if (!$this->session->get('zd_uid')) {
            return redirect()->to(base_url());
        }
    
        $data = [];
        $data['products'] = $this->productimageModel->getAllProducts();
        
        $template = view('common/header');
        $template .= view('common/leftmenu');
        $template .= view('productimage_add',$data); 
        $template .= view('common/footer');
        $template .= view('page_scripts/productimagejs');
        return $template;
    }
    
   









}
