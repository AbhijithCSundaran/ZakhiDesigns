<?php
namespace App\Controllers;

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

			$template = view('common/header');
			$template.= view('common/leftmenu');
			$template.= view('dashboard.php');
			$template.= view('common/footer');
			return $template;
		
	}
}