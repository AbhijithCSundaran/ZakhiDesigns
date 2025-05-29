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



}
