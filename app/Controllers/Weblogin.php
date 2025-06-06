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

		return view('weblogin');
		
	}

	public function webReg()
	{
		return view('webregister');
		   
	}
	public function customerAuthen()
	{
		$email = $this->request->getPost('cust_Email');
		$password = md5($this->request->getPost('cust_Password'));
		if ($email && $password) {
			$userLog = $this->customerLoginModel->getLoginAccount($email, $password);
			if ($userLog) {
				$this->session->set([
					'zd_uid' => $userLog->cust_Id,
					'zd_uname' => $userLog->cust_Name,
					'role' => 'user',
				]);

				echo json_encode(array(
					"status" => 1,
					"msg" => null
				));
			} else {
				echo json_encode([
					"status" => 0,
					"msg" => "Invalid user. Please sign up."
				]);
			}
		} else {
			echo json_encode(array(
				"status" => 0,
				"msg" => "Login credentials are mandatory"
			));
		}

	}


	public function logout()
	{
		$session = session();
		$session->remove(['zd_uid', 'zd_uname']);
		return redirect()->to(base_url('/'));
	}


}