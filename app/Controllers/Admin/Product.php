<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\ProductModel;

class Product extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->productModel = new \App\Models\Admin\ProductModel();
    }

    public function index()
    {

        $allproducts = $this->productModel->getAllProducts();
		$data['product'] =  $allproducts;
        
      

        $template = view('Admin/common/header');
		$template.= view('Admin/common/leftmenu');
		$template.= view('Admin/product', $data);
        $template.= view('Admin/product_add_modal');
        $template.= view('Admin/product_video_modal');
		$template.= view('Admin/common/footer');
        $template .= view('Admin/page_scripts/productjs');
        return $template;

    }
//Product Data List ajax // Listing table data
	public function ajaxList()
	{
	$model = new \App\Models\Admin\ProductModel();
	$data = $model->getDatatables();
	$total = $model->countAll();
	$filtered = $model->countFiltered();

	foreach ($data as &$row) {
		// Default fallbacks
		$row['pr_Name'] = $row['pr_Name'] ?? 'N/A';
		$row['mrp'] = $row['mrp'] ?? 'N/A';
		$row['pr_Selling_Price'] = $row['pr_Selling_Price'] ?? 'N/A';
		$row['pr_Discount_Value'] = $row['pr_Discount_Value'] ?? 'N/A';
		$row['pr_Stock'] = $row['pr_Stock'] ?? 'N/A';
	
		
		// Status toggle switch
		$row['status_switch'] = '<div class="form-check form-switch">
			<input class="form-check-input checkactive"
				   type="checkbox"
				   id="statusSwitch-' . $row['pr_Id'] . '"
				   value="' . $row['pr_Id'] . '" ' . ($row['pr_Status'] == 1 ? 'checked' : '') . '>
			<label class="form-check-label pl-0 label-check"
				   for="statusSwitch-' . $row['pr_Id'] . '"></label>
		</div>';

		// Action buttons
		$row['actions'] = '
		<a href="' . base_url('admin/product/edit/' . $row['pr_Id']) . '">
			<i class="bi bi-pencil-square"></i>
		</a>&nbsp;
		<i class="bi bi-trash text-danger icon-clickable"
		   onclick="confirmDelete(' . $row['pr_Id'] . ')"></i>&nbsp;
       
		<img class="img-size open-image-modal"
			 src="' . base_url(ASSET_PATH . 'admin/assets/images/image_add.ico') . '"
			 alt="Image-add"
			 data-toggle="modal"
			 data-target="#exampleModal"
			 data-product-id="' . $row['pr_Id'] . '"
			 data-product-name="' . htmlspecialchars($row['pr_Name'], ENT_QUOTES) . '"
			 onclick="openProductModal(' . $row['pr_Id'] . ', \'' . addslashes($row['pr_Name']) . '\')"
			 style="cursor: pointer;">&nbsp;
			 
		<img class="img-size open-video-modal"
			 src="' . base_url(ASSET_PATH . 'admin/assets/images/video_add.ico') . '"
			 alt="Video-add"
			 data-toggle="modal"
			 data-target="#videoModal"
			 data-product-id="' . $row['pr_Id'] . '"
			 data-product-name="' . htmlspecialchars($row['pr_Name'], ENT_QUOTES) . '"
			 onclick="openvideoModal(' . $row['pr_Id'] . ', \'' . addslashes($row['pr_Name']) . '\')"
			 style="cursor: pointer;">';

	}
	
	return $this->response->setJSON([
		'draw' => intval($this->request->getPost('draw')),
		'recordsTotal' => $total,
		'recordsFiltered' => $filtered,
		'data' => $data
	]);
	}


//Product Add
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
            return redirect()->to('admin/product')->with('error', 'product not found');
        }

        $data['product'] = (array) $product;
    }

    $template = view('Admin/common/header');
    $template .= view('Admin/common/leftmenu');
    $template .= view('Admin/product_add', $data);
    $template .= view('Admin/common/footer');
    $template .= view('Admin/page_scripts/productjs');
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
    $product_name = trim($this->input->getPost('product_name'));
    $product_code = trim($this->input->getPost('product_code'));
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

   
    if (empty($cat_id) || empty($product_name) || empty($product_code) || empty($mrp)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'All required fields must be filled.'
        ]);
    }

   
    $exists = $this->productModel->isProductExists($product_name, $pr_id);
    if ($exists) {
        return $this->response->setJSON([
            'status' => 'error',
            'field' => 'product_name',
            'message' => 'Product name already exists.'
        ]);
    }

    
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
        // Insert new product
        $data['pr_createdon'] = date("Y-m-d H:i:s");
        $data['pr_createdby'] = $this->session->get('zd_uid');

        $this->productModel->productInsert($data);

        return $this->response->setJSON([
            'status' => 1,
            'msg' => 'Product created successfully.',
            'redirect' => base_url('admin/product')
        ]);
    } else {
        // Update existing product
        $this->productModel->updateProduct($pr_id, $data);

        return $this->response->setJSON([
            'status' => 1,
            'msg' => 'Product updated successfully.',
            'redirect' => base_url('admin/product')
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
    $productModel = new \App\Models\Admin\ProductModel();
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

        $productModel = new \App\Models\Admin\ProductModel();
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
    $productModel = new \App\Models\Admin\ProductModel();
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

    $productModel = new \App\Models\Admin\ProductModel();
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

	$productModel = new \App\Models\Admin\ProductModel();
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