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
        
        
        $template = view('common/header');
<<<<<<< HEAD
		$template.= view('privacypolicy');
=======
		$template.= view('Privacypolicy');
>>>>>>> 2ed9d05a44738f7647b1eec4f58666263896b81f
        $template.= view('common/footer');
        return $template;

        
    }
	
}