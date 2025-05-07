<?php
namespace App\Controllers;
use App\Models\CustomerModel;
class Customer_address extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        $customer = $this->customerModel->getAllCustomer_address();
        $data['user'] = $customer;
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('Customer_address', $data);
		$template.= view('common/footer');
		$template.= view('page_scripts/customerjs');
        return $template;

        
    }

}


