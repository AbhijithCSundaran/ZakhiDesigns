<?php
namespace App\Controllers;
use App\Controllers\BaseController;


class Delivery extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        
    }

    public function index()
    {
        
       

        $template = view('common/header');
		$template.= view('delivery');
        $template.= view('common/footer');
        return $template;

        
    }
}