<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ReturnpolicyModel;

class Returnpolicy extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        
    }

    public function index()
    {

        // print_r($data['returnpolicy']);
        // exit;
        $template = view('common/header');
		$template.= view('returnpolicy');
        //$template.= view('common/footer');
       
        return $template;

        
    }
}