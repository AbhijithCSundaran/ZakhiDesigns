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

    $image = $this->request->getFile('banner_image');

    if ($image && $image->isValid() && !$image->hasMoved()) {
        $newName = $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads', $newName);

        // Get additional form data properly (CI4 syntax)
        $the_id         = $this->request->getPost('the_id');
        $bannerName     = $this->request->getPost('file_name');
        $description    = $this->request->getPost('description');

        // Save to database (assuming you have a BannerModel)
        //$model = new \App\Models\BannerModel();
        $data([
            'the_id'      		 => $the_id,
            'the_Home_Banner'    => $newName,
            'file_name'   => $bannerName,
            'description' => $description,
        ]);

        return $this->response->setJSON([
            'status' => 1,
            'msg'    => 'Image and data uploaded successfully.',
        ]);
    }

    // Return error if file is not valid
    return $this->response->setJSON([
        'status' => 0,
        'msg'    => 'Image upload failed or no file selected.',
    ]);


	}
}

