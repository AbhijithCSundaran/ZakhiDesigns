<?php
namespace App\Controllers;
use App\Models\Offer_BannerModel;

class Offer_Banner extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->offer_bannerModel = new Offer_BannerModel();
    }

    public function index()
    {
		$banner = $this->offer_bannerModel->getAllBanners();
        $data['user'] = $banner;
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('offer_banner',$data);
		$template.= view('common/footer');
		$template.= view('page_scripts/offer_bannerjs');
        return $template;
    }
 
	public function updateStatus()
	{
		$theId = $this->request->getPost('the_Id');
        $newStatus = $this->request->getPost('the_Status');
        $offer_bannerModel = new Offer_BannerModel();
        $theme = $bannerModel->getThemeByid($theId);   
        if (!$theme) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Theme not found'
            ]);
        }
        $update = $bannerModel->updateTheme($theId, ['the_Status' => $newStatus]);
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
     public function deleteBanner($the_id) {
		if ($the_id) {
			$modified_by = $this->session->get('zd_uid');
			$the_status = $this->offer_bannerModel->deleteBannerById(3, $the_id, $modified_by);
			if ($the_status) {
				echo json_encode([
					'success' => true,
					'msg' => 'Banner deleted successfully.'
				]);
			} else {
				echo json_encode([
					'success' => false,
					'msg' => 'Failed to delete banner.'
				]);
			}
		} else {
			echo json_encode([
				'success' => false,
				'msg' => 'Invalid request.'
			]);
		}
	}
	public function addbanner($the_id = null)
	{
		if (!$this->session->get('zd_uid')) {
			return redirect()->to(base_url());
		}
		//$banner = new Offer_BannerModel();
		$data = [];
		$data['category'] = $this->offer_bannerModel->getAllCategories();
		$banner = null;
		if ($the_id) {	
			$banner = $this->offer_bannerModel->getThemeByid($the_id);
		}
		$data['banner'] = (array) $banner;
		// Load views
		$template = view('common/header');
		$template .= view('common/leftmenu');
		$template .= view('offer_banner_add', $data);
		$template .= view('common/footer');
		$template .= view('page_scripts/offer_bannerjs');
		return $template;
		
	}
	public function getSubcategories()
	{
		$cat_id = $this->request->getPost('cat_id');
		$subcategories = $this->offer_bannerModel->getSubcategoriesByCatId($cat_id);
		
		return $this->response->setJSON($subcategories);
	}
	public function createnew()
	{
		$bannerModel = new Offer_BannerModel();
		$the_id      = $this->request->getPost('the_id');
		$bannerName  = $this->request->getPost('file_name');
		$description = $this->request->getPost('description');
		$image       = $this->request->getFile('banner_image');
		$newName     = null;
		if (!preg_match('/^[a-zA-Z ]+$/', $bannerName)) {
			return $this->response->setJSON(['status' => 'error', 'msg' => 'Please enter name correctly.']);
		}
		// Only process image if it is uploaded
		if ($image && $image->isValid() && !$image->hasMoved()) {
			$newName = $image->getRandomName();
			$image->move(ROOTPATH . 'public/uploads', $newName);
		}

		if (empty($the_id)) {
			// CREATE
			$data = [
				'the_Name'         => $bannerName,
				'the_Description'  => $description,
				'the_Home_Banner'  => $newName ?? '',
				'the_Status'       => 1,
				'the_createdon'    => date("Y-m-d H:i:s"),
				'the_createdby'    => $this->session->get('zd_uid'),
				'the_modifyby'     => $this->session->get('zd_uid')
			];

			$bannerModel->createBanner($data);

			return $this->response->setJSON([
				'status' => 1,
				'msg'    => 'Banner uploaded successfully.'
			]);
		} else {
			// UPDATE
			$existing = $bannerModel->getThemeByid($the_id);

			if (!$existing) {
				return $this->response->setJSON([
					'status' => 0,
					'msg'    => 'Banner not found for update.'
				]);
			}

			$data = [
				'the_Name'         => $bannerName,
				'the_Description'  => $description,
				'the_modifyby'     => $this->session->get('zd_uid')
			];

			// Only update image if a new one was uploaded
			if ($newName) {
				$data['the_Home_Banner'] = $newName;
			} else {
				$data['the_Home_Banner'] = $existing['the_Home_Banner'];
			}

			$bannerModel->modifyBanner($the_id, $data);

			return $this->response->setJSON([
				'status' => 1,
				'msg'    => 'Banner updated successfully.',
				'redirect' => base_url('banner')
			]);
		}
	}


//////////////////////////////////////////////////////////////////

public function ajaxList()
{
  $model = new Offer_BannerModel();

$data = $model->getDatatables();
$total = $model->countAll();
$filtered = $model->countFiltered();

foreach ($data as &$row) {
    // Set default values if null
    $row['category_name'] = $row['category_name'] ?? 'N/A';
    $row['subcategory_name'] = $row['subcategory_name'] ?? 'N/A';

    // Checkbox column
    $row['status_switch'] = '<div class="form-check form-switch">
        <input class="form-check-input checkactive"
               type="checkbox"
               id="statusSwitch-' . $row['the_Id'] . '"
               value="' . $row['the_Id'] . '" ' . ($row['the_Status'] == 1 ? 'checked' : '') . '>
        <label class="form-check-label pl-0 label-check"
               for="statusSwitch-' . $row['the_Id'] . '"></label>
    </div>';

    // Action buttons column
    $row['actions'] = '<a href="' . base_url('offer_banner/add/' . $row['the_Id']) . '">
            <i class="bi bi-pencil-square"></i>
        </a>&nbsp;
        <i class="bi bi-trash text-danger icon-clickable"
           onclick="confirmDelete(' . $row['the_Id'] . ')"></i>';
}

return $this->response->setJSON([
    'draw' => intval($this->request->getPost('draw')),
    'recordsTotal' => $total,
    'recordsFiltered' => $filtered,
    'data' => $data
]);

}


///////////////////////////////////////////////





}

