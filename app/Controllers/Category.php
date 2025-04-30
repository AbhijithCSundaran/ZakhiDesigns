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

        $allcategory = $this->categoryModel->getAllCategory();
        $data['category'] =  $allcategory;
        // print_r($data['category']);
        // exit;
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('category', $data);
        $template.= view('common/footer');
        $template.= view('page_scripts/categoryjs');
        return $template;

        
    }
    public function addCategory()
    {
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('category_add');
        $template.= view('common/footer');
        $template.= view('page_scripts/categoryjs');
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

    public function changeStatus()
    {
        $catId = $this->request->getPost('cat_Id');
        $newStatus = $this->request->getPost('cat_Status');
    
        $categoryModel = new CategoryModel();
        $category = $categoryModel->getCategoryByid($catId);
    
        if (!$category) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Category not found'
            ]);
        }
    
        $update = $categoryModel->updateCategory($catId, ['cat_Status' => $newStatus]);
    
        if ($update) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status Updated Successfully!',
                'new_status' => $newStatus
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update status'
            ]);
        }
    }
    
    //Category Delete

    public function deleteCategory($cat_id) {
		if($cat_id) {
			$modified_by = $this->session->get('us_Id');
			$catStatus = $this->categoryModel->changeCategoryStatus(3, $cat_id, $modified_by);
			echo json_encode(1);
		}
		else {
			echo json_encode(2);
		}
	}


}