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
        $template.= view('product_video_modal');
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
   $data['categories'] = $this->productModel->getAllCategories(); 

      if ($pr_id) {
        $product = $this->productModel->getProductByid($pr_id);
        
		

        if (!$pr_id) {
            return redirect()->to('product')->with('error', 'product not found');
        }

        $data['product'] = (array) $product;
    }

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
    $available_color = $this->input->getPost('aval_colors');
    $size = $this->input->getPost('size');
    $sleeve_style = $this->input->getPost('sleeve_style');
    $fabric = $this->input->getPost('fabric');
    $stitching = $this->input->getPost('stitching');


    // Validate required fields
    if (!$cat_id || !$product_name || !$product_code || !$mrp) {
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
        'pr_Aval_Colors' => $available_color,
        'pr_Size' => is_array($size) ? implode(',', $size) : '',
        'pr_Sleeve_Style' => $sleeve_style,
        'pr_Fabric' => $fabric,
        'pr_Stitch_Type' => $stitching,
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


public function ProductuploadVideo()
{
    $productId = $this->request->getPost('product_id');
    $videoFile = $this->request->getFile('video');

    // Check if video file is uploaded, valid, and not moved
    if ($videoFile && $videoFile->isValid() && !$videoFile->hasMoved()) {

        // Check file size (max 4MB = 4 * 1024 * 1024 = 4194304 bytes)
        if ($videoFile->getSize() > 4194304) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Your video size is too large. Please upload a video within 4MB.'
            ]);
        }

        // Check MIME type (allow only video formats)
        $allowedMimeTypes = ['video/mp4', 'video/avi', 'video/mpeg', 'video/quicktime', 'video/x-matroska'];
        if (!in_array($videoFile->getMimeType(), $allowedMimeTypes)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Only video files are allowed. Please upload a valid video format.'
            ]);
        }

        // Proceed with storing the file
        $newName = $videoFile->getRandomName();
        $videoFile->move('uploads/productmedia', $newName);

        $productModel = new ProductModel();
        $productModel->updateProductVideo($productId, $newName);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Video uploaded successfully.',
            'video' => $newName
        ]);
    } else {
        return $this->response->setStatusCode(400)->setJSON([
            'status' => 'error',
            'message' => 'Invalid video file.'
        ]);
    }
}





public function deleteVideo()
{
    $request = service('request');
    $productId = $request->getPost('product_id');
    $videoName = $request->getPost('video_name');

    if (!$productId || !$videoName) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Missing product_id or video_name'
        ]);
    }

    // Build the full path
    $filePath = FCPATH . 'uploads/productmedia/' . $videoName;

    if (file_exists($filePath)) {
        if (!unlink($filePath)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete file. Check permissions.'
            ]);
        }
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'File not found on server.'
        ]);
    }

    // Update DB to null the video field
    $productModel = new \App\Models\ProductModel();
    $updateResult = $productModel->deleteProductVideo($productId);

    if ($updateResult) {
        return $this->response->setJSON(['status' => 'success']);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to update database.'
        ]);
    }
}


public function getVideo()
{
    $request = service('request');
    $productId = $request->getPost('product_id');

    $productModel = new \App\Models\ProductModel();
    $product = $productModel->getVideo($productId);

    if ($product && $product->product_video) {
        return $this->response->setJSON([
            'status' => 'success',
            'video' => $product->product_video
        ]);
    }

    return $this->response->setJSON(['status' => 'error', 'message' => 'No video found']);
}

//ChangeStatus

public function changeStatus()
{
	$prId = $this->request->getPost('pr_Id');
	$newStatus = $this->request->getPost('pr_Status');

	$productModel = new ProductModel();
	$product = $productModel->getProductByid($prId);

	if (!$product) {
		return $this->response->setJSON([
			'success' => false,
			'message' => 'Product not found'
		]);
	}

	$update = $productModel->updateProduct($prId, ['pr_Status' => $newStatus]);

	if ($update) {
		return $this->response->setJSON([
			'success' => true,
			'message' => 'Product Status Updated Successfully!',
			'new_status' => $newStatus
		]);
	} else {
		return $this->response->setJSON([
			'success' => false,
			'message' => 'Failed to update status'
		]);
	}
}

















}