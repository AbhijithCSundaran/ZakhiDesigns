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
		echo $keyword;
		exit;
		$products = $keyword ? $this->product_model->searchProducts($keyword) : [];

		// Remove duplicates by unique product ID (optional)
		$products = array_values(array_unique($products, SORT_REGULAR));

		return view('product_partial', ['product' => $products]);
	}
	public function products_lists()
	{
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
        $productModel = new ProductModel();
		$product = $productModel->getProductById($id);
		return view('common/header')
			. view('product_details', ['product' => $product])
			. view('pagescripts/productjs');
		}
}
