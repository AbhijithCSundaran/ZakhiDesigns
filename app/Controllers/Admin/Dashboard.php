<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Dashboard extends BaseController 
{
	  
	public function __construct() 
	{
		$this->session = \Config\Services::session();
		$this->input = \Config\Services::request();

	}
	public function index()
	{
	
	 	if (!$this->session->get('zd_uid')) {
			redirect()->to(base_url());
         }

			$template = view('Admin/common/header');
			$template.= view('Admin/common/leftmenu');
			$template.= view('Admin/dashboard');
			$template.= view('Admin/common/footer');
			return $template;
		
	}
}