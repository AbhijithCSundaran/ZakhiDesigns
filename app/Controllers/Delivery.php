<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\DeliveryModel;

class Delivery extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->DeliveryModel = new \App\Models\DeliveryModel();
    }

    public function index()
    {

        $alldelivery = $this->DeliveryModel->getAllDelivery();
        $data['delivery'] =  $alldelivery;
        // print_r($data['delivery']);
        // exit;
        $template = view('Admin/common/header');
		$template.= view('Admin/common/leftmenu');
		$template.= view('Admin/delivery', $data);
        $template.= view('Admin/common/footer');
        $template.= view('Admin/page_scripts/deliveryjs');
        return $template;

        
    }
}