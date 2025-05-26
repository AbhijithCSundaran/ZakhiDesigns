<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PrivacypolicyModel;

class Privacypolicy extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->PrivacypolicyModel = new \App\Models\PrivacypolicyModel();
    }

    public function index()
    {

        $allprivacypolicy = $this->PrivacypolicyModel->getAllPrivacypolicy();
        $data['privacypolicy'] =  $allprivacypolicy;
        // print_r($data['privacypolicy']);
        // exit;
        $template = view('Admin/common/header');
		$template.= view('Admin/common/leftmenu');
		$template.= view('Admin/privacypolicy', $data);
        $template.= view('Admin/common/footer');
        $template.= view('Admin/page_scripts/privacypolicyjs');
        return $template;

        
    }
}