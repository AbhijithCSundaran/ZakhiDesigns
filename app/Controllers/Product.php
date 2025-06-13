<?php 
namespace App\Controllers;

use App\Models\ProductDisplayModel;
use CodeIgniter\Controller;
use App\Models\ReviewModel;

class Product extends Controller
{
    protected $productdisplayModel;
    protected $categories;
    protected $session;
    protected $request;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->productdisplayModel = new ProductDisplayModel();
		$this->reviewModel = new ReviewModel();
    }

    // Homepage - shows all products with categories and ratings
   public function index()
{
    $zd_uid = $this->session->get('zd_uid');
    $data = [];

    // Load categories for header
    $data['categories'] = $this->productdisplayModel->getAllCategoriesAndSub();

    // Load all products
    $products = $this->productdisplayModel->getAllProducts();
    $reviewModel = new ReviewModel();
    $data['product'] = $products;

    return view('common/header', $data)
        . view('products_list', $data)
        . view('common/footer')
        . view('pagescripts/productjs');
}
 /* public function similarProducts($pr_Id)
    {
        $model = new ProductModel();
        $product = $model->find($pr_Id);
        $similar = $model->getSimilarProducts($product['cat_Id'], $pr_Id);
		$data['similar']=$similar;
         return view('common/header', $data)
        . view('product_details', $data)
        . view('common/footer')
        . view('pagescripts/productjs');
    } */

    // Handles AJAX search
    public function ajaxSearch()
    {
				$zd_uid = $this->session->get('zd_uid');
    $data = [];

    // Load categories for header
    $data['categories'] = $this->productdisplayModel->getAllCategoriesAndSub();

    // Load all products
    $products = $this->productdisplayModel->getAllProducts();
    $reviewModel = new ReviewModel();
    $data['product'] = $products;
		$data['avg_rating'] = 1;
      //  $keyword = $this->request->getGet('keyword');
        
    $keyword = trim($this->request->getGet('keyword'));

        $products = $keyword ? $this->productdisplayModel->searchProducts($keyword) : [];

        $products = array_values(array_unique($products, SORT_REGULAR));

        return view('common/header',$data)
            . view('products_list', ['product' => $products])
            . view('common/footer')
            . view('pagescripts/productjs');
    }

    public function product_list()
    {
       // $data['product'] = $this->productdisplayModel->getAllProducts();
		
		$zd_uid = $this->session->get('zd_uid');
    $data = [];

    // Load categories for header
    $data['categories'] = $this->productdisplayModel->getAllCategoriesAndSub();

    // Load all products
    $products = $this->productdisplayModel->getAllProducts();
    $reviewModel = new ReviewModel();
    $data['product'] = $products;
	$data['avg_rating'] = 1;

        return view('common/header',$data)
            . view('products_list', $data)
            . view('common/footer')
            . view('pagescripts/productjs');
    }

    public function view_collection()
    {
	$zd_uid = $this->session->get('zd_uid');
    $data = [];

    // Load categories for header
    $data['categories'] = $this->productdisplayModel->getAllCategoriesAndSub();

    // Load all products
    $products = $this->productdisplayModel->getAllProducts();
    $reviewModel = new ReviewModel();
    $data['product'] = $products;
		$data['avg_rating'] = 1;
        $data['product'] = $this->productdisplayModel->getProductsByModifiedDate();
        return view('common/header',$data)
            . view('products_list', $data)
            . view('common/footer')
            . view('pagescripts/productjs');
    }

    public function product_list_by_category($cat_Id)
	{
	$zd_uid = $this->session->get('zd_uid');
    $data = [];

    // Load categories for header
    $data['categories'] = $this->productdisplayModel->getAllCategoriesAndSub();

    // Load all products
    $products = $this->productdisplayModel->getAllProducts();
    $reviewModel = new ReviewModel();
		$data['product'] = $products;
		$data['avg_rating'] = 1;
        $data['product'] = $this->productdisplayModel->getProductsByCategoryName($cat_Id);
        return view('common/header',$data)
            . view('products_list', $data)
            . view('common/footer')
            . view('pagescripts/productjs');
    }

    public function product_list_by_subcategory($sub_Id)
    {
				$zd_uid = $this->session->get('zd_uid');
    $data = [];

    // Load categories for header
    $data['categories'] = $this->productdisplayModel->getAllCategoriesAndSub();

    // Load all products
    $products = $this->productdisplayModel->getAllProducts();
    $reviewModel = new ReviewModel();
    $data['product'] = $products;
		$data['avg_rating'] = 1;
        $data['product'] = $this->productdisplayModel->getProductsBySubcategoryName($sub_Id);
        return view('common/header',$data)
            . view('products_list', $data)
            . view('common/footer')
            . view('pagescripts/productjs');
    }

    public function search_products()
    {
		
		$zd_uid = $this->session->get('zd_uid');
    $data = [];

    // Load categories for header
    $data['categories'] = $this->productdisplayModel->getAllCategoriesAndSub();

    // Load all products
    $products = $this->productdisplayModel->getAllProducts();
    $reviewModel = new ReviewModel();
    $data['product'] = $products;
	$data['avg_rating'] = 1;
        $keyword = $this->request->getPost('keyword');
        //$data['product'] = $this->productdisplayModel->searchProducts($keyword);
        return view('common/header',$data)
            . view('products_list', $data)
            . view('common/footer')
            . view('pagescripts/productjs');
    }

    public function products_lists()
    {
	$zd_uid = $this->session->get('zd_uid');
    $data = [];

    // Load categories for header
    $data['categories'] = $this->productdisplayModel->getAllCategoriesAndSub();

    // Load all products
    $products = $this->productdisplayModel->getAllProducts();
    $reviewModel = new ReviewModel();
        $data['product'] = $products;
		$data['avg_rating'] = 1;
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

        return view('common/header',$data)
            . view('products_list', $data)
            . view('common/footer')
            . view('pagescripts/productjs');
    }

   public function product_details($id)
{
	$reviewModel = new ReviewModel();
    $zd_uid = $this->session->get('zd_uid');
    $data = [];

    // Load categories for header
    $data['categories'] = $this->productdisplayModel->getAllCategoriesAndSub();

    // Get single product
    $product = $this->productdisplayModel->getProductById($id);

    if (!$product) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found');
    }

    // Get similar products
    $data['similar'] = $this->productdisplayModel->getSimilarProducts($product['cat_Id'], $id);

    // Product data for main view
    $data['product'] = $product;
	
   // Fetch limited reviews (e.g., 5 reviews)
	//$data['reviews'] = $this->reviewModel->getLimitedReviewsByProductId($id, 5);
	// Get the total count of reviews for the product
	//$data['total_reviews_count'] = $this->reviewModel->getReviewCountByProductId($id);
		$data['reviews'] = $this->reviewModel->getLimitedReviewsByProductId($id, 5);
		$data['total_reviews_count'] = $this->reviewModel->getReviewCountByProductId($id);



    // Rating (optional logic here if implemented)
    $data['avg_rating'] = 1;

    // Product Images
    $imageList = [];
    if (!empty($product['product_images'])) {
        $imgJson = json_decode($product['product_images'], true);
        $imageList = $imgJson[0]['name'] ?? [];
    }

    $videoName = !empty($product['product_video']) ? trim($product['product_video']) : null;

    return view('common/header', $data)
        . view('product_details', [
            'product' => $product,
            'zd_uid' => $zd_uid,
            'imageList' => $imageList,
            'videoName' => $videoName,
            'similar' => $data['similar'],
			'total_reviews_count' => $data['total_reviews_count']			// explicitly pass if needed
        ])
        . view('common/footer')
        . view('pagescripts/productjs');
}

    public function submit()
    {
        $zd_uid = $this->session->get('zd_uid');
        if (empty($zd_uid)) {
            return redirect()->to(base_url('weblogin'));
        }

        $cust_id  = $this->request->getPost('cust_Id');
        $pr_Id    = $this->request->getPost('pr_Id');
        $size     = $this->request->getPost('size');
        $color    = $this->request->getPost('selected_color');
        $qty      = (int)$this->request->getPost('qty');
        $product  = $this->productdisplayModel->getProductById($pr_Id);

        $productName    = $product['pr_Name'] ?? '';
        $original_price = $product['mrp'] ?? '';
        $selling_price  = (float)($product['pr_Selling_Price'] ?? 0);
        $discount_value = $product['pr_Discount_Value'] ?? '';
        $discount_type  = $product['pr_Discount_Type'] ?? '';
        $pr_code        = $product['pr_Code'] ?? '';
        $grand_total    = $selling_price * $qty;

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
                'od_Grand_Total'    => $grand_total,
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
                'msg'    => 'Please select Size, Color and Quantity.',
            ]);
        }
    }
}
