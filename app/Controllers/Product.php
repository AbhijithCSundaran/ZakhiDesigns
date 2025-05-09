<?php
namespace App\Controllers;
use App\Models\ProductModel;

class Product extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->productModel = new ProductModel();
    }

    public function index()
    {

        $allproducts = $this->productModel->getAllProducts();
		$data['product'] =  $allproducts;
      

        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('product', $data);
		$template.= view('common/footer');
        return $template;

    }
   
	public function addProduct($pr_id = null)
{
    if (!$this->session->get('zd_uid')) {
        return redirect()->to(base_url());
    }

    $data = [];
    $data['category'] = $this->productModel->getAllCatandSub();
	

    // if ($pr_id) {
    //     $product = $this->productModel->getSubcategoryByid($sub_id);
		

    //     if (!$subcat) {
    //         return redirect()->to('subcategory')->with('error', 'subcategory not found');
    //     }

    //     $data['subcategory'] = (array) $subcat;
    // }

    $template = view('common/header');
    $template .= view('common/leftmenu');
    $template .= view('product_add', $data); 
    $template .= view('common/footer');
    $template .= view('page_scripts/productjs');
    return $template;
}


public function saveProduct() {
    $pr_id = $this->input->getPost('pr_id');
    $sub_id = $this->input->getPost('sub_id');
    $cat_id = $this->input->getPost('cat_id');
    $product_name = $this->input->getPost('product_name');
    $product_code = $this->input->getPost('product_code');
    $product_description = $this->input->getPost('product_description');
    $mrp = $this->input->getPost('mrp');
    $selling_price = $this->input->getPost('selling_price');
    $product_stock = $this->input->getPost('product_stock');
    $reset_stock = $this->input->getPost('reset_stock');
    $discount_value = $this->input->getPost('discount_value');
    $discount_type = $this->input->getPost('discount_type');

    // Validate required fields
    if (!$cat_id || !$sub_id || !$discount_value || !$discount_type || !$product_name || !$product_code || !$mrp || !$selling_price) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'All required fields must be filled.'
        ]);
    }

    // Common data array
    $data = [
        'pr_Name' => $product_name,
        'pr_Code' => $product_code,
        'pr_Description' => $product_description,
        'mrp' => $mrp,
        'pr_Selling_Price' => $selling_price,
        'pr_Discount_Value' => $discount_value,
        'pr_Discount_Type' => $discount_type,
        'cat_Id' => $cat_id,
        'sub_Id' => $sub_id,
        'pr_Stock' => $product_stock,
        'pr_Reset_Stock' => $reset_stock,
        'pr_Status' => 1,
        'pr_modifyby' => $this->session->get('zd_uid'),
        'pr_modifyon' => date("Y-m-d H:i:s"),
    ];

    if (empty($pr_id)) {
        // Create new product
        $data['pr_createdon'] = date("Y-m-d H:i:s");
        $data['pr_createdby'] = $this->session->get('zd_uid');

        $this->productModel->productInsert($data);

        return $this->response->setJSON([
            'status' => 1,
            'msg' => 'Product Created successfully.',
            'redirect' => base_url('product')
        ]);
    } else {
        // Update existing product
        $this->productModel->updateProduct($pr_id, $data);

        return $this->response->setJSON([
            'status' => 1,
            'msg' => 'Product Updated successfully.',
            'redirect' => base_url('product')
        ]);
    }
}





}
