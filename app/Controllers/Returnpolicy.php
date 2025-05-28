<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ReturnpolicyModel;

class Returnpolicy extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->ReturnpolicyModel = new \App\Models\ReturnpolicyModel();
    }

    public function index()
    {

        $allreturnpolicyModel = $this->ReturnpolicyModel->getAllReturnpolicyModel();
        $data['returnpolicy'] =  $allreturnpolicy;
        // print_r($data['returnpolicy']);
        // exit;
        $template = view('Admin/common/header');
		$template.= view('Admin/common/leftmenu');
		$template.= view('Admin/returnpolicy', $data);
        $template.= view('Admin/common/footer');
        $template.= view('Admin/page_scripts/returnpolicyjs');
        return $template;

        
    }
}