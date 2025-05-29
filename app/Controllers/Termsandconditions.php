<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\TermsandconditionsModel;

class Termsandconditions extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        
    }

    public function index()
    {

        // print_r($data['termsandconditions']);
        // exit;
        $template = view('common/header');
		$template.= view('termsandconditions');
        //$template.= view('common/footer');
       
        return $template;

        
    }
}