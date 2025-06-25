<?php 
namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\Controller;


class Category extends Controller
{
    protected $CategoryModel;
    protected $session;
    protected $request;

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

     $data['category'] = $this->categoryModel->getAllCategory();

    return view('common/header', $data)
        . view('category_list', $data)
        . view('common/footer')
        . view('pagescripts/category_listjs');
}
public function catProducts($id = null){
    $data['cat_id'] = $id;
    $category = $this->categoryModel->where('cat_Id', $id)->first();
    if($category){
        $data['cat_Name'] = $category['cat_Name'];
    } 
     $data['product'] = $this->categoryModel->getAllProductUnderCategory($id);
     return view('common/header',  $data)
        . view('cat_products' , $data)
        . view('common/footer')
        . view('pagescripts/category_listjs');
}


    




  
}
