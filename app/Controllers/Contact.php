<?php
namespace App\Controllers;
use App\Controllers\BaseController;
//use App\Models\DeliveryModel;

class Contact extends BaseController {

	public function __construct() {
		$this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        //$this->product_model = new ProductModel();
	}
	
	public function index() {
	
		if (!$this->session->get('zd_uid')) {
			return redirect()->to(base_url());
		}
		$template = view('common/header');
		$template.= view('contact');
		$template.= view('common/footer');      
		return $template;
	
	}

}
