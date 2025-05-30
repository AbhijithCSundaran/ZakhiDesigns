<?php
namespace App\Controllers;
use App\Controllers\BaseController;


class Privacypolicy extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        
    }

    public function index()
    {
        
        // print_r($data['privacypolicy']);
        // exit;
        $template = view('common/header');
		$template.= view('Privacypolicy');
        // $template.= view('common/footer');
        return $template;

        
    }
}