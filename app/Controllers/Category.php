<?php
namespace App\Controllers;
use App\Models\CategoryModel;

class Category extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('category');
		$template.= view('common/footer');
        return $template;

        
    }
    public function addCategory()
    {
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('category_add');
        $template.= view('page_scripts/categoryjs');
		$template.= view('common/footer');
        return $template;
    }
    public function saveCategory()
    {
        $categoryname = $this->request->getPost('category_name');
        $discountvalue = $this->request->getPost('discount_value');
        $discounttype = $this->request->getPost('discount_type');

        if (empty($categoryname) || empty($discountvalue) || empty($discounttype)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'All fields are required.'
            ]);
        }

    
        $data = [
            'cat_Name' => $categoryname,
            'cat_Discount_Value' => $discountvalue,
            'cat_Discount_Type' => $discounttype,
            'cat_Status' => 1

        ];
       
       if ($this->categoryModel->categoryInsert($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Category inserted successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to insert category.'
            ]);
        }
    }
}


