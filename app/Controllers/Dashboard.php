<?php
namespace App\Controllers;

class Dashboard extends BaseController 
{
	  
	public function __construct() 
	{
		$this->session = \Config\Services::session();
		$this->input = \Config\Services::request();
  // Load model here
    }
	public function index(): string
	{

		if (!$this->session->get('zd_uid')) {
			return redirect()->to(base_url());
        }

		$template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('dashboard.php');
		$template.= view('common/footer');
        return $template;
		
	}
}