<?php namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;

class Product extends Controller
{
    protected $product_model;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->product_model = new ProductModel();
    }

    // Homepage - shows all products
    public function index()
    {
		$zd_uid = $this->session->get('zd_uid');
		$data = [];
        $data['product'] = $this->product_model->getAllProducts();

        return view('common/header')
            . view('products_list', $data)
            . view('common/footer')
            . view('pagescripts/productjs');
    }

    // Handles AJAX search - returns JSON (optional use)
	public function ajaxSearch()
    {
        $this->product_model = new ProductModel();
        $keyword = $this->request->getGet('keyword');
        $products = $keyword ? $this->product_model->searchProducts($keyword) : [];
 
        // Remove duplicates by unique product ID (optional)
        $products = array_values(array_unique($products, SORT_REGULAR));

		return view('common/header')
			. view('products_list', ['product' => $products])
			. view('common/footer')
			. view('pagescripts/productjs');
    }
	public function products_lists()
	{
		//$zd_uid = $this->session->get('zd_uid');
		$keyword = $this->request->getGet('keyword'); // this will read ?keyword=something

		if ($keyword) {
			$data['product'] = $this->product_model->searchProducts($keyword);
			$data['search'] = $keyword;
		} else {
			$data['product'] = $this->product_model->getAllProducts();
			$data['search'] = '';
		}

		return view('common/header')
			. view('products_list', $data)
			. view('common/footer')
			. view('pagescripts/productjs');
	}


	public function product_details($id)
{
    $zd_uid = $this->session->get('zd_uid');
    $productModel = new ProductModel();
	$product = $productModel->getProductById($id);

	// Decode images from JSON
	$imageList = [];
	if (!empty($product['product_images'])) {
		$imgJson = json_decode($product['product_images'], true);
		$imageList = $imgJson[0]['name'] ?? [];
	}

	// Single video (not array)
	$videoName = !empty($product['product_video']) ? trim($product['product_video']) : null;

	return view('common/header')
		. view('product_details', [
			'product' => $product,
			'zd_uid' => $this->session->get('zd_uid'),
			'imageList' => $imageList,
			'videoName' => $videoName
		])
		. view('pagescripts/productjs');

	}

public function submit()
{
	$this->product_model = new ProductModel();
	$zd_uid = $this->session->get('zd_uid');
	if (empty($zd_uid)) {
		return redirect()->to(base_url());
	}
	
	$cust_id  = $this->request->getPost('cust_Id');
	$pr_Id    = $this->request->getPost('pr_Id');
	$size     = $this->request->getPost('size');
	$color    = $this->request->getPost('selected_color');
	$qty      = $this->request->getPost('qty');
	$product = $this->product_model->getProductById($pr_Id);
	$productName    = $product['pr_Name'] ?? '';
	$original_price = $product['mrp'] ?? '';
	$selling_price  = $product['pr_Selling_Price'] ?? '';
	$discount_value = $product['pr_Discount_Value'] ?? '';
	$discount_type  = $product['pr_Discount_Type'] ?? '';
	$pr_code        = $product['pr_Code'] ?? '';
	$subtotal = $selling_price * $qty;
	$grand_total = $subtotal - $discount_value;


	if (!empty($cust_id) && !empty($pr_Id) && !empty($size) && !empty($color) && !empty($qty)) {
		$data = [
			'cus_Id'            => $cust_id,
			'pr_Id'             => $pr_Id,
			'od_Size'           => $size,
			'od_Color'          => $color,
			'od_Quantity'       => $qty,
			'od_Original_Price' => $original_price,
			'od_Selling_Price'  => $selling_price,
			'od_DiscountValue'  => $discount_value,
			'od_DiscountType'   => $discount_type,
			'pr_Code'           => $pr_code,
			'od_Status'			=>1,
			'od_Grand_Total' 	=> $grand_total,
			'od_createdon'      => date("Y-m-d H:i:s"),
			'od_createdby'      => $zd_uid,
			'od_modifyby'       => $zd_uid,
		];

		$od_Id = $this->product_model->insertOrder($data);
		if ($od_Id) {
			return $this->response->setJSON([
				'status' => 1,
				'msg'    => 'Order Placed Successfully.',
				'od_Id'  => $od_Id
			]);
		} else {
			return $this->response->setJSON([
				'status' => 'error',
				'msg'    => 'Failed to place order.'
			]);
		}
	} else {
		return $this->response->setJSON([
			'status' => 0,
			'msg'    => 'Please select Options.'
		]);
	}
}

}
