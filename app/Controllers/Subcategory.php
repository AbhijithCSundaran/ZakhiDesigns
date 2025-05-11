<?php
namespace App\Controllers;
use App\Models\SubcategoryModel;

class Subcategory extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->subcategoryModel = new SubcategoryModel();
    }

    public function index()
    {
		$allsubcategory = $this->subcategoryModel->getAllSubcategories();
		

        $data['subcategory'] =  $allsubcategory;
		

        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('subcategory', $data);
        $template.= view('common/footer');
        $template.= view('page_scripts/subcategoryjs');
        return $template;

}
public function addSubcategory($sub_id = null)
{
    if (!$this->session->get('zd_uid')) {
        return redirect()->to(base_url());
    }

    $data = [];
    $data['category'] = $this->subcategoryModel->getAllCategory();

    if ($sub_id) {
        $subcat = $this->subcategoryModel->getSubcategoryByid($sub_id);
		

        if (!$subcat) {
            return redirect()->to('subcategory')->with('error', 'subcategory not found');
        }

        $data['subcategory'] = (array) $subcat;
    }

    $template = view('common/header');
    $template .= view('common/leftmenu');
    $template .= view('subcategory_add', $data); 
    $template .= view('common/footer');
    $template .= view('page_scripts/subcategoryjs');
    return $template;
}

public function saveSubcategory() {
    $sub_id = $this->input->getPost('sub_id');
    $cat_id = $this->input->getPost('cat_id');
    $subcategory_name = $this->input->getPost('subcategory_name');
    $discount_value = $this->input->getPost('discount_value');
    $discount_type = $this->input->getPost('discount_type');

    if ($cat_id && $subcategory_name && $discount_value && $discount_type) {

        // Check if subcategory name already exists
        $exists = $this->subcategoryModel->issubCategoryExists($subcategory_name, $sub_id);
        if ($exists) {
            return $this->response->setJSON([
                'status' => 'error',
                'field' => 'subcategory_name',
                'message' => 'Subcategory name already exists.'
            ]);
        }

        $data = [
            'cat_Id' => $cat_id,
            'sub_Category_Name' => $subcategory_name,
            'sub_Discount_Value' => $discount_value,
            'sub_Discount_Type' => $discount_type,
            'sub_Status' => 1,
            'sub_createdon' => date("Y-m-d H:i:s"),
            'sub_createdby' => $this->session->get('zd_uid'),
            'sub_modifyby' => $this->session->get('zd_uid'),
        ];

        if (empty($sub_id)) {
            $this->subcategoryModel->subcategoryInsert($data);
            return $this->response->setJSON([
                "status" => 1,
                "msg" => "Subcategory Created successfully.",
                "redirect" => base_url('subcategory')
            ]);
        } else {
            $this->subcategoryModel->updateSubcategory($sub_id, $data);
            return $this->response->setJSON([
                "status" => 1,
                "msg" => "Subcategory Updated successfully.",
                "redirect" => base_url('subcategory')
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
	$subId = $this->request->getPost('sub_Id');
	$newStatus = $this->request->getPost('sub_Status');

	$subcategoryModel = new SubcategoryModel();
	$subcategory = $subcategoryModel->getsubCategoryByid($subId);

	if (!$subcategory) {
		return $this->response->setJSON([
			'success' => false,
			'message' => 'Subcategory not found'
		]);
	}

	$update = $subcategoryModel->updatesubCategory($subId, ['sub_Status' => $newStatus]);

	if ($update) {
		return $this->response->setJSON([
			'success' => true,
			'message' => 'Subcategory Status Updated Successfully!',
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


public function deleteSubcategory($sub_id) {
	if ($sub_id) {
		$modified_by = $this->session->get('zd_uid');
		$sub_status = $this->subcategoryModel->deleteSubcategoryById(3, $sub_id, $modified_by);
		if ($sub_status) {
			echo json_encode([
				'success' => true,
				'msg' => 'Subcategory Deleted Successfully.'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'msg' => 'Failed to Delete Subcategory.'
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
?>