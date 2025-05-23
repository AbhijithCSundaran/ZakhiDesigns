<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\CategoryModel;

class Category extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->categoryModel = new \App\Models\Admin\CategoryModel();
    }

    public function index()
    {

        $allcategory = $this->categoryModel->getAllCategory();
        $data['category'] =  $allcategory;
        // print_r($data['category']);
        // exit;
        $template = view('Admin/common/header');
		$template.= view('Admin/common/leftmenu');
		$template.= view('Admin/category', $data);
        $template.= view('Admin/common/footer');
        $template.= view('Admin/page_scripts/categoryjs');
        return $template;

        
    }
    public function addCategory($cat_id = null)
	{
		if (!$this->session->get('zd_uid')) 
		{
			return redirect()->to(base_url('admin/category'));
		}

		$data = [];
		 if ($cat_id) {
			$cate = $this->categoryModel->getCategoryByid($cat_id);
		
			if (!$cate) {
				return redirect()->to('admin/category')->with('error', 'Category not found');
			}
			
			 $data['category'] = (array) $cate;
			
			
			$template = view('Admin/common/header');
			$template .= view('Admin/common/leftmenu');
			$template .= view('Admin/category_add', $data);
			$template .= view('Admin/common/footer');
			$template .= view('Admin/page_scripts/categoryjs');
			return $template;
		}
		else
		{
			$template = view('Admin/common/header');
			$template .= view('Admin/common/leftmenu');
			$template .= view('Admin/category_add');
			$template .= view('Admin/common/footer');
			$template .= view('Admin/page_scripts/categoryjs');
			return $template;
		}
		
	}

    public function saveCategory() {
    $cat_id = $this->input->getPost('cat_id');
    $category_name = $this->input->getPost('category_name');
    $discount_value = $this->input->getPost('discount_value');
    $discount_type = $this->input->getPost('discount_type');

    if ($category_name && $discount_value && $discount_type) {
        // 🔍 Check if category name already exists
        $exists = $this->categoryModel->isCategoryExists($category_name, $cat_id);
        if ($exists) {
            return $this->response->setJSON([
                'status' => 'error',
                'field' => 'category_name',
                'message' => 'Category name already exists.'
            ]);
        }

        $data = [
            'cat_Name' => $category_name,
            'cat_Discount_Value' => $discount_value,
            'cat_Discount_Type' => $discount_type,
            'cat_Status' => 1,
            'cat_createdon' => date("Y-m-d H:i:s"),
            'cat_createdby' => $this->session->get('zd_uid'),
            'cat_modifyby' => $this->session->get('zd_uid'),
        ];

        if (empty($cat_id)) {
            $CreateCategory = $this->categoryModel->categoryInsert($data);
            return $this->response->setJSON([
                "status" => 1,
                "msg" => "Category Created Successfully.",
                "redirect" => base_url('category')
            ]);
        } else {
            $modifyCategory = $this->categoryModel->updateCategory($cat_id, $data);
            return $this->response->setJSON([
                "status" => 1,
                "msg" => "Category Updated Successfully.",
                "redirect" => base_url('admin/category')
            ]);
        }
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'All fields are required.'
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
                'message' => 'Category Status Updated Successfully!',
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
		if ($cat_id) {
			$modified_by = $this->session->get('zd_uid');
			$cat_status = $this->categoryModel->deleteCategoryById(3, $cat_id, $modified_by);
	
			if ($cat_status) {
				echo json_encode([
					'success' => true,
					'msg' => 'category deleted Successfully.'
				]);
			} else {
				echo json_encode([
					'success' => false,
					'msg' => 'Failed to delete Category.'
				]);
			}
		} else {
			echo json_encode([
				'success' => false,
				'msg' => 'Invalid request.'
			]);
		}
	}


}