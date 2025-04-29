<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login');
    }

	// public function dashboard(): string
    // {
	// 	$template = view('common/header');
	// 	$template.= view('common/leftmenu');
	// 	$template.= view('dashboard');
	// 	$template.= view('common/footer');
    //     return $template;
    // }
}
