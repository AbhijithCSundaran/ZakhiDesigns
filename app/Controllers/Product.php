<?php namespace App\Controllers;

use App\Models\ProductDisplayModel;
use CodeIgniter\Controller;

class Product extends Controller
{
    protected $productdisplayModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->productdisplayModel = new ProductDisplayModel();
    }

    // Homepage - shows all products
    public function index()
    {
		$zd_uid = $this->session->get('zd_uid');
		$data = [];
        $data['product'] = $this->productdisplayModel->getAllProducts();

        return view('common/header')
            . view('products_list', $data)
            . view('common/footer')
            . view('pagescripts/productjs');
    }

    // Handles AJAX search - returns JSON (optional use)
	public function ajaxSearch()
    {
        $this->productdisplayModel = new ProductDisplayModel();
        $keyword = $this->request->getGet('keyword');
        $products = $keyword ? $this->productdisplayModel->searchProducts($keyword) : [];
 
        // Remove duplicates by unique product ID (optional)
        $products = array_values(array_unique($products, SORT_REGULAR));

		return view('common/header')
			. view('products_list', ['product' => $products])
			. view('common/footer')
			. view('pagescripts/productjs');
    }
	public function product_list()
    {
        $productdisplayModel = new ProductDisplayModel();
        $data['product'] = $productdisplayModel->getAllProduct();
        return view('common/header')
        . view('products_list', $data)
        . view('common/footer')
        . view('pagescripts/productjs');
    }

    public function product_list_by_category($cat_Id)
    {
        $productdisplayModel = new ProductDisplayModel();
        $data['product'] = $productdisplayModel->getProductsByCategoryName($cat_Id);
        return view('common/header')
        . view('products_list', $data)
        . view('common/footer')
        . view('pagescripts/productjs');
    }

    public function product_list_by_subcategory($sub_Id)
    {
        $productdisplayModel = new ProductDisplayModel();
        $data['product'] = $productdisplayModel->getProductsBySubcategoryName($sub_Id);
        return view('common/header')
        . view('products_list', $data)
        . view('common/footer')
        . view('pagescripts/productjs');
    }

    public function search_products()
    {
        $keyword = $this->request->getPost('keyword');
        $productdisplayModel = new ProductDisplayModel();
        $data['product'] = $productdisplayModel->searchProducts($keyword);
        return view('common/header')
        . view('products_list', $data)
        . view('common/footer')
        . view('pagescripts/productjs');
    }
	public function products_lists()
{
    $categoryId    = $this->request->getGet('category');
    $subCategoryId = $this->request->getGet('subcategory');
    $keyword       = $this->request->getGet('keyword');

    if ($categoryId) {
        $data['product'] = $this->productdisplayModel->getProductsByCategory($categoryId);
        $data['filter_type'] = 'category';
    } elseif ($subCategoryId) {
        $data['product'] = $this->productdisplayModel->getProductsBySubCategory($subCategoryId);
        $data['filter_type'] = 'subcategory';
    } elseif ($keyword) {
        $data['product'] = $this->productdisplayModel->searchProducts($keyword);
        $data['filter_type'] = 'search';
        $data['search'] = $keyword;
    } else {
        $data['product'] = $this->productdisplayModel->getAllProducts();
        $data['filter_type'] = 'all';
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
    $productdisplayModel = new ProductDisplayModel();
	$product = $productdisplayModel->getProductById($id);

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
		.view('common/footer')
		. view('pagescripts/productjs');

	}

public function submit()
{
	$this->productdisplayModel = new ProductDisplayModel();
	$zd_uid = $this->session->get('zd_uid');
	if (empty($zd_uid)) {
		return redirect()->to(base_url('weblogin'));
	}
	
	$cust_id  = $this->request->getPost('cust_Id');
	$pr_Id    = $this->request->getPost('pr_Id');
	$size     = $this->request->getPost('size');
	$color    = $this->request->getPost('selected_color');
	$qty      = (int)$this->request->getPost('qty');
	$product = $this->productdisplayModel->getProductById($pr_Id);
	$productName    = $product['pr_Name'] ?? '';
	$original_price = $product['mrp'] ?? '';
	$selling_price  = (float)$product['pr_Selling_Price'] ?? '';
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
			'od_Grand_Total' 	=> $grand_total,
			'od_createdon'      => date("Y-m-d H:i:s"),
			'od_createdby'      => $zd_uid,
			'od_modifyby'       => $zd_uid,
		];

		$od_Id = $this->productdisplayModel->insertOrder($data);
		if ($od_Id) {
			return $this->response->setJSON([
				'status' => 1,
				'msg'    => 'Order Placed Successfully.',
				'od_Id'  => $od_Id,
				'redirect' => base_url('ordernow/product/' . $od_Id)
			]);
		} else {
			return $this->response->setJSON([
				'status' => 0,
				'msg'    => 'Failed to place order.'
			]);
		}
	} else {
		return $this->response->setJSON([
			'status' => 0,
			'msg'    => 'Please select Size,Color and Quantity.',
		]);
	}
}

}
