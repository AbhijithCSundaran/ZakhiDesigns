<?php 
namespace App\Controllers;

use App\Models\SubcategoryModel;
use CodeIgniter\Controller;
use App\Models\ProductDisplayModel;
use App\Models\ReviewModel;


class Subcategory extends Controller
{
    protected $SubcategoryModel;
    protected $session;
    protected $request;
    protected $productdisplayModel;
    protected $categories;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->subcategoryModel = new SubcategoryModel();
    }

   
   public function index(){
    $data = [];  
    return view('common/header', $data)
        . view('subcategory_list', $data)
        . view('common/footer')
         . view('pagescripts/subcategoryjs');
}
public function subcategoryProducts($id, $catId){
    $this->productdisplayModel = new ProductDisplayModel();
    $reviewModel = new ReviewModel();

    $this->categories = $this->productdisplayModel->getAllCategoriesAndSub();
	$data['categories'] = $this->categories;
    
    // $cat_id = $this->request->getGet('cat_id');
    $data['cat_id'] = $catId;
    $data['subcat_id'] = $this->subcategoryModel->getAllSubcategory($id);
    $data['product']   = $this->subcategoryModel->getAllProductUnderSubcategory($id);

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

    $data['similar'] = $this->subcategoryModel->getSimilarProducts( $catId,$id);
    if (!empty($data['similar'])) {
        $productIds = array_column($data['similar'], 'pr_Id');

        $avgRatings = $reviewModel->getAverageRatingForProducts($productIds);

        $ratingsMap = [];
        foreach ($avgRatings as $rating) {
            $ratingsMap[$rating['pr_Id']] = round($rating['avg_rating'], 1);
        }

        foreach ($data['similar'] as &$product) {
            $product['avg_rating'] = $ratingsMap[$product['pr_Id']] ?? 0;
        }
    }
    
    return view('common/header' , $data)
        . view('subcategory_list'   , $data)
        . view('common/footer')
        . view('pagescripts/subcategoryjs');
}
  
}
