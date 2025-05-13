<?php
namespace App\Controllers;
use App\Models\ProductModel;

class Product extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->productModel = new ProductModel();
    }

    public function index()
    {

        $allproducts = $this->productModel->getAllProducts();
		$data['product'] =  $allproducts;
      

        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('product', $data);
        $template.= view('product_add_modal');
		$template.= view('common/footer');
        $template .= view('page_scripts/productjs');
        return $template;

    }
   
public function addProduct($pr_id = null)
{
    if (!$this->session->get('zd_uid')) {
        return redirect()->to(base_url());
    }

    $data = [];
   $data['categories'] = $this->productModel->getAllCategories(); // NEW function
    $template = view('common/header');
    $template .= view('common/leftmenu');
    $template .= view('product_add', $data);
    $template .= view('common/footer');
    $template .= view('page_scripts/productjs');
    return $template;
}

public function getSubcategories()
{
    $cat_id = $this->request->getPost('cat_id');
    $subcategories = $this->productModel->getSubcategoriesByCatId($cat_id);
    return $this->response->setJSON($subcategories);
}


//Product save

public function saveProduct() {
    $pr_id = $this->input->getPost('pr_id');
    $sub_id = $this->input->getPost('sub_id');
    $cat_id = $this->input->getPost('cat_id');
    $product_name = $this->input->getPost('product_name');
    $product_code = $this->input->getPost('product_code');
    $product_description = $this->input->getPost('product_description');
    $mrp = $this->input->getPost('mrp');
    $selling_price = $this->input->getPost('selling_price');
    $product_stock = $this->input->getPost('product_stock');
    $reset_stock = $this->input->getPost('reset_stock');
    $discount_value = $this->input->getPost('discount_value');
    $discount_type = $this->input->getPost('discount_type');

    // Validate required fields
    if (!$cat_id || !$sub_id || !$discount_value || !$discount_type || !$product_name || !$product_code || !$mrp || !$selling_price) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'All required fields must be filled.'
        ]);
    }

    // Common data array
    $data = [
        'pr_Name' => $product_name,
        'pr_Code' => $product_code,
        'pr_Description' => $product_description,
        'mrp' => $mrp,
        'pr_Selling_Price' => $selling_price,
        'pr_Discount_Value' => $discount_value,
        'pr_Discount_Type' => $discount_type,
        'cat_Id' => $cat_id,
        'sub_Id' => $sub_id,
        'pr_Stock' => $product_stock,
        'pr_Reset_Stock' => $reset_stock,
        'pr_Status' => 1,
        'pr_modifyby' => $this->session->get('zd_uid'),
        'pr_modifyon' => date("Y-m-d H:i:s"),
    ];

    if (empty($pr_id)) {
        
        $data['pr_createdon'] = date("Y-m-d H:i:s");
        $data['pr_createdby'] = $this->session->get('zd_uid');

        $this->productModel->productInsert($data);

        return $this->response->setJSON([
            'status' => 1,
            'msg' => 'Product Created successfully.',
            'redirect' => base_url('product')
        ]);
    } else {
        // Update existing product
        $this->productModel->updateProduct($pr_id, $data);

        return $this->response->setJSON([
            'status' => 1,
            'msg' => 'Product Updated successfully.',
            'redirect' => base_url('product')
        ]);
    }
}

//Media upload
public function uploadMedia()
{
    $productId = $this->request->getPost('product_id');
    $files = $this->request->getFileMultiple('files'); // Corrected

    $newFileNames = [];

    if ($files) {
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $name = $file->getRandomName();
                $file->move(FCPATH . 'uploads/productmedia/', $name);
                $newFileNames[] = $name;
            }
        }

       $productModel = new ProductModel();
      
	   $existingMediaJson = $productModel->getProductImages($productId);


      $existingMedia = json_decode($existingMediaJson, true);

        $allNames = [];

        if (!empty($existingMedia) && isset($existingMedia[0]['name'])) {
            $allNames = $existingMedia[0]['name'];
        }

        $allNames = array_merge($allNames, $newFileNames);

        $updatedJson = [
            ['name' => $allNames]
        ];

        $productModel->updateProductImages($productId, json_encode($updatedJson));

        return $this->response->setJSON(['success' => true]);
    }

    return $this->response->setJSON(['success' => false]);
}

//get product images
public function getProductImages($productId)
{
    $productModel = new ProductModel();
    $imagesJson = $productModel->getProductImages($productId);
    $images = json_decode($imagesJson, true);
    
    // Extract image names
    $imageList = $images[0]['name'] ?? [];

    return $this->response->setJSON($imageList);
}

//Delte the whole product
public function deleteProduct($pr_id) {
	if ($pr_id) {
		$modified_by = $this->session->get('zd_uid');
		$pr_status = $this->productModel->deleteProductById(3, $pr_id, $modified_by);
		if ($pr_status) {
			echo json_encode([
				'success' => true,
				'msg' => 'Product Deleted Successfully.'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'msg' => 'Failed to Delete Product.'
			]);
		}
	} else {
		echo json_encode([
			'success' => false,
			'msg' => 'Invalid request.'
		]);
	}
}

//Delete the single product


public function deleteProductImage()
{
    $request = $this->request->getJSON(true);

    $productId = $request['product_id'] ?? null;
    $image = $request['image'] ?? null;

    if (!$productId || !$image) {
        return $this->response->setJSON(['success' => false, 'message' => 'Missing product_id or image.']);
    }

    // Delete from folder
    $imagePath = FCPATH . 'uploads/productmedia/' . $image;

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete from database
    $productModel = new \App\Models\ProductModel();
    $deleted = $productModel->delete_image($productId, $image);

    return $this->response->setJSON([
        'success' => $deleted,
        'message' => $deleted ? 'Image deleted successfully.' : 'Image not deleted from DB.'
    ]);
}













}