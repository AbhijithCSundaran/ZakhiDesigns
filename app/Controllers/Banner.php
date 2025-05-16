<?php
namespace App\Controllers;
use App\Models\BannerModel;

class Banner extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->bannerModel = new BannerModel();
    }

    public function index()
    {
		$banner = $this->bannerModel->getAllBanners();
        $data['user'] = $banner;
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('banners',$data);
		$template.= view('common/footer');
		$template.= view('page_scripts/bannerjs');
        return $template;
    }
 
	public function updateStatus()
	{
		$theId = $this->request->getPost('the_Id');
        $newStatus = $this->request->getPost('the_Status');
        $bannerModel = new BannerModel();
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
			$the_status = $this->bannerModel->deleteBannerById(3, $the_id, $modified_by);
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
		if (!$this->session->get('zd_uid')) 
		{
			return redirect()->to(base_url());
		}

		$data = [];
		 if ($the_id) {
			$banner = $this->bannerModel->getThemeByid($the_id);
		
			if (!$banner) {
				return redirect()->to('banner')->with('error', 'Banner not found');
			}
			 $data['banner'] = (array) $banner;
			
			// Load views
			$template = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('banner_add', $data);
			$template .= view('common/footer');
			$template .= view('page_scripts/bannerjs');
			return $template;
		}
		else
		{
			// Load views
			$template = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('banner_add');
			$template .= view('common/footer');
			$template .= view('page_scripts/bannerjs');
			return $template;
		}
		
	}
	public function createnew()
	{
		$bannerModel = new BannerModel();

		$the_id      = $this->request->getPost('the_id');
		$bannerName  = $this->request->getPost('file_name');
		$description = $this->request->getPost('description');
		$image       = $this->request->getFile('banner_image');
		$newName     = null;

		// Validate name format
		if (!preg_match('/^[a-zA-Z ]+$/', $bannerName)) {
			return $this->response->setJSON(['status' => 'error', 'msg' => 'Please enter name correctly.']);
		}

		// Check if image is uploaded
		if ($image && $image->getError() == UPLOAD_ERR_OK && !$image->hasMoved()) {
			$newName = $image->getRandomName();
			$image->move(ROOTPATH . 'public/uploads', $newName);
		}
		if($bannerName && $newName) {
		// Create
		if (empty($the_id)) {
			$data = [
				'the_Name'         => $bannerName,
				'the_Description'  => $description,
				'the_Home_Banner'  => $newName ?? '',
				'the_Status'       => 1,
				'the_createdon'    => date("Y-m-d H:i:s"),
				'the_createdby'    => $this->session->get('zd_uid'),
				'the_modifyby'     => $this->session->get('zd_uid'),
			];

			$bannerModel->createBanner($data);

			return $this->response->setJSON([
				'status' => 1,
				'msg'    => 'Banner uploaded successfully.'
			]);
		} 
		
		// Update
		else {
			$existing = $bannerModel->getThemesByid($the_id);
			
				if (!$existing) {
				return $this->response->setJSON([
					'status' => 0,
					'msg'    => 'Banner not found for update.'
				]);
			}
			
			
			if ($newName && !empty($existing->the_Home_Banner)) {
        $oldPath = ROOTPATH . 'public/uploads/' . $existing->the_Home_Banner;
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }


		

			$data = [
				'the_Name'         => $bannerName,
				'the_Description'  => $description,
				'the_modifyby'     => $this->session->get('zd_uid'),
				//'the_Home_Banner'  => $newName ?? $existing['the_Home_Banner']  // retain old name if no new image
			   	'the_Home_Banner' => $newName ?? $existing->the_Home_Banner

			];

			$bannerModel->modifyBanner($the_id, $data);

			return $this->response->setJSON([
				'status'   => 1,
				'msg'      => 'Banner updated successfully.',
				'redirect' => base_url('banner')
			]);
		}
	}
		else {
			return $this->response->setJSON([
				'status' => 'error',
				'msg' => 'All mandatory fields are required.'
			]);
		}
	}



}

