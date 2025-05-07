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
		$allsubcategory = $this->subcategoryModel->getAllsubCategory();
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

    // Always load category data
    $data['category'] = $this->subcategoryModel->getAllCategory();

    if ($sub_id) {
        $subcat = $this->subcategoryModel->getSubcategoryByid($sub_id);
		

        if (!$subcat) {
            return redirect()->to('subcategory')->with('error', 'subcategory not found');
        }

        $data['subcategory'] = (array) $subcat;
    }

    // Load views with $data always
    $template = view('common/header');
    $template .= view('common/leftmenu');
    $template .= view('subcategory_add', $data); // <-- now always includes category data
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

	if($cat_id && $subcategory_name && $discount_value && $discount_type) {
		if (empty($sub_id)) {
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
			$CreateSubcategory = $this->subcategoryModel->subcategoryInsert($data);
			
			echo json_encode(array(
				"status" => 1,
				"msg" => "Created successfully.",
				"redirect" => base_url('subcategory')
			));
			
		} 
		else {
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
			$modifyCategory = $this->subcategoryModel->updateSubcategory($sub_id,$data);
			echo json_encode(array(
				"status" => 1,
				"msg" => "Updated successfully.",
				"redirect" => base_url('subcategory')
			));
		}
	}
	else {
		return $this->response->setJSON([
			'status' => 'error',
			'message' => 'All fields are required.'
		]);
	}
	
}





    
    
    
  

  


}