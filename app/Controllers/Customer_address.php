<?php
namespace App\Controllers;
use App\Models\AddressModel;
class Customer_address extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->addressModel = new AddressModel();
    }

    public function index()
    {
        $customer = $this->addressModel->getAllCustomer();
        $data['user'] = $customer;
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('customer_address', $data);
		$template.= view('common/footer');
		//$template.= view('page_scripts/customerjs');
        return $template;

        
    }

}


