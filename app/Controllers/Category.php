<?php 
namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\Controller;
use App\Models\ReviewModel;
use App\Models\ProductDisplayModel;

class Category extends Controller
{
    protected $CategoryModel;
    protected $session;
    protected $request;
    protected $productdisplayModel;
    protected $categories;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->categoryModel = new CategoryModel();
    }

   
   public function index()
{
    $data = [];  
   
    return view('common/header', $data)
        . view('category_list', $data)
        . view('common/footer')
        . view('pagescripts/category_listjs');
}
public function category_list(){
     $this->productdisplayModel = new ProductDisplayModel();
     $this->categories = $this->productdisplayModel->getAllCategoriesAndSub();
	 $data['categories'] = $this->categories;

     $data['category'] = $this->categoryModel->getAllCategory();

    return view('common/header', $data)
        . view('category_list', $data)
        . view('common/footer')
        . view('pagescripts/category_listjs');
}
public function catProducts($id = null){
    $this->productdisplayModel = new ProductDisplayModel();
    $this->categories = $this->productdisplayModel->getAllCategoriesAndSub();
	$data['categories'] = $this->categories;
    $reviewModel = new ReviewModel();
    $data['cat_id'] = $id;

    $category = $this->categoryModel->where('cat_Id', $id)->first();
    if ($category) {
        $data['cat_Name'] = $category['cat_Name'];
    }

    $data['product'] = $this->categoryModel->getAllProductUnderCategory($id);
    $data['subcategory'] = $this->categoryModel->getAllSubcategoryUnderCategory($id);
    if (!empty($data['product'])) {
        // Step 1: Get all product IDs
        $productIds = array_column($data['product'], 'pr_Id');

        // Step 2: Get average ratings for all products
        $avgRatings = $reviewModel->getAverageRatingForProducts($productIds);

        // Step 3: Map ratings by pr_Id
        $ratingsMap = [];
        foreach ($avgRatings as $rating) {
            $ratingsMap[$rating['pr_Id']] = round($rating['avg_rating'], 1);
        }

        // Step 4: Attach avg_rating to each product
        foreach ($data['product'] as &$product) {
            $product['avg_rating'] = $ratingsMap[$product['pr_Id']] ?? 0;
        }
    }
     return view('common/header',  $data)
        . view('cat_products' , $data)
        . view('common/footer')
        . view('pagescripts/category_listjs');
}


    




  
}
