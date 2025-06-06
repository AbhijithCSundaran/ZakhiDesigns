<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\DashboardModel;


class Dashboard extends BaseController 
{
	  
	public function __construct() 
	{
		$this->session = \Config\Services::session();
		$this->input = \Config\Services::request();
		$this->dashboardModel = new \App\Models\Admin\DashboardModel();

	}
	public function index()
	{
	
	 	if (!$this->session->get('ad_uid')) {
			redirect()->to(base_url());
         }
            $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
			$latestOrderCount = $this->OrdersModel
        ->where('od_createdon >=', $sevenDaysAgo)
        ->countAllResults();

			$template = view('Admin/common/header');
			$template.= view('Admin/common/leftmenu');
			$template.= view('Admin/dashboard',['latestOrderCount' => $latestOrderCount]);
			$template.= view('Admin/common/footer');
			return $template;
		
	}
}