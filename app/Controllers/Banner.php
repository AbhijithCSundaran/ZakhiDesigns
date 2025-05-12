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
    public function addProductImage($pri_id = null)
    {
        if (!$this->session->get('zd_uid')) {
            return redirect()->to(base_url());
        }
    
        $data = [];
        $data['products'] = $this->productimageModel->getAllProducts();
        
        $template = view('common/header');
        $template .= view('common/leftmenu');
        $template .= view('productimage_add',$data); 
        $template .= view('common/footer');
        $template .= view('page_scripts/productimagejs');
        return $template;
    }
	public function updateStatus()
	{
		$custId = $this->request->getPost('cust_Id');
        $newStatus = $this->request->getPost('cust_Status');
    
        $customerModel = new CustomerModel();
        $customer = $customerModel->getCustomerByid($custId);
    
        if (!$customer) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Customer not found'
            ]);
        }
        $update = $customerModel->updateCustomer($custId, ['cust_Status' => $newStatus]);
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
    
   









}
