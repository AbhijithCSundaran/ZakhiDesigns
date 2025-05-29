<?php
namespace App\Controllers;
use App\Controllers\BaseController;



class AboutUs extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
    }

    public function index()
    {
        $template = view('common/header');
		$template.= view('aboutus');
        $template.= view('common/footer');
        return $template;

        
    }
}