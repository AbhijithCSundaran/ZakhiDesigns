<?php

namespace App\Controllers;
use App\Models\CustomerLoginModel;


class Weblogin extends BaseController
{
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->input = \Config\Services::request();
		$this->customerLoginModel = new CustomerLoginModel();
	}

	public function index(): string
	{
		return view('forgot_password');
	}

}